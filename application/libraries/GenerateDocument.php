<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_GenerateDocument extends CI_DataManager {
	var $request;
	var $prefix;
	var $document_type = null;
	var $document_map = null;
	var $data_path = null;
	var $image_path = null;
	var $document_path = null;
	var $document_name = null;
	var $document_table = null;
	var $document_identifier = null;
	var $document_config_identifier = null;
	var $document_services_table = null;
	var $document_items_table = null;
	var $auxiliary_table = null;
	var $auxiliary_table_key = null;
	var $signature_image = null;
	var $pdf_document = null;
	var $pdf_name = null;
	var $page_array = array();
	var $contract_array = null;
	var $item_array = array();
	var $services_array = array();
	var $ext_group = array();
	var $extensible_array = null;
	var $extensible_map = array();
	var $extensible_key_field = null;
	var $extended_fields = array();
	var $key = null;
	var $new_id = null;
	var $attachment_contents = null;
	var $services_block_count = null;
	
	public function __construct() 
	{
		$this->load->database();
		$this->load->helper('json');
		$this->load->helper('path');
		$this->load->helper('signature_to_image');
		$this->load->library('Utilities');
		$this->load->library('Mailer');
		$this->load->library('NameParser');
		$this->load->library('ParseImagemap');
		$this->config->load('tcpdf');
		$this->config->load('ct_office');
		
		$this->prefix = $this->config->item('prefix');
		$this->document_table = $this->config->item('document.table');
		$this->document_services_table = $this->config->item('document.services.table');
		$this->services_block_count = $this->config->item($this->prefix . '.services_block.count');
		$this->document_items_table = $this->config->item('document.items.table');
		$this->data_path = $this->config->item('data.path');
		$this->image_path = $this->config->item('image.path');
		$this->document_path = $this->config->item('document.path');
		$this->key = md5($this->config->item('rc4.seed'));
	}
	
	//*** Magic method __get gives us access to the parent CI object
    public function __get($var)    
    {
        static $CI;
        (is_object($CI)) OR $CI = get_instance();
        return $CI->$var;
    }
	
	public function parse_request($request)
	{
		//echo var_dump($request);
		if (sizeof($request) == 0) {
			$request = $_REQUEST;
		}
		$this->request = $request;
		switch($this->get_request('type'))
		{
			case "GET_key" :
				$key_hash = md5($this->config->item('rc4.seed'));
				echo $key_hash;
				break;
			case "SAVE_document" :
				//*** Get the document type (e.g., 'my_contract')
				$this->document_type = $this->get_request('contract_type');
				$this->document_config_identifier = $this->get_request('document_identifier');
				//*** Create the identifier from document_identifier filed and date
				$this->document_identifier = "_" . $this->document_config_identifier . "_" . date("m-d-Y",time());
				//*** Get fields from the main contracts table
				$this->contract_array = $this->get_request(null, $this->document_table);
				//*** Get data for blocks of services
				for ($i=1; $i<=$this->services_block_count; $i++) {
					$this->services_array[] = $this->get_request(null, $this->document_services_table, $i);
				}
				$this->item_array = $this->get_request(null, $this->document_items_table);
				$this->auxiliary_table = $this->config->item($this->prefix . "." . $this->document_type . '.auxiliary.table');
				$this->auxiliary_table_key = $this->config->item($this->prefix . "." . $this->document_type . '.auxiliary.table.key');
				//*** Get arrays of fields from the form that will be used in both the auxiliary table and the PDF file
				$this->extensible_array = $this->config->item($this->prefix . "." . $this->document_type . '.extensible.array');
				
				//*** Retrieve the image map data
				$this->document_map = $this->get_document_map();
				//*** Add extensible fields, if any
				if ($this->extensible_array != "")
				{
					$this->extensible_key_field = $this->config->item($this->prefix . "." . $this->document_type . '.extensible.key.field');
					foreach ($this->extensible_array as $ext)
					{
						$this->ext_group[$ext] = $this->get_request_group($ext . "_");
						$new_items = $this->add_extensible_fields($this->ext_group[$ext], $this->document_map, $this->extensible_key_field);
						$this->extensible_map += $new_items;
					}
				}

				$success = $this->save_contract();
				if ($success)
				{
					//*** Get customer name from query and convert to lower case, underscore and no not-alpha characters
					$customer_name = $this->get_request('billing_customer_name');
					$customer_name = ($customer_name == "") ? "error" : $customer_name;
					$customer_name = strtolower(str_replace(" ","_",$customer_name));
					$customer_name = preg_replace("/[^a-z_]/","",$customer_name);
					
					//*** Build name of PDF file
					$this->pdf_name = $customer_name . $this->document_identifier . ".pdf";
					
					//*** Get the required emails.  NOTE: It will bomb horribly of you don't pass these emails correctly!
					$customer_email = $this->get_request('customer_email');
					$office_email = $this->config->item($this->prefix . "." . 'home.office.email');
					$account_representative = $this->get_request('account_representative');
					$rep_array = $this->config->item($this->prefix . "." . 'representatives');
					$rep_email = (array_key_exists($account_representative, $rep_array)) ? $rep_array[$account_representative] : null;
					
					$success = $this->generate_signature($this->get_request('signature_encrypted'),$customer_name);
					if ($success)
					{
						//*** Get all page file names to be used in document
						$i = 1;
						do 
						{
							$page_name = $this->config->item($this->prefix . "." . $this->document_type . '.page.' . $i++);
							if ($page_name != "")
							{
								$this->page_array[] = $page_name;
							}
						}
						while ($page_name != "");
						
						$success = $this->generate_pdf_file($customer_name);
						if ($success)
						{
							$from_email = $this->config->item($this->prefix . "." . 'from.email');
							$to_email = $customer_email;
							$to_email .= (!is_null($rep_email)) ? ", " . $rep_email : "";
							$file_name = $this->data_path . "/" . $this->pdf_document;
							$file =	file_get_contents($file_name);	 	 
							$this->attachment_contents = chunk_split(base64_encode($file));
							
							
							//*** Send copy and notification to office
							$body = $this->config->item($this->prefix . "." . 'to.office.contract.email.body');
							$body = $this->utilities->replace_vars($body,$this->contract_array);
							$subject = $this->config->item($this->prefix . "." . 'to.office.contract.email.subject');
							$subject = $this->utilities->replace_vars($subject,$this->contract_array);
		
							//$mail_sent = $this->send_email($from_email, $office_email, $subject, $body, $this->data_path, $this->pdf_document);
							$mail_sent = $this->send_email_new($from_email, $office_email, $subject, $body, $file_name);
							
							//*** Send contract to customer
							$body = $this->config->item($this->prefix . "." . 'to.customer.contract.email.body');
							$body = $this->utilities->replace_vars($body,$this->contract_array);
							$subject = $this->config->item($this->prefix . "." . 'to.customer.contract.email.subject');
							$subject = $this->utilities->replace_vars($subject,$this->contract_array);
							//echo "From: " . $from_email . " - To: " . $customer_email."\n";
							//return;
							//$mail_sent = $this->send_email($from_email, $to_email, $subject, $body, $this->data_path, $this->pdf_document);
							$mail_sent = $this->send_email_new($from_email, $to_email, $subject, $body, $file_name);
							//$mail_sent = "MAIL SENT";
						}
						$success = ($mail_sent == "MAIL SENT") ? "SUCCESS" : "ERROR: Can't send email";
						
					}
				}
				$this->echo_output($success);
				//*** Clean up (delete signature file)
				unlink($this->signature_image_path);
				break;
		}
	}
	
	public function echo_output($data)
	{
		echo $data;
	}
	
	public function save_contract()
	{
		$success = false;
		$this->db->save_queries = false;
		if ($this->contract_array['contract_id'] == "0")
		{
			//*** Do a little pre-save tweaking
			$data_types = $this->get_data_types('cto_contracts');
			foreach ($this->contract_array as $field => $value)
			{
				$suffix = "";
				switch ($data_types[$field])
				{
					case "decimal" :
					case "date" :
						$value = str_replace(array("$",","),"",$value);
						break;
					case "signature" :
						$value = $this->utilities->rc4($this->key,$value);
				}
				$this->contract_array[$field] = $value;
			}
			
			$this->db->insert('cto_contracts', $this->contract_array);
			$new_contract_id = $this->db->insert_id();
			
			//*** Save checked items in a separate table
			$this->save_contract_items($new_contract_id, $this->item_array);
			
			//*** Save blocks of services in a separate table
			$this->save_contract_services($new_contract_id, $this->services_array);
						
			if (sizeof($this->ext_group) > 0)
			{
				$data_array = array();
				$columns = $this->get_columns($this->auxiliary_table );
				$first = null;
				foreach ($columns as $field)
				{
					switch ($field)
					{
						default :
							if (array_key_exists($field, $this->ext_group))
							{
								$first = (is_null($first)) ? $field : $first;
								$i = 0;
								foreach ($this->ext_group[$field] as $key => $value) 
								{
									if ($value != "" && !is_null($value))
									{
										$new = array($field => $this->correct_for_type($field, $value, $this->auxiliary_table ));
										if (!isset($data_array[$i]))
										{	
											$data_array[$i] = array('contract_id' => $new_contract_id);
											$data_array[$i] += $new;
										}
										else
										{
											$data_array[$i] += $new;
										}
									}
									$i++;
								}
							}
							break;
					}
				}
				$len = sizeof($data_array);
				for ($i=0; $i<$len; $i++)
				{
					$data = $data_array[$i];
					$this->db->insert($this->auxiliary_table ,$data);
					//echo var_dump($data);
				}
			}
			$success = true;
		}
		else
		{
			//*** No update mechanism for now.
		}
		return $success;
	}
	
	private function save_contract_items($new_id, $item_array)
	{
		//*** Set returned id into array of 'contract items'.
		$item_array['contract_id'] = $new_id;
		//*** Do tweaking as above
		$data_types = $this->get_data_types('cto_contract_items');
		foreach ($item_array as $field => $value)
		{
			$data_type = preg_replace("/[^A-Za-z_]/","",$data_types[$field]);
			switch ($data_type)
			{
				case "decimal" :
				case "date" :
					$value = str_replace(array("$",","),"",$value);
					break;
				case "tinyint" :
					$value = ($value === "1" OR $value === "on") ? "1" : "0";
					break;
			}
			$item_array[$field] = $value;
		}
		$this->db->insert('cto_contract_items', $item_array);
		$new_id = $this->db->insert_id();
	}
	
	private function save_contract_services($new_id, $services_array)
	{
		$suffix_number = 1;
		foreach ($services_array as $services)
		{
			//*** Set returned id into array of services.
			$services['contract_id'] = $new_id;
			//*** Set suffix_number for later use in recreating contract.
			$services['suffix_number'] = $suffix_number;
			//*** Do tweaking as above
			$data_types = $this->get_data_types($this->document_services_table);
			foreach ($services as $field => $value)
			{
				$data_type = preg_replace("/[^A-Za-z_]/","",$data_types[$field]);
				switch ($data_type)
				{
					case "date" :
						$value = str_replace(array("$",","),"",$value);
						break;
					case "tinyint" :
						$value = ($value === "1" OR $value === "on") ? "1" : "0";
						break;
				}
				$services[$field] = $value;
			}
			$this->db->insert($this->document_services_table, $services);
			$new_id = $this->db->insert_id();
			$suffix_number++;
		}
	}
	
	private function get_document_map()
	{
		return $this->parseimagemap->read_map($this->document_type,"integer");
	}
	
	private function get_numeric_suffix($field_name)
	{
		return end(explode("_", $field_name));
	}
	
	private function generate_pdf_file($customer_name)
	{
		$data_array = array_merge($this->contract_array, $this->item_array);
		//*** Add any services arrays we find
		$suffix = 1;
		foreach ($this->services_array as $service_array)
		{
			//*** Re-add suffixes to keys so that they match with the fields in the map
			$suffixed_array = array();
			foreach ($service_array as $field => $value)
			{
				$suffixed_array[$field . "_" . $suffix] = $value;
			}
			//*** Append to the data_array
			$data_array += $suffixed_array;
			$suffix++;
		}

		$cover_ups = $this->config->item($this->prefix . "." . $this->document_type . "." . 'coverup.fields');
		if ($cover_ups != "")
		{
			$data_array = array_merge($data_array, $cover_ups, $this->extended_fields);
		}
		//echo var_dump($data_array);
		
		require_once($this->config->item('base_path') . $this->config->item('tcpdf.config.lang.location') . 'eng.php');
		require_once($this->config->item('base_path') . $this->config->item('tcpdf.location') . 'tcpdf.php');
		$divisor = $this->config->item('pdf.divisor');
		
		// create new PDF document
		$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		// set document information
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor($customer_name);
		$pdf->SetTitle('Century Termite and Pest Control ' . strtoupper($this->document_identifier));
		
		// set default header data
		
		// set header and footer fonts
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		
		// set default monospaced font
		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		
		//set margins
		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
		
		//set auto page breaks
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
		
		//set image scale factor
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
		
		//set some language-dependent strings
		$pdf->setLanguageArray($l);
		
		// ---------------------------------------------------------
		
		// set JPEG quality
		//$pdf->setJPEGQuality(75);
		
		$pdf->SetFont('helvetica', '', 8);
		
		// add a page
		$pdf->AddPage();
		
		//*** Insert image of first page
		$pdf->Image($this->document_path . $this->page_array[0] . '.png', 0, 0, 250, '', '', '', '', false, 300);
		//*** Insert signature file
		if (file_exists($this->signature_image_path))
		{
			$signature_top = $this->config->item($this->prefix . '.' . $this->document_config_identifier . '.signature.top');
			$pdf->Image($this->signature_image_path, 10, $signature_top, 80, '', '', '', '', false, 300);
		}
		//echo var_dump($this->document_map);
		//*** Build document from image map data and input from REQUEST
		foreach ($this->document_map as $field => $map_item)
		{
			$x = ($this->document_map[$field]['coords']['x'] / $divisor);
			$y = ($this->document_map[$field]['coords']['y'] / $divisor);
			$width = ($this->document_map[$field]['coords']['width'] / $divisor);
			$height = ($this->document_map[$field]['coords']['height'] / $divisor);
			
			$field_name = $this->document_map[$field]['field_name'];
			$field_type = $this->document_map[$field]['field_type'];
			if (isset($data_array[$field_name]))
			{
				$is_text = FALSE;
				$alignment = 'L';
				$value =  $data_array[$field_name];
				//echo $field_type."\n";
				switch ($field_type)
				{
					case "coverup" :
						$pdf->Rect($x, $y, $width, $height, 'F', 'B', array(255,255,255));
						break;
					case "date" :
						$alignment = 'C';
						$value = date('m/d/Y', strtotime($value));
						$is_text = ($value != "");
						break;
					case "my_date" :
						$alignment = 'C';
						$value = date('m/Y', strtotime($value));
						$is_text = ($value != "");
						break;
					case "textarea" :
						$pdf->writeHTMLCell($width, $height, $x, $y, $value);
						break;
					case "dollar_text" :
						$alignment = 'R';
						$value = "$" . str_replace("$","",$value);
					case "numeric_text" :
						$alignment = 'R';
						$is_text = ($value != "");
						break;
					case "hidden_text" :
						$is_text = (strlen($value) > 0);
					case "text" :
					case "cc_text" :
					case "phone_text" :
					case "zip_text" :
					case "select" :
						$is_text = TRUE;
						break;
					case "checkbox" :
					case "service_checkbox" :
						if ($value == "on")
						{
							$pdf->Image($this->image_path . "/check_x.png", $x + 1.0, $y + 1.0, 2.5, 2.5);
						}
						break;
				}
				if ($is_text)
				{
					$pdf->writeHTMLCell($width, $height, $x, $y + 1.0, $value, 0, 0, false, true, $alignment);
				}
				//*** For debugging, un-comment the echo field
				if ($field_name != "signature")
				{
					//echo $field_name . " = " . $value . "\n";
				}
				//unset($this->document_map[$field]);
			}
		}
		
		$this->pdf_extensible_fields($pdf, $data_array, $divisor);
		//*** Additional pages, if any, are added here
		for ($i=1; $i<sizeof($this->page_array); $i++) {
			$pdf->AddPage();
			$pdf->Image($this->document_path . $this->page_array[$i] . '.png', 0, 0, 250, '', '', '', '', false, 300);
		}
		//Close and output PDF document
		$this->pdf_document = $this->pdf_name;
		$retval = $pdf->Output($this->data_path . "/" . $this->pdf_document, 'F');
		
		return ($retval == "");
	}
	
	private function pdf_extensible_fields(&$pdf, $data_array, $divisor)
	{
		$tops = array();
		$v_space = 0.8;
		foreach ($this->extensible_map as $field => $map_item)
		{
			$x = ($this->extensible_map[$field]['coords']['x'] / $divisor);
			$y = ($this->extensible_map[$field]['coords']['y'] / $divisor);
			$width = ($this->extensible_map[$field]['coords']['width'] / $divisor);
			$height = ($this->extensible_map[$field]['coords']['height'] / $divisor);
			
			$field_name = $this->extensible_map[$field]['field_name'];
			$field_type = $this->extensible_map[$field]['field_type'];
			$move_down = array();
			if (isset($data_array[$field_name]))
			{
				$is_text = FALSE;
				$value =  $data_array[$field_name];
				$suffix_int = $this->get_suffix_number($field_name);
				switch ($field_type)
				{
					case "extensible_textarea" :
						$y = (isset($tops[$suffix_int])) ? $tops[$suffix_int] : $y;
						$pdf->writeHTMLCell($width, $height, $x, $y, $value);

						//*** writeHTMLCell automatically expands to fit text.  If it does, we need to know how far to move the stuff below it.
						$actual_height = $pdf->getLastH();
						//*** Create an array entry for the next row of elements
						$tops[$suffix_int + 1] = ($y + $actual_height) + $v_space; //($actual_height > $height) ? ($y + $actual_height) + $v_space : $y + $v_space;
						break;
					case "extensible_dollar_text" :
						$y = (isset($tops[$suffix_int])) ? $tops[$suffix_int] : $y;
						$value = "$" . str_replace("$","",$value);
						$pdf->Text($x, $y, $value);
						break;
					case "extensible_static_number" :
						$y = (isset($tops[$suffix_int])) ? $tops[$suffix_int] : $y;
 						$pdf->Text($x, $y, $value);
						break;
				}
			}
		}
	}
	
	private function add_extensible_fields($field_array, $document_map, $key_field)
	{
		$ext_key_item = $document_map[$key_field];
		$base_top = $ext_key_item['coords']['y'];
		$add_height = $ext_key_item['coords']['height'];
		$top = $add_height;
		$new_itemss = array();
		
		foreach ($field_array as $field => $value)
		{
			//*** Split the field name into its parts (e.g., "specifications_1" becomes array('field_name' => "specifications", 'suffix' => 1) )
			$parts = $this->split_field($field);
			//*** Get the item from the document image map that serves as the base for this item
			$new_items[$field] = $document_map[$parts['field_name']];
			//*** Define the top position
			$top = ($base_top + ($add_height * ($parts['suffix'] - 1)));
			//*** Change the field and the top position to suit
			$new_items[$field]['field_name'] = $field;
			$new_items[$field]['coords']['y'] = $top;
			
			//*** Finally, add the fields and their current values into an array that will be merged with the PDF data.
			if (!in_array($parts['field_name'], $this->extended_fields))
			{
				$this->extended_fields[$field] = $value;
			}
		}
		return $new_items;
		//*** Append new items to existing map
	}
	
	private function generate_signature($sig_coords, $customer_name)
	{
		$data_path = $this->data_path;
		//*** Come back to this -- problems with corruption in encrypted string.
		//$decrypt_coords = $this->utilities->rc4($this->key, $this->utilities->hex2bin($sig_coords));
		$decrypt_coords = $sig_coords;
		
		$json_coords = $this->utilities->expand_coordinates($decrypt_coords);

		$this->signature_image = sigJsonToImage($json_coords, array('imageSize' => array(600,100)));
		
		// Make the background transparent
		$white = imagecolorallocate($this->signature_image, 255, 255, 255);
		imagecolortransparent($this->signature_image, $white);
		
		$this->signature_image_path = "$data_path/$customer_name.png";
		$retval = imagepng($this->signature_image, $this->signature_image_path);
		
		imagedestroy($this->signature_image);
		
		return $retval;
	}
	
	private function send_email($from_email, $to_email, $subject, $body_text, $attachment_path, $attachment)
	{
		$message = "";
				
		$to =	 $to_email;
		$bound_text =	"ct-office";
		$bound =	"--".$bound_text."\r\n";
		$bound_last =	"--".$bound_text."--\r\n";
		 	 
		$headers =	"From: $from_email\r\n";
		$headers .=	"MIME-Version: 1.0\r\n"	. "Content-Type: multipart/mixed; boundary=\"$bound_text\"";
		 	 
		$message .=	"If you can see this MIME information, then your email program does not accept MIME types.\r\n" . $bound;
		 	 
		$message .=	"Content-Type: text/html; charset=\"iso-8859-1\"\r\n"
		 	."Content-Transfer-Encoding: 7bit\r\n\r\n"
		 	.$body_text
		 	.$bound;
		 	 
		//$file =	file_get_contents($attachment_path . "/" . $attachment);
		 	 
		$message .=	"Content-Type: application/pdf; name=\"$attachment\"\r\n"
		 	."Content-Transfer-Encoding: base64\r\n"
		 	."Content-disposition: attachment; file=\"$attachment\"\r\n"
		 	."\r\n"
		 	.$this->attachment_contents
		 	.$bound_last;
		
		//echo $to_email . "\n" . $from_email . "\n";
		//return;	
		if (mail($to, $subject, $message, $headers)) 
		{
		    return 'MAIL SENT'; 
		} 
		else 
		{ 
		    return 'MAIL FAILED';
		}
	}
	
	public function send_email_new($from_email, $to_email, $subject, $body_text, $attachment_path, $attachment = NULL)
	{
		try {
			$this->mailer->IsSMTP();
			$this->mailer->Host = $this->config->item($this->prefix . "." . 'mail.host');
			$this->mailer->SMTPAuth = true;
			$this->mailer->Port = $this->config->item($this->prefix . "." . 'smtp.port');
			$this->mailer->Username = $this->config->item($this->prefix . "." . 'user.name');
			$this->mailer->Password = $this->config->item($this->prefix . "." . 'password');			  
			
			$addresses = explode(",", $to_email);
			foreach ($addresses as $address)
			{
				$this->mailer->addAddress($address);
			}
			$this->mailer->From = $from_email;
			$this->mailer->FromName = $from_email;
			$this->mailer->addReplyTo($from_email);
			$this->mailer->Subject = $subject;
			$this->mailer->msgHTML($body_text);
			if (file_exists($attachment_path)) {
				$this->mailer->addAttachment($attachment_path);
			}
			if ($this->mailer->Send()) {
				 return 'MAIL SENT';
			} else {
				return 'MAIL FAILED';
			}
		} catch (phpmailerException $e) {
			return 'MAIL FAILED';
		}
		
		
	}
	
} //*** End of class GenerateDocument
//*** END of FILE /application/libraries/GenerateDocument.php


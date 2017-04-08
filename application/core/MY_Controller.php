<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY_Controller Class
 *
 * Extends Controller core
 *
*/
class MY_Controller extends CI_Controller {
	var $context = NULL;
	var $data = array();
	var $user_data = NULL;
	var $user_id = NULL;
	var $template_dir = 'templates/';
	var $doc_head = 'doc_head';
	var $doc_foot = 'doc_foot';
	var $header = 'header';
	var $footer = 'footer';
	var $reset_css = 'css/reset.css';
	var $grid_css = 'css/grid.css';
	var $template_css = 'css/app/template.css';
	var $content_css = null;
	var $theme_css = 'css/app/theme/custom.css';
	var $ui_theme_css = 'css/app/theme/ui-custom.css';
	var $mute;
	
	public function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '1024M');
		
		$this->mute_output = FALSE;
		//*** Set the timezone
		date_default_timezone_set('America/New_York');
		//*** Load the configuration file. Make sure that the "app_id" is set correctly in /application/config/config.php
		if ($this->config->item('app_id') != "")
		{
 			$this->load->config($this->config->item('app_id'));
		}
		else
		{
			echo "WARNING: The 'app_id' is not set correctly in /application/config/config.php";
		}
		$this->user_data = $this->session->userdata('currentsession','message_info');
		//echo var_dump($this->user_data);
		$this->user_id = $this->user_data['user_username'];
		//*** Load plenty_parser to provide Smarty template services
 		$this->load->driver('plenty_parser');
		$this->load->database();
		
		//*** Load constants from database
		//$this->load_constants();
	}

	protected function set_menu($context) 
	{
		
	}
	
	protected function set_context($context) 
	{
		$this->context = $context;
	}

	protected function load_page($page, $local_data, $include_header = TRUE, $include_doc_parts = TRUE)
	{
		//*** These controllers/methods are allowed without being logged in:
		$allowed_pages = $this->config->item('allowed.pages');
		
		//echo var_dump($this->user_data);
		if (is_null($this->user_id) && !in_array($page, $allowed_pages))
		{
			redirect('login');
			return;
		}

		$user_login_info = $this->session->userdata('currentsession');
		//echo var_dump($user_login_info);
		$this->data['ip_address'] = $this->input->ip_address();
		$this->data['app_name'] = $this->config->item('application_name');
		$this->data['portal_name'] = $this->config->item('member.portal.name');
		$this->data['user_full_name'] = $user_login_info['user_name'] . " " . $user_login_info['user_surname'];
		$this->data['reset_css'] = base_url() . $this->reset_css;
		$this->data['grid_css'] = base_url() . $this->grid_css;
		$this->data['template_css'] = base_url() . $this->template_css;
		$this->data['content_css'] = (!is_null($this->content_css)) ? base_url() . $this->content_css : null;
		$this->data['theme_css'] = base_url() . $this->theme_css;
		$this->data['ui_theme_css'] = base_url() . $this->ui_theme_css;
		
		$this->data['prototype_js'] = base_url() . 'js/app/prototype.js';
		$this->data['base_class_js'] = base_url() . 'js/app/base_class.js';
		$this->data['popover_css'] = base_url() . 'css/popover/popover.css';
		$this->data['popover_js'] = base_url() . 'js/jquery.popover-1.0.8.js';
		$this->data['app_manager_js'] = base_url() . 'js/app/app_manager.js';
		$this->data['message_manager_js'] = base_url() . 'js/app/message_manager.js';
		
		if (is_null($this->context))
		{
			$this->context = "ct.office";
		}
		$menu_array = $this->config->item($this->context . '.nav.links');
		//*** If a 'menu_remove' array exists remove those item(s) from the menu
		if (isset($local_data['menu_remove']))
		{
			foreach($local_data['menu_remove'] as $item)
			{
				unset($menu_array[$item]);
			}
		}
		$this->data['menu_array'] = $menu_array;
		if (isset($local_data['local_menu_array']))
		{
			$this->data['menu_array'] = $this->local_data['local_menu_array'] + $menu_array;
		}
		$this->data['context_name'] = $this->config->item($this->context . '.context.name');
		
		//*** If the controller doesn't pass in a 'local' version of these, set them to blank in the main $data array
		$required = array('css', 'scripts', 'js_vars', 'title');
		foreach ($required as $var)
		{
			if (!isset($local_data[$var]))
			{
				$this->data[$var] = "";
			}
		}	   
		//*** Bring in data loaded in individual controller
		$this->data = array_merge($this->data, $local_data);
		
		//*** Get page parts
		$parts = array();
		//*** templates/doc_head.php contains all html 'head' info (css, scripts) used throughout the application
		$parts[0] = ($include_doc_parts) ? $this->template_dir . $this->doc_head : NULL;
		//*** templates/header.php contains common header info
		$parts[1] = ($include_header) ? $this->template_dir . $this->header : NULL;
		//*** This is the content page:
		$parts[2] = $page;
		//*** templates/footer.php contains common footer info
		$parts[3] = ($include_header) ? $this->template_dir . $this->footer : NULL;
		//*** templates/doc_foot.php contains ending tags from doc_head 
		$parts[4] = ($include_doc_parts) ? $this->template_dir . $this->doc_foot : NULL;
		//*** Build page
		foreach ($parts as $part)
		{
			if (!is_null($part))
			{
				$this->plenty_parser->parse($part, $this->data);
			}
		}
	}
	
	protected function get_parsed_page($page, $data)
	{
		return $this->plenty_parser->parse($page, $data);
	}
	
	public function get_session_var($var) 
	{
		echo $this->session->userdata($var);
	}

	public function get_all_session_vars() 
	{
		$all_session = $this->session->all_userdata();
		echo json_encode($all_session);
	}

	public function set_session_var($var, $value) 
	{
		$data = array($var => $value);
	
		$this->session->set_userdata($data);
		if (!$this->mute) {
			echo "SUCCESS";
		}
	}

	/*** Calling syntax = http://www.myhost.com/app/set_session_vars/?foo=bar&hack=tosh
	*/
	public function set_session_vars() 
	{
		$url_string = $_GET;
		$this->session->set_userdata($url_string);
		if (!$this->mute) {
			echo "SUCCESS";
		}
	}
	
	public function mute_output()
	{
		$this->mute = TRUE;
	}
	
	private function load_constants()
	{
		$this->db->save_queries = false;
		$query = $this->db->get_where('site_constants');
		$results = $query->result_array();
		foreach ($results as $row) 
		{
			$constant = $row['constant'];
			if (!defined($constant))
			{
				define($constant, $row['value']);
			}
		}
		
	}
	
}
//*** END OF FILE MY_Controller.php
//*** Location: /application/core/MY_Controller.php
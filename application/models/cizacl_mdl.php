<?php

/**
 * CIzACL
 * 
 * @copyright	Copyright (c) Schizzoweb Web Agency
 * @website		http://www.schizzoweb.com
 * @version		1.2
 * @revision	2011-07-20
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 **/

class Cizacl_Mdl extends CI_Model	{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function mktime_format($input,$format='Y-m-d H:i:s')
	{
		if(!empty($input))
			return date($format, $input);
		else
			return '-';
	}

	function jqgrid_operator($input,$input2)	{
		switch ($input)	{
			case "bw":
				$data = "LIKE '".$input2."%'";
				break;
			case "bn":
				$data = "NOT LIKE '".$input2."%'";
				break;
			case "in":
				$data = "1=1";
				break;
			case "ni":
				$data = "1=1";
				break;
			case "eq":
				if(is_numeric($input2))
					$data = "= ".$input2;
				else
					$data = "= '".$input2."'";
				break;
			case "ne":
				$data = "<> ".$input2;
				break;
			case "lt":
				$data = "< ".$input2;
				break;
			case "le":
				$data = "<= ".$input2;
				break;
			case "gt":
				$data = "> ".$input2;
				break;
			case "ge":
				$data = ">= ".$input2;
				break;
			case "ew":
				$data = "LIKE '%".$input2."'";
				break;
			case "cn":
				$data = "LIKE '%".$input2."%'";
				break;
			case "nc":
				$data = "NOT LIKE '%".$input2."%'";
				break;
		}
		return $data;
	}

	function getResources()
	{
		$this->db->where('cizacl_resource_type','controller');
		$this->db->order_by('cizacl_resource_controller');
		$query = $this->db->get('cizacl_resources');
		
		foreach($query->result() as $row)	{
			$data->rows[] = array(
				'value'	=> $row->cizacl_resource_controller,
				'name'	=> $row->cizacl_resource_controller
			);
			$this->db->where('cizacl_resource_controller',$row->cizacl_resource_controller);
			$this->db->where('cizacl_resource_type','function');
			$this->db->order_by('cizacl_resource_function');
			$subquery = $this->db->get('cizacl_resources');

			foreach($subquery->result() as $subrow)	{
				$data->rows[] = array(
					'value'	=> $row->cizacl_resource_controller . '/' . $subrow->cizacl_resource_function,
					'name'	=> $row->cizacl_resource_controller . '/' . $subrow->cizacl_resource_function,
				);
			}
			
		}
		
		if(!empty($data->rows))
			$data->response = true;
		else
			$data->response = false;
		
		return json_encode($data);
	}
	
	
	function getFunctions()
	{
		$this->db->where('cizacl_resource_type','function');
		$this->db->group_by('cizacl_resource_function');
		$this->db->order_by('cizacl_resource_function');
		$query = $this->db->get('cizacl_resources');
		
		$data->rows[] = array(
			'id'		=> NULL,
			'value'		=> NULL,
			'name'		=> $this->lang->line('all')
		);
		
		foreach($query->result() as $row)	{
			$data->rows[] = array(
				'id'	=> $row->cizacl_resource_id,
				'value'	=> $row->cizacl_resource_function,
				'name'	=> $row->cizacl_resource_function
			);
		}
		
		if(!empty($data->rows))
			$data->response = true;
		else
			$data->response = false;
		
		return json_encode($data);
	}
	
	function getControllers()
	{
		$this->db->where('cizacl_resource_type','controller');
		$this->db->order_by('cizacl_resource_controller');
		$query = $this->db->get('cizacl_resources');
		
		$data->rows[] = array(
			'id'		=> NULL,
			'value'		=> NULL,
			'name'		=> $this->lang->line('all')
		);
		
		foreach($query->result() as $row)	{
			$data->rows[] = array(
				'id'	=> $row->cizacl_resource_id,
				'value'	=> $row->cizacl_resource_controller,
				'name'	=> $row->cizacl_resource_controller
			);
		}
		
		if(!empty($data->rows))
			$data->response = true;
		else
			$data->response = false;
		
		return json_encode($data);
	}
	
	function getDefaultUser($role_id)
	{
		if (empty($role_id))	{
			$this->db->where('cizacl_role_default = 1');
			$query = $this->db->get('cizacl_roles');
			if($query->num_rows())	{
				$role = $query->row();
				return $role->cizacl_role_id;
			}
			else
				return false;
		}
		else
			return $this->session->userdata('user_cizacl_role_id');
	}
	
	function getRoleRedirect($role_id)
	{
		if (empty($role_id))
		{
			return "login";
		}
		else
		{
			$this->db->select('cizacl_role_redirect');
			$this->db->where('cizacl_role_id',$role_id);
			$query = $this->db->get('cizacl_roles');
			if ($query->num_rows())	{
				$result = $query->row();
				return $result->cizacl_role_redirect;
			}
		}
	}
	
	function getRules($id='NULL')
	{
		if(empty($id) || strtolower($id) == 'null')
			$this->db->where('cizacl_rule_cizacl_role_id');
		else
			$this->db->where('cizacl_rule_cizacl_role_id = '.$id);
		$this->db->order_by('cizacl_rule_type');
		$this->db->order_by('cizacl_rule_cizacl_resource_controller');
		$this->db->order_by('cizacl_rule_cizacl_resource_function');
		$query = $this->db->get('cizacl_rules');
		if($query->num_rows())	{
			$data->response = 'success';
			$i = 0;
			foreach($query->result() as $row)	{
				$data->rows[$i] = $row;
				$i++;
			}
		}
		else
			die($this->cmsm->json_msg('error',$this->lang->line('attention'),$this->lang->line('error')));

		return json_encode($data);
	}
	
	function getUser($id,$null='guest')
	{
		if(isset($id) && !is_numeric($id)) die();
		if((string)$id === "0")
			return '['.$this->lang->line('system').']';
		elseif(empty($id))	{
			if($null == 'guest')
				return '['.$this->lang->line('guest').']';
			else
				return '-';
		}
		elseif(isset($id))	{
			$this->db->where('user_profile_user_id = '.$id);
			$query = $this->db->get('user_profiles');
			if($query->num_rows())	{
				$row = $query->row();
				return $row->user_profile_surname . ' ' . $row->user_profile_name;
			}
			else
				die();
		}
	}
	
	function getAbbr($root,$file)
	{
		$root			= str_replace('/',DIRECTORY_SEPARATOR,$root);
		$default_file	= str_replace('xx','en',$file);
		$file			= str_replace('xx',$this->config->item('language_abbr'),$file);
		$files			= array();
		
		if ($handle = opendir(FCPATH.DIRECTORY_SEPARATOR.$root)) {
			while (false !== ($list = readdir($handle))) {
				$files[] = $list;
			}
			closedir($handle);
			
			if(in_array($file,$files))
				return $this->config->item('language_abbr');
			else	{
				if(in_array($default_file,$files))
					return 'en';
				else
					echo show_error($this->lang->line('default_file_not_found'));
			}
			
		}
	}
	
	function check_null($input)
	{
		$var = $input;
		if(empty($var) || $var == 'NULL')
			return NULL;
		else
			return $var;
	}
}

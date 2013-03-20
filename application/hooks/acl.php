<?php
class acl
{
	var $perms = array();		//Array : Stores the permissions for the user
	var $userID;			//Integer : Stores the ID of the current user
	var $userRoles = array();	//Array : Stores the roles of the current user
	var $ci;
        var $routing;
	
        function __construct() {
		$this->ci = &get_instance();
                $this->routing =& load_class('Router');
                //$this->ci->load->helper('url');

                /*if(isset($config['userID'])){
                    $this->userID = floatval($config['userID']);
                    $this->userRoles = $this->getUserRoles();
                    $this->buildACL();
                }*/
	}

	function buildACL() {
		//first, get the rules for the user's role
		if (count($this->userRoles) > 0)
		{
			$this->perms = array_merge($this->perms,$this->getRolePerms($this->userRoles));
		}
		//then, get the individual user permissions
		$this->perms = array_merge($this->perms,$this->getUserPerms($this->userID));
	}

	function getPermKeyFromID($permID) {
		//$strSQL = "SELECT `permKey` FROM `".DB_PREFIX."permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
		$this->ci->db->select('PERMKEY');
		$this->ci->db->where('ID',$permID);
		$sql = $this->ci->db->get('PERMS',1);
		$data = $sql->result();
		return $data[0]->PERMKEY;
	}

	function getPermNameFromID($permID) {
		//$strSQL = "SELECT `permName` FROM `".DB_PREFIX."permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
		$this->ci->db->select('PERMNAME');
		$this->ci->db->where('ID',$permID);
		$sql = $this->ci->db->get('PERMS',1);
		$data = $sql->result();
		return $data[0]->PERMNAME;
	}

	function getRoleNameFromID($roleID) {
		//$strSQL = "SELECT `roleName` FROM `".DB_PREFIX."roles` WHERE `ID` = " . floatval($roleID) . " LIMIT 1";
		$this->ci->db->select('NAME');
		$this->ci->db->where('ID',$roleID,1);
		$sql = $this->ci->db->get('ROLES');
		$data = $sql->result();
		return $data[0]->NAME;
	}

	function getUserRoles() {
		//$strSQL = "SELECT * FROM `".DB_PREFIX."user_roles` WHERE `userID` = " . floatval($this->userID) . " ORDER BY `addDate` ASC";

		$this->ci->db->where(array('USERID'=>$this->userID));
		$this->ci->db->order_by('ADDDATE','asc');
		$sql = $this->ci->db->get('PEOPLEROLES');
		$data = $sql->result();

		$resp = array();
		foreach( $data as $row )
		{
			$resp[] = $row->ROLEID;
		}
		return $resp;
	}

	function getAllRoles($format='ids') {
		$format = strtolower($format);
		//$strSQL = "SELECT * FROM `".DB_PREFIX."roles` ORDER BY `roleName` ASC";
		$this->ci->db->order_by('NAME','asc');
		$sql = $this->ci->db->get('ROLES');
		$data = $sql->result();

		$resp = array();
		foreach( $data as $row )
		{
			if ($format == 'full')
			{
				$resp[] = array("id" => $row->ID,"name" => $row->NAME);
			} else {
				$resp[] = $row->ID;
			}
		}
		return $resp;
	}

	function getAllPerms($format='ids') {
		$format = strtolower($format);
		//$strSQL = "SELECT * FROM `".DB_PREFIX."permissions` ORDER BY `permKey` ASC";

		$this->ci->db->order_by('PERMKEY','asc');
		$sql = $this->ci->db->get('PERMS');
		$data = $sql->result();

		$resp = array();
		foreach( $data as $row )
		{
			if ($format == 'full')
			{
				$resp[$row->PERMKEY] = array('id' => $row->ID, 'name' => $row->PERMNAME, 'key' => $row->PERMKEY);
			} else {
				$resp[] = $row->ID;
			}
		}
		return $resp;
	}

	function getRolePerms($role) {
		if (is_array($role))
		{
			//$roleSQL = "SELECT * FROM `".DB_PREFIX."role_perms` WHERE `roleID` IN (" . implode(",",$role) . ") ORDER BY `ID` ASC";
			$this->ci->db->where_in('ROLEID',$role);
		} else {
			//$roleSQL = "SELECT * FROM `".DB_PREFIX."role_perms` WHERE `roleID` = " . floatval($role) . " ORDER BY `ID` ASC";
			$this->ci->db->where(array('ROLEID'=>$role));

		}
		$this->ci->db->order_by('ID','asc');
		$sql = $this->ci->db->get('ROLEPERMS'); //$this->db->select($roleSQL);
		$data = $sql->result();
		$perms = array();
		foreach( $data as $row )
		{
			$pK = strtolower($this->getPermKeyFromID($row->PERMID));
			if ($pK == '') { continue; }
			if ($row->VALUE === '1') {
				$hP = true;
			} else {
				$hP = false;
			}
			$perms[$pK] = array('perm' => $pK,'inheritted' => true,'value' => $hP,'name' => $this->getPermNameFromID($row->PERMID),'id' => $row->PERMID);
		}
		return $perms;
	}

	function getUserPerms($userID) {
		//$strSQL = "SELECT * FROM `".DB_PREFIX."user_perms` WHERE `userID` = " . floatval($userID) . " ORDER BY `addDate` ASC";

		$this->ci->db->where('USERID',$userID);
		$this->ci->db->order_by('ADDDATE','asc');
		$sql = $this->ci->db->get('PEOPLEPERMS');
		$data = $sql->result();

		$perms = array();
		foreach( $data as $row )
		{
			$pK = strtolower($this->getPermKeyFromID($row->PERMID));
			if ($pK == '') { continue; }
			if ($row->VALUE == '1') {
				$hP = true;
			} else {
				$hP = false;
			}
			$perms[$pK] = array('perm' => $pK,'inheritted' => false,'value' => $hP,'name' => $this->getPermNameFromID($row->PERMID),'id' => $row->PERMID);
		}
		return $perms;
	}
        
        function setPerm($perm){
            $class = $this->routing->fetch_class();
            $method = $this->routing->fetch_method();
            $folder = strstr(uri_string(), '/'.$class, TRUE);
            $folders = explode('/',$folder);
            
            $permData = array(
                'PERMKEY' => $perm,
                'PERMNAME' => $perm,
                'FOLDER' => $folders[0] ? $folders[0] : '',
                'SUBMENU' => $folders[1] ? $folders[1] : '',
                'METHOD' => $method,
                'CLASS' => $class
            );
            $this->ci->db->set('ID','UUID()',FALSE);
            $this->ci->db->insert('PERMS',$permData);
        }

	function hasRole($roleID) {
		foreach($this->userRoles as $k => $v)
		{
			if (floatval($v) === $roleID)
			{
				return true;
			}
		}
		return false;
	}

	function hasPermission() {
                $class = $this->routing->fetch_class();
                $method = $this->routing->fetch_method();
                $folder = strstr(uri_string(), $class, TRUE);
                
                //$permKey = $this->ci->uri->uri_string();
                $permKey = $class;
                $permKey .= $method != "index" ? "/".$method : "";
                $permKey = strtolower($permKey);
                //die($permKey);
                if($this->check_isvalidated()){ // Si ya esta iniciada la sesión
                    if(!$this->ci->input->is_ajax_request() && $class != "ajax"){
                        if($class == 'login' && $method == 'index')
                            redirect('home');

                        if(($class == 'home' && $method == 'index') || ($class == 'login' && $method == 'do_logout'))
                            return false;

                        if($this->ci->session->userdata('userid') != null){
                            $this->userID = $this->ci->session->userdata('userid');
                            $this->userRoles = $this->getUserRoles();
                            $this->buildACL();

                            //
                            //Si el permiso no está dado de alta en la base de datos, verifica que el método llamado existe,
                            //y lo da de alta en la tabla perm_data.
                            //
                            $roles = $this->getAllPerms('full');
                            if(!array_key_exists($permKey, $roles)){
                                if(method_exists($this->ci, $method)){
                                    if(is_callable(array($this->ci,$method))){
                                        $this->setPerm($permKey);
                                    }
                                }
                            }
                            
                            if (array_key_exists($permKey,$this->perms))
                            {
                                    if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === true)
                                    {
                                        $this->ci->load->vars(array('title' => $this->perms[$permKey]['name']));
                                        return true;
                                    } else {
                                        redirect('home');
                                    }
                            } else {
                                redirect('home');
                            }
                        }else{
                            redirect('home');
                        }
                    }
                }elseif($permKey != strstr($permKey,'login'))
                    redirect('login');
	}
        
        private function check_isvalidated(){
            $permKey = $this->ci->uri->uri_string();
            $permKey = strtolower($permKey);
            if(! $this->ci->session->userdata('validated')){
                return false;
            }else
                return true;
        }
}
?>

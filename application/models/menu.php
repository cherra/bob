<?php

class Menu extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }

    public function getOptions(){
        $this->db->where('LENGTH(FOLDER) > 0');
        $this->db->order_by('FOLDER,SUBMENU,CLASS,METHOD');
        $query = $this->db->get('PERMS');
        return  $query->result();
    }
}

?>

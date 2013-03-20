<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of almacen
 *
 * @author cherra
 */
class Sucursal extends CI_Model{
    
    public function get_all(){
        $this->db->order_by('NAME');
        $query = $this->db->get('LOCATIONS');
        return $query->result();
    }
    
    public function get_por_id($id = 0){
        $this->db->where('ID', $id);
        $query = $this->db->get('LOCATIONS');
        return $query->row_array();
    }
}

?>

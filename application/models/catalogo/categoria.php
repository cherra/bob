<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of categoria
 *
 * @author cherra
 */
class Categoria extends CI_Model{
    
    public function get_all(){
        $this->db->order_by('NAME');
        $query = $this->db->get('CATEGORIES');
        return $query->result();
    }
}

?>

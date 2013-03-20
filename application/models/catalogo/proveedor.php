<?php
/**
 * Description of proveedor
 *
 * @author cherra
 */
class Proveedor extends CI_Model{
    
    public function get_all(){
        $this->db->order_by('NAME');
        $query = $this->db->get('SUPPLIERS');
        return $query->result();
    }
}

?>

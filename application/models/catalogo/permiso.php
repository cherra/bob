<?php
/**
 * Description of permiso
 *
 * @author cherra
 */
class Permiso extends CI_Model {
    
    public function get($filtro = NULL){
        if(!is_null($filtro)){
            $this->db->like('PERMNAME',$filtro['PERMNAME']);
        }
        $this->db->order_by('FOLDER, CLASS, METHOD');
        $query = $this->db->get('PERMS');
        return $query->result();
    }
    
    public function get_por_id($id = ''){
        $this->db->where('ID',$id);
        $query = $this->db->get('PERMS');
        return $query->row_array();
    }
    
    public function update($data){
        $datos = array(
            'PERMNAME' => $data['PERMNAME'],
            'SUBMENU' => $data['SUBMENU'],
            'MENU' => isset($data['MENU']) ? $data['MENU'] : 0
        );
        
        $this->db->update('PERMS',$datos,array('ID' => $data['ID']));
    }
}

?>

<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rol_model
 *
 * @author cherra
 */
class Rol extends CI_Model {
    
    public function get($filtro = NULL){
        if(!is_null($filtro)){
            $this->db->like('NAME',$filtro['NAME']);
        }
        $this->db->order_by('NAME');
        $query = $this->db->get('ROLES');
        return $query->result();
    }
    
    public function get_por_id($ID = ''){
        $this->db->where('ID',$ID);
        $query = $this->db->get('ROLES');
        return $query->row_array();
    }
    
    public function get_permisos($id = ''){
        $this->db->select('*')->from('ROLEPERMS')->join('ROLES','ROLEPERMS.ROLEID= ROLES.ID')->join('PERMS','ROLEPERMS.PERMID = PERMS.ID')->where('ROLEPERMS.ROLEID',$id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function insert($data){
        $datos = array(
            'NAME' => $data['NAME'],
            'DESCRIPTION' => $data['DESCRIPTION']
        );
        
        $this->db->insert('ROLES',$datos);
        
        $perms = array();
        if(isset($data['ROLEPERMS'])){
            foreach($data['ROLEPERMS'] AS $perm){
                $perms[] = array(
                    'ROLEID' => $this->db->insert_id(),
                    'PERMID' => $perm,
                    'VALUE' => '1',
                );
            }
            $this->db->insert_batch('ROLEPERMS',$perms);
        }
    }
    
    public function update($data){
        $datos = array(
            'NAME' => $data['NAME'],
            'DESCRIPTION' => $data['DESCRIPTION']
        );
        
        $this->db->update('ROLES',$datos,array('ID' => $data['ID']));
        $this->db->delete('ROLEPERMS',array('ROLEID' => $data['ID']));
        
        $perms = array();
        if(isset($data['ROLEPERMS'])){
            foreach($data['ROLEPERMS'] AS $perm){
                $perms[] = array(
                    'ROLEID' => $data['ID'],
                    'PERMID' => $perm,
                    'VALUE' => '1',
                );
            }
            $this->db->insert_batch('ROLEPERMS',$perms);
        }
    }
}

?>

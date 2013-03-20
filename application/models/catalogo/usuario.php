<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of usuarios
 *
 * @author cherra
 */
class Usuario extends CI_Model{
    
    public function get_all(){
        $this->db->order_by('NAME');
        $query = $this->db->get('PEOPLE');
        return $query->result();
    }
    
    public function get_por_rol($filtro = NULL){
        $this->db->select('*')->from('PEOPLE')->join('PEOPLEROLES','PEOPLE.ID = PEOPLEROLES.USERID','left');
        if(!is_null($filtro)){
            $this->db->like('NAME',$filtro['NAME']);
            if(strlen($filtro['ROLEID']) > 0)
                $this->db->where('ROLEID',$filtro['ROLEID']);
        }
        $this->db->group_by('ID');
        $this->db->order_by('NAME');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_por_nombre($nombre = ''){
        $this->db->select('*');
        $this->db->from('PEOPLE');
        $this->db->like('NAME',$nombre);
        $this->db->order_by('NAME');
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_por_id($id = ''){
        $this->db->select('*');
        $this->db->from('PEOPLE');
        $this->db->where('ID',$id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    
    public function get_roles($id = ''){
        $this->db->select('*')->from('PEOPLEROLES')->join('ROLES','PEOPLEROLES.ROLEID = ROLES.ID')->where('USERID',$id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function get_permisos($id = ''){
        $this->db->select('*')->from('PEOPLEPERMS')->join('PERMS','PEOPLEPERMS.PERMID = PERMS.ID')->where('USERID',$id);
        $query = $this->db->get();
        return $query->result();
    }
    
    public function insert($data){
        $id = $this->uuid->v4();
        $datos = array(
            'ID' => $id,
            'NAME' => $data['NAME'],
            'APPPASSWORD' => strlen($data['APPPASSWORD']) ? "sha1:".strtoupper(sha1($data['APPPASSWORD'])) : "",
            'ROLE' => $data['ROLE'],
            'VISIBLE' => '1'
        );
        $this->db->insert('PEOPLE',$datos);
        if(isset($data['PEOPLEROLES'])){
            $this->db->delete('PEOPLEROLES',array('USERID' => $id));
            $roles = array();
            foreach($data['PEOPLEROLES'] AS $rol){
                $roles[] = array(
                    'USERID' => $id,
                    'ROLEID' => $rol,
                );
            }
            $this->db->insert_batch('PEOPLEROLES',$roles);
        }
        $perms = array();
        if(isset($data['PEOPLEPERMS'])){
            $this->db->delete('PEOPLEPERMS',array('USERID' => $id));
            foreach($data['PEOPLEPERMS'] AS $perm){
                $perms[] = array(
                    'USERID' => $id,
                    'PERMID' => $perm,
                    'VALUE' => '1',
                );
            }
            $this->db->insert_batch('PEOPLEPERMS',$perms);
        }
    }
    
    public function update($data){
        $datos = array(
            'NAME' => $data['NAME'],
            'ROLE' => $data['ROLE'],
            'VISIBLE' => $data['VISIBLE']
        );
        //$this->db->where('id_usuario',$data['id_usuario']);
        $this->db->update('PEOPLE',$datos,array('ID' => $data['ID']));
        if(strlen($data['APPPASSWORD']) > 0)
            $this->db->update('PEOPLE',array('APPPASSWORD' => 'sha1:'.sha1($data['APPPASSWORD'])),"ID = '".$data['ID']."'");
        
        if(isset($data['PEOPLEROLES'])){
            $this->db->delete('PEOPLEROLES',array('USERID' => $data['ID']));
            $roles = array();
            foreach($data['PEOPLEROLES'] AS $rol){
                $roles[] = array(
                    'USERID' => $data['ID'],
                    'ROLEID' => $rol,
                );
            }
            $this->db->insert_batch('PEOPLEROLES',$roles);
        }
        $perms = array();
        if(isset($data['PEOPLEPERMS'])){
            $this->db->delete('PEOPLEPERMS',array('USERID' => $data['ID']));
            foreach($data['PEOPLEPERMS'] AS $perm){
                $perms[] = array(
                    'USERID' => $data['ID'],
                    'PERMID' => $perm,
                    'VALUE' => '1',
                );
            }
            $this->db->insert_batch('PEOPLEPERMS',$perms);
        }
        
        //$this->db->update('user_roles',array('roleID' => $data['roleID']),'id_usuario = '.$data['id_usuario']);
        //echo var_dump($roles);
    }
}

?>

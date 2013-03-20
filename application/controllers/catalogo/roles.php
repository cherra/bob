<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of roles
 *
 * @author cherra
 */
class Roles extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/rol');
        $this->load->model('catalogo/permiso');
    }
    
    private function guarda($data, $ID = ''){
        if(strlen($ID) > 0){
            //var_dump($data);
            //die();
            $this->rol->update($data);
            $this->msg['bien'] = 'Rol modificado con éxito';
            //redirect('catalogo/usuarios/modifica/'.$id_usuario);
        }else{
            $this->rol->insert($data);
            $this->msg['bien'] = 'Rol registrado con número: '.$this->db->insert_id();
        }
    }
    
    public function alta(){
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        $resultado['perms'] = $this->permiso->get();
        $this->load->view('catalogo/rol/alta',$resultado);
    }
    
    public function listado(){
        $datos_busqueda = $this->input->post();
        
        $datos['roles'] = $this->rol->get($datos_busqueda ? $datos_busqueda : NULL);
        $this->load->view('catalogo/rol/listado',$datos);
    }
    
    public function modifica($ID = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$ID);
        }
        //$data = $this->input->get();
        if(strlen($ID) > 0){
            $resultado['rol'] = $this->rol->get_por_id($ID);
            $resultado['perms'] = $this->permiso->get();
            $resultado['role_perms'] = $this->rol->get_permisos($ID);
            //$resultado['bien'] = $this->msg['bien'];
            //$row = $resultado->row();
            $this->load->view('catalogo/rol/modifica',$resultado);
        }else
            redirect('catalogo/roles/listado');
    }
}

?>

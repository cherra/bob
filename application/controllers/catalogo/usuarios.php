<?php
/**
 * Description of usuarios
 *
 * @author cherra
 */
class Usuarios extends CI_Controller {
    
    var $msg = array('bien','error');
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/usuario');
    }
    
    private function guarda($data, $id_usuario = ''){
            if(strlen($id_usuario) > 0){
                //var_dump($data);
                //die();
                $this->usuario->update($data);
                $this->msg['bien'] = 'Usuario modificado con éxito';
                //redirect('catalogo/usuarios/modifica/'.$id_usuario);
            }else{
                $this->usuario->insert($data);
                $this->msg['bien'] = 'Usuario registrado con número: '.$this->db->insert_id();
            }
    }
    
    public function alta(){
        $this->load->model('catalogo/rol');
        $this->load->model('catalogo/permiso');
        
        $data = $this->input->post();
        if($data){
            $this->guarda($data);
        }
        
        $data['roles'] = $this->rol->get();
        $data['perms'] = $this->permiso->get();
        $this->load->view('catalogo/usuario/alta',$data);
    }
    
    public function listado(){
        $this->load->model('catalogo/rol');
        
        $datos_busqueda = $this->input->post();
        
        $data['usuario'] = $this->usuario->get_por_rol($datos_busqueda?$datos_busqueda:NULL);
        $data['roles'] = $this->rol->get();
        $this->load->view('catalogo/usuario/listado',$data);
    }
    
    public function modifica($id_usuario = ''){
        $this->load->model('catalogo/rol');
        $this->load->model('catalogo/permiso');
        
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$id_usuario);
        }
        //$data = $this->input->get();
        if(strlen($id_usuario) > 0){
            $resultado['usuario'] = $this->usuario->get_por_id($id_usuario);
            $resultado['userRoles'] = $this->usuario->get_roles($id_usuario);
            $resultado['roles'] = $this->rol->get();
            $resultado['perms'] = $this->permiso->get();
            $resultado['userPerms'] = $this->usuario->get_permisos($id_usuario);
            //$resultado['bien'] = $this->msg['bien'];
            //$row = $resultado->row();
            $this->load->view('catalogo/usuario/modifica',$resultado);
        }else{
            redirect('catalogo/usuarios/listado');
        }
    }
}

?>

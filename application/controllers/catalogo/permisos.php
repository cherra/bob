<?php

/**
 * Description of permisos
 *
 * @author cherra
 */
class Permisos extends CI_Controller {
    
    function __construct() {
        parent::__construct();
        $this->load->model('catalogo/permiso');
    }
    
    private function guarda($data, $ID = ''){
        if(strlen($ID) > 0){
            //var_dump($data);
            //die();
            $this->permiso->update($data);
            $this->msg['bien'] = 'Permiso modificado con éxito';
            //redirect('catalogo/usuarios/modifica/'.$id_usuario);
        }else{
            $this->permiso->insert($data);
            $this->msg['bien'] = 'Permiso registrado con número: '.$this->db->insert_id();
        }
    }
    
    public function listado(){
        $datos_busqueda = $this->input->post();
        
        $datos['permisos'] = $this->permiso->get($datos_busqueda?$datos_busqueda:NULL);
        $this->load->view('catalogo/permiso/listado',$datos);
    }
    
    public function modifica($ID = ''){
        $data = $this->input->post();
        if($data){
            $this->guarda($data,$ID);
        }
        //$data = $this->input->get();
        if(strlen($ID) > 0){
            $resultado['permiso'] = $this->permiso->get_por_id($ID);
            $this->load->view('catalogo/permiso/modifica',$resultado);
        }else
            redirect('catalogo/permisos/listado');
    }
}

?>

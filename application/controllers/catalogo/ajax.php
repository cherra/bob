<?php
/**
 * Controlador para solicitudes por medio de ajax
 * Por default, el ACL no incluye esta clase en los permisos.
 *
 * @author cherra
 */
class Ajax extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }

    public function session_registra_valor(){
        if(($variables = $this->input->post())){
            foreach($variables as $key => $valor){
                $this->session->set_userdata($key, $valor);
            }
        }
    }
    
    public function session_obten_valor($key){
        $valor = $this->session->userdata($key);
        echo $valor;
    }
}


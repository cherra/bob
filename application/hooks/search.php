<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search
 *
 * @author cherra
 */
class search {
    
        function __construct() {
		$this->ci = &get_instance();
                $this->routing =& load_class('Router');
	}
        
        function index(){
            $class = $this->routing->fetch_class();
            $method = $this->routing->fetch_method();
            $folder = strstr(uri_string(), $class, TRUE);

            if(!$this->ci->input->is_ajax_request() && $class != "ajax"){
                if( $this->ci->session->userdata('ruta') != $folder.$class.'/'.$method ){
                    $this->ci->session->unset_userdata('filtros');
                }

                $this->ci->session->set_userdata('ruta',$folder.$class.'/'.$method);

                $filtros = $this->ci->input->post();
                if($filtros)
                    $this->ci->session->set_userdata('filtros',$filtros);
            }
        }
}

?>

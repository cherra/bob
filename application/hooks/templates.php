<?php
class templates{
    function loadTemplates(){
        $CI = & get_instance();
        if(!$CI->input->is_ajax_request()){
        
            $ruta = $CI->uri->uri_string();
            $ruta = strtolower($ruta);

            if(! strstr($ruta,'login')){
                $CI->load->model('menu');
                $data['menu'] = $CI->menu->getOptions();
                //var_dump($data);
                $CI->load->view($CI->config->item('header'));
                $CI->load->view($CI->config->item('menu'),$data);
                $CI->load->view($CI->config->item('topbar'));
            }
        }
    }
    
    function loadFooter(){
        $CI = & get_instance();
        if(!$CI->input->is_ajax_request()){
            $ruta = $CI->uri->uri_string();
            $ruta = strtolower($ruta);

            if(! strstr($ruta,'login')){
                $CI->load->view($CI->config->item('footer'));
            }
        }
    }
}
?>

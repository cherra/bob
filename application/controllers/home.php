<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Home controller class
 * This is only viewable to those members that are logged in
 */
 class Home extends CI_Controller{
     
     var $data = array();
     
    function __construct(){
        parent::__construct();
        //$this->check_isvalidated();
        //$this->data['header'] = $this->load->view('templates/header','',true);
        /*$this->data['header'] = $this->config->item('header','config');
        $this->data['menu'] = $this->load->view('templates/menu','',true);
        $this->data['footer'] = $this->load->view('templates/footer','',true);
        $this->data['topbar'] = $this->load->view('templates/topbar','',true);*/
    }
     
    public function index(){
        // If the user is validated, then this function will run
        $this->load->view('home_view');
    }
     
    
 }
 ?>
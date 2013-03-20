<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Author: Jorge Torres
 * Description: Login controller class
 */
class Login extends CI_Controller{

    private $data = array();
    
    function __construct(){
        parent::__construct();
        
        $this->load->helper('form');
        
        $this->data['header'] = $this->load->view('templates/header','',true);
    }
     
    public function index($msg = NULL){
        // Load our view to be displayed
        // to the user
        $this->data['msg'] = $msg;
        $this->load->view('login_view',$this->data);
    }
    
    public function process(){
        // Load the model
        $this->load->model('login_model');
        // Validate the user can login
        $result = $this->login_model->validate();
        // Now we verify the result
        if(! $result){
            // If user did not validate, then show them login page again
            $msg = '<p><font color=red>Usuario o contraseña inválidos.</font></p><br />';
            $this->index($msg);
        }else{
            // If user did validate, 
            // Send them to members area
            //$config['userID'] = $this->session->userdata('userid');
            redirect('home');
        }       
    }
    
    public function do_logout(){
        $this->session->sess_destroy();
        redirect('login');
    }
}
?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model("Login_model", "login");
        
        
    }
    public function index(){
       $this->load->helper('form');
       $this->load->library('form_validation');
       $schoolList['schoollist']= $this->login->getAllSchool();
       $schoolList['acdsessionList']= $this->login->getAllAcademinSession();
       $schoolList['acntYrList']= $this->login->getAllAccountingYear();
    //    pre($schoolList['acntYrList']);exit;
     
       $page="login/login";
       $this->load->view($page,$schoolList);
    }
    
    public function check_login() 
    {  
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('school_id', 'School', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('userpassword', 'Password', 'required');
        $this->form_validation->set_rules('acd_session_id', 'Academic Session ', 'required');
        $this->form_validation->set_rules('accnt_year_id', 'Accounting Year', 'required');
        $this->form_validation->set_error_delimiters('<div class="error-login">', '</div>');
        
        if ($this->form_validation->run() == FALSE)
           {
                   //redirect('login');
                    $schoolList['schoollist']= $this->login->getAllSchool();
                    $schoolList['acdsessionList']= $this->login->getAllAcademinSession();
                    $schoolList['acntYrList']= $this->login->getAllAccountingYear();
                    $page="login/login";
                    $this->load->view($page,$schoolList);    
           }
           else
           {
                $username = $this->input->post('username');
                $school = $this->input->post('school_id');
                $password = $this->input->post('userpassword');
                $acd_session_id = $this->input->post('acd_session_id');
                $accnt_year_id = $this->input->post('accnt_year_id');
                $user_id = $this->login->checkLogin($username,$password,$school);
                if($user_id!=""){
                    $user = $this->login->get_user($user_id);
                    $user_session = [
                    "userid"=>$user->user_id,
                    "username"=>$user->username, 
                    "acd_session_id"=>$acd_session_id, 
                    "accnt_year_id"=>$accnt_year_id, 
                    "school_id"=>$school 
                    
                ];
                 $this->setSessionData($user_session);
                 redirect('dashboard');
                    
                }else{
                     $this->session->set_flashdata('msg','<div class="error-login">Invalid username or password</div>');
                     redirect('login');
                }
                       //echo('success');
           }
    }
    
    private function setSessionData($result = NULL) {

        if ($result) {
            $this->session->set_userdata("user_data", $result);
        }
    }
}

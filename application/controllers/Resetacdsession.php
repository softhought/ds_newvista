<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Resetacdsession extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }



    public function index()
    {
        $session=$this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
            $acd_session_id=$this->input->post('AcademicSession');
            $accnt_year_id=$this->input->post('accnt_year_id');
            $user_session_new = [
                "userid"=>$session['userid'],
                "username"=>$session['username'], 
                "acd_session_id"=>$acd_session_id, 
                "accnt_year_id"=>$accnt_year_id, 
                "school_id"=>$session['school_id']
                
            ];
            $this->setSessionData($user_session_new);
            redirect('dashboard');
            // pre($session);
            // $session['acd_session_id']=2;
            // pre($session);
        }else{
            redirect('login','refresh');
        } 
    }

    private function setSessionData($result = NULL) {

        if ($result) {
            $this->session->set_userdata("user_data", $result);
        }
    }

}/* end of class */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Closingblancetransfer extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('Closingblancetransfermodel','Closingblancetransfermodel',TRUE);
    }
	

	public function index(){
        $session = $this->session->userdata('user_data');
        if ($this->session->userdata('user_data')) {
			$result = $this->Closingblancetransfermodel->getCurrentYear($session['accnt_year_id']);
			$result['btnText'] = "Transfer";
			//pre($result);exit;
            $page ="dashboard/admin_dashboard/closing_balance_transfer/closing_balance_transfer.php";
            $header = '';
            createbody_method($result, $page, $header, $session);
        } else {
            redirect('login', 'refresh');
        }
    }
    public function transferclosing(){
        $session = $this->session->userdata('user_data');
        if ($this->session->userdata('user_data')) {
			//pre($this->input->post());exit;
            $fromyearid = $this->input->post("fromYearId");
			$toyearid= $this->input->post("toYearId");
			$fromdate=$this->input->post("acnt_dt_start");
			$todate=$this->input->post("acnt_dt_end");
			
			$school_id=$session['school_id'];
			$acd_session_id=$session['acd_session_id'];
			$accnt_year_id=$session['accnt_year_id'];
			
			$fiscalsatrtdate=$todate;

			$response["result"]= $this->Closingblancetransfermodel->transferclosingbalance($school_id,$fromyearid,$toyearid,$fromdate,$todate,$fiscalsatrtdate,$acd_session_id);
			// $response["result"]= $this->closingtransfermodel->transferclosingbalance($company,$fromyearid,$toyearid,$fromdate,$todate,$fiscalsatrtdate);
            $page ="dashboard/admin_dashboard/closing_balance_transfer/closingdtl_partialView.php";
            $this->load->view($page, $response);

            //pre($response);
        }else{
            redirect('login', 'refresh');
        }
        
    }
    

    

}  // end of class
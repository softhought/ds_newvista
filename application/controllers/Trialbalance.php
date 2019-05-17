<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Trialbalance extends CI_Controller {
    public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('trialbalancemodel','trialbalancemodel',TRUE);
    }
    
    public function index()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
            $header = "";
            $yearid = $session['accnt_year_id'];
            
            $result['module'] = "View";
            $result['btnText'] = "PDF";            

            $accntYearData=$this->commondatamodel->getSingleRowByWhereCls('accounting_year_master',array("id"=>$yearid));
			$strtDt=str_replace('-','/',$accntYearData->start_date);
			$endDt=str_replace('-','/',$accntYearData->end_date);
			$result['acnt_dt_start']= date('m/d/Y',strtotime($strtDt));
            $result['acnt_dt_end']= date('m/d/Y',strtotime($endDt));
            
			$fiscalStartDt = $this->trialbalancemodel->getFiscalStartDt($yearid);
			$result['fiscalStartDt'] = $fiscalStartDt;	
			$page = "dashboard/admin_dashboard/trial_balance/trialBalance";
            createbody_method($result, $page, $header, $session);
		}
		else
		{
			redirect('login','refresh');
		}
    }
    
    public function pdfTrialBalance()
    {
        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
            // $page = 'dashboard/admin_dashboard/trial_balance/trialBalance_pdf';
            // $this->load->view($page,true);
            $companyId = $session['school_id'];
            $yearid = $session['accnt_year_id'];

            // print_r($this->input->post());exit;
        
            
            $this->load->library('Pdf');
            $pdf = $this->pdf->load();
            ini_set('memory_limit', '256M'); 
                
            $fromdate = str_replace('-', '/', trim($this->input->post('from_date')));
            $todate = str_replace('-', '/', trim($this->input->post('to_date')));
            $frmDate = date('Y-m-d',strtotime($fromdate));
            $toDate = date('Y-m-d',strtotime($todate));
            
            $fiscalStartDt = $this->trialbalancemodel->getFiscalStartDt($yearid);
        
        
            
            
            
            $result['trialbalance']= $this->trialbalancemodel->getTrialBalanceData($companyId,$yearid,$frmDate,$toDate,$fiscalStartDt);
            // pre($result['trialbalance']);exit;
            // $this->db->freeDBResource($this->db->conn_id); 
            $this->freeDBResource($this->db->conn_id);
            

       

        /* echo "<pre>";
            print_r($result['trialbalance']);
            echo "</pre>";
            exit; */
        
            
            $result['company']=  $this->trialbalancemodel->getCompanyNameById($companyId);
            $result['companylocation']=  $this->trialbalancemodel->getCompanyAddressById($companyId);
            $result['fromDate'] = date('d-m-Y',strtotime($fromdate));
            $result['toDate'] = date('d-m-Y',strtotime($todate));      
            
            
            
            
            $page = 'dashboard/admin_dashboard/trial_balance/trialBalance_pdf';
            $html = $this->load->view($page, $result, TRUE);
                    // render the view into HTML
                    //$html="Hello";
            $pdf->WriteHTML($html); 
            $output = 'trial_balance' . date('Y_m_d_H_i_s') . '_.pdf'; 
            $pdf->Output("$output", 'I');
            exit();

        }else{
			redirect('login','refresh');
		}
    }

    
    function freeDBResource($dbh)
    {
        do
        {
            if($l_result = mysqli_store_result($dbh))
            {
                mysqli_free_result($l_result);
            }
        }
        while(mysqli_more_results($dbh)  && mysqli_next_result($dbh));
    }



}/* end of class */

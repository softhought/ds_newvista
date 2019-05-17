<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Generalledger extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('Generalledgermodel','generalmodel',TRUE);
		$this->load->model('commondatamodel','commondatamodel',TRUE);
    }

    public function index()
    {
        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
            $header = "";
            $result['module'] = "View";
            $result['btnText'] = "PDF";
            $yearid = $session['accnt_year_id'];
			$fiscalStartDt = $this->generalmodel->getFiscalStartDt($yearid);
			$result['fiscalStartDt'] = $fiscalStartDt; 
			$result['Accountlist']=$this->commondatamodel->getAllRecordOrderBy('account_master','account_name','ASC');
			
			$accntYearData=$this->commondatamodel->getSingleRowByWhereCls('accounting_year_master',array("id"=>$yearid));
			$strtDt=str_replace('-','/',$accntYearData->start_date);
			$endDt=str_replace('-','/',$accntYearData->end_date);
			$result['acnt_dt_start']= date('m/d/Y',strtotime($strtDt));
			$result['acnt_dt_end']= date('m/d/Y',strtotime($endDt));
			
			$page ="dashboard/admin_dashboard/general_ledger/generalLedger.php";
			createbody_method($result, $page, $header, $session);
			
		}else{
			redirect('login','refresh');
		}
	}
	
	public function pdfGeneralLedger(){
        
		$session = $this->session->userdata('user_data');
		if ($this->session->userdata('user_data')) {
		 
		 ini_set('max_execution_time', 600);	 
		 
		 
		 $companyId = $session['school_id'];
		 $yearid = $session['accnt_year_id'];
   
		 
		$this->load->library('pdf');
		$pdf = $this->pdf->load();
		ini_set('memory_limit', '256M'); 
		 
		 
	   $fromdate = str_replace('-', '/', trim($this->input->post('from_date')));
	   $todate = str_replace('-', '/', trim($this->input->post('to_date')));
	   $accId = $this->input->post('account_id');
		/* $reportType = $this->input->post('reportType');*/ /* change done by shankha recomended by abhik 10.01.2019*/
	   $reportType = 'TYPE3';
	   
	   $frmDate = date("Y-m-d",strtotime($fromdate));
	   $toDate = date("Y-m-d",strtotime($todate));
	   
	  $fiscalStartDt = $this->generalmodel->getFiscalStartDt($yearid);
	   
	
	
	   
	   $result['accountname']=  $this->generalmodel->getAccountnameById($accId);
	   $result['accounting_period']=$this->generalmodel->getAccountingPeriod($yearid);
	   $result['company']=  $this->generalmodel->getCompanyNameById($companyId);
	   $result['companylocation']=  $this->generalmodel->getCompanyAddressById($companyId);
	   $result['fromDate'] = $fromdate;
	   $result['toDate'] = $todate;

	//    pre($result['accounting_period']);exit;
	   
	//    if($reportType=="TYPE3")
	//    {
		   $result['generalledger']= $this->generalmodel->getGeneralLedgerReportType3($frmDate,$toDate,$companyId,$yearid,$accId,$fiscalStartDt);
		   $this->freeDBResource($this->db->conn_id);
		   $page = 'dashboard/admin_dashboard/general_ledger/general_ledger_pdf.php';
	//    }
	   
	   //$html = $this->load->view($page, $result);
	   
	   
	   
	   $html = $this->load->view($page, $result, TRUE);
	   $pdf->WriteHTML($html); 
	   $output = 'generalledger' . date('Y_m_d_H_i_s') . '_.pdf'; 
	   $pdf->Output("$output", 'I');
	   exit();
	  
		 } else {
		   redirect('login', 'refresh');
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
    




    
} // end of class
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Generalvoucher extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('Generalvouchermodel','generalvouchermodel',TRUE);
		$this->load->model('commondatamodel','commondatamodel',TRUE);
    }


    public function index()
    {
        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
            $header="";              
                $result['module']="List";               
                $result['VoucherList'] = $this->generalvouchermodel->getAllGeneralVoucherList($session['school_id'],$session['acd_session_id'],$session['accnt_year_id']);
                // pre( $result['VoucherList']);exit;
			$page ="dashboard/admin_dashboard/general_voucher/general_voucher_list.php";
			createbody_method($result, $page, $header, $session);
			
		}else{
			redirect('login','refresh');
		}
    }

    public function general()
    {
        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{ 
            $accntYearData=$this->commondatamodel->getSingleRowByWhereCls('accounting_year_master',array("id"=>$session['accnt_year_id']));
			$strtDt=str_replace('-','/',$accntYearData->start_date);
			$endDt=str_replace('-','/',$accntYearData->end_date);
			$result['acnt_dt_start']= date('m/d/Y',strtotime($strtDt));
            $result['acnt_dt_end']= date('m/d/Y',strtotime($endDt));
                       
            if (empty($this->uri->segment(3))) {
                $result['mode']="ADD";           
                $result['module']="Add";
                $result['btnText']="Save";
                $result['btnTextLoader']="Saving...";
                
            }else {
                $result['mode']="EDIT";           
                $result['module']="Edit";
                $result['btnText']="Update";
                $result['btnTextLoader']="Updating...";
                $result['voucher_id']=$this->uri->segment(3);
                $result['accounthead'] = $this->commondatamodel->getListOfAccountWhereAccountsAreNotInBankAndCashGroup($session['school_id']);
                $result['generalVoucherDtl']=$this->generalvouchermodel->getGeneralVoucherDetailData($this->uri->segment(3));
                $result['generalVouchermaster'] = $this->generalvouchermodel->getGeneralVoucherMasterData($this->uri->segment(3), $session['school_id']);
            }  
            $header="";
            $result['AccountList'] = $this->commondatamodel->getOnlyBankAndCashAccountList($session['school_id']);
			$page ="dashboard/admin_dashboard/general_voucher/general_voucher.php";
			createbody_method($result, $page, $header, $session);
			
		}else{
			redirect('login','refresh');
		}
    }

    
    


    public function getAccountGroup()
    {
        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
            $account_id=$this->input->post('account_id');
            $ac_group=$this->generalvouchermodel->getGroupNameByAccId($account_id,$session['school_id']);
            if ($ac_group=="Cash") {
                echo "1";
            }else{
                echo "0";
            }
        }else{
            redirect('login','refresh');
        }
    }


    public function createDetails()
    {
        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
            
            $divNumber = $this->input->post('divSerialNumber');
            $acctag = $this->input->post('acctag');
            $amount = $this->input->post('amount');
            $transType =$acctag;

            $result['accounthead'] = $this->commondatamodel->getListOfAccountWhereAccountsAreNotInBankAndCashGroup($session['school_id']);
            
            /*  echo "<pre>";
              print_r($result['accounthead']);
              echo "</pre>"; */

            $result['divnumber'] = $divNumber;
            $result['acctag'] = $acctag;
            $result['amount'] = $amount;
            $page = 'dashboard/admin_dashboard/general_voucher/groupvoucherDtl.php';
            $this->load->view($page, $result);

        }else{
            redirect('login','refresh');
        }
    }


    public function saveVoucherData()
    {
        $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
            $school_id=$session['school_id'];
            $acd_session_id=$session['acd_session_id'];
            $accnt_year_id=$session['accnt_year_id'];
            $userid=$session['userid'];
            
            $paidto_rcv=$this->input->post('paidto_rcv');
            $Pay_Rc=$this->input->post('Pay_Rc');
            $account_id=$this->input->post('account_id');
            $amount=$this->input->post('amount');
            $narration=$this->input->post('narration');
            $debitcredit=$this->input->post('debitcredit');
            $acHead=$this->input->post('acHead');
            $amountDtl=$this->input->post('amountDtl');
            $total_debit=$this->input->post('total_debit');
            $total_credit=$this->input->post('total_credit');
            
            $voucher_date = date_ymd($this->input->post('voucher_date'));
           

            if (!empty($this->input->post('cheque_no'))) {
                $cheque_no=$this->input->post('cheque_no');
            }else{
                $cheque_no=null;
            }

            if (!empty($this->input->post('cheque_date'))) {                
                $cheque_date=date_ymd($this->input->post('cheque_date'));
            }else{
                $cheque_date=null;
            }

            if ($Pay_Rc=='RC') {
                // echo "RC";
                $loop1=1;
                $loop2=sizeof($debitcredit);
                $is_debit1='Y';
                $is_debit2='N';
            }else{
                // echo "PY";
                $loop1=1;
                $loop2=sizeof($debitcredit);
                $is_debit1='N';
                $is_debit2='Y';
            }


            // pre($this->input->post());exit;
            if($this->input->post('mode')=='ADD')
            {
                $user_activity = array(
                    "activity_module" => 'generalvoucher',
                    "action" => 'Insert',
                    "from_method" => 'generalvoucher/saveVoucherData',
                    "user_id" => $userid,
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
				 );
				 $insert_arr=array(
					 "voucher_number"=>$this->commondatamodel->createVoucherNumber($school_id,$acd_session_id,$Pay_Rc,$accnt_year_id),
					 "voucher_date"=>$voucher_date,
					 "narration"=>$narration,
					 "cheque_number"=>$cheque_no,
					 "cheque_date"=>$cheque_date,
					 "chq_clear_on"=>"",
					 "is_chq_clear"=>"",
					 "transaction_type"=>$Pay_Rc,
					 "created_by"=>$userid,
					 "school_id"=>$school_id,
					 "acdm_session_id"=>$acd_session_id,
					 "accnt_year_id"=>$accnt_year_id,
                     "serial_number"=>"0",
                     "is_frm_receipt"=>'N',
					 "vouchertype"=>"GV",
					 "paid_to"=>$paidto_rcv,					
					 "total_debit"=>$total_debit,					
					 "total_credit"=>$total_credit					
                 );
                  //pre($insert_arr);exit;
                $voucher_master_id=$this->commondatamodel->insertSingleTableDataRerurnInsertId("voucher_master",$insert_arr);
                
                    $arr_loop1=array(
                        "voucher_master_id"=>$voucher_master_id,
                        "account_master_id"=>$account_id,
                        "tran_type"=>NULL,                        
                        "voucher_amount"=>$amount,
                        "is_master"=>"Y",
                        "is_debit"=>$is_debit1
                    ); 

                    $this->commondatamodel->insertSingleTableData("voucher_detail",$arr_loop1);
                    // echo 'loop1';
                    // pre($arr_loop1);
                

                 for ($j=0; $j <$loop2 ; $j++) {                     
                    $arr_loop2=array(
                        "voucher_master_id"=>$voucher_master_id,
                        "account_master_id"=>$acHead[$j],
                        "tran_type"=>NULL,
                        "voucher_amount"=>$amountDtl[$j],
                        "is_master"=>"N",
                        "is_debit"=>$is_debit2
                    );
                    $this->commondatamodel->insertSingleTableData("voucher_detail",$arr_loop2);
                    // echo 'loop2';
                    // pre($arr_loop2);
                 }  
                //  exit;              
                $insert= $this->commondatamodel->insertSingleTableData("activity_log",$user_activity);
                if($insert)
                {
                    $json_response = array(
                     "msg_status" => HTTP_SUCCESS,
                     "msg_data" => "Saved successfully",                     
                    );
                }else{
                    $json_response = array(
                     "msg_status" => HTTP_FAIL,
                     "msg_data" => "There is some problem.Try again"
                    );
                }             
            }else{
                $voucher_id=$this->input->post('voucher_id');
                $user_activity = array(
                    "activity_module" => 'generalvoucher',
                    "action" => 'Update',
                    "from_method" => 'generalvoucher/saveVoucherData',
                    "user_id" => $userid,
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
                );
                 
                $updt_arr=array(                    
                    "voucher_date"=>$voucher_date,
                    "narration"=>$narration,
                    "cheque_number"=>$cheque_no,
                    "cheque_date"=>$cheque_date,
                    "chq_clear_on"=>"",
                    "is_chq_clear"=>"",
                    // "transaction_type"=>$Pay_Rc,
                    "created_by"=>$userid,                                        
                    "paid_to"=>$paidto_rcv,					
                    "total_debit"=>$total_debit,					
                    "total_credit"=>$total_credit					
                );
                $this->commondatamodel->updateSingleTableData("voucher_master",$updt_arr,array("id"=>$voucher_id));
                $this->commondatamodel->deleteTableData('voucher_detail',array("voucher_master_id"=>$voucher_id));
                $arr_loop1=array(
                    "voucher_master_id"=>$voucher_id,
                    "account_master_id"=>$account_id,
                    "tran_type"=>NULL,                        
                    "voucher_amount"=>$amount,
                    "is_master"=>"Y",
                    "is_debit"=>$is_debit1
                ); 
                $this->commondatamodel->insertSingleTableData("voucher_detail",$arr_loop1);
                
                for ($j=0; $j <$loop2 ; $j++) {                     
                    $arr_loop2=array(
                        "voucher_master_id"=>$voucher_id,
                        "account_master_id"=>$acHead[$j],
                        "tran_type"=>NULL,
                        "voucher_amount"=>$amountDtl[$j],
                        "is_master"=>"N",
                        "is_debit"=>$is_debit2
                    );
                    $this->commondatamodel->insertSingleTableData("voucher_detail",$arr_loop2);                
                }
                $insert= $this->commondatamodel->insertSingleTableData("activity_log",$user_activity);  
                if($insert)
                {
                    $json_response = array(
                     "msg_status" => HTTP_SUCCESS,
                     "msg_data" => "Updated successfully",                     
                    );
                }else{
                    $json_response = array(
                     "msg_status" => HTTP_FAIL,
                     "msg_data" => "There is some problem.Try again"
                    );
                }
            }
            header('Content-Type: application/json');
            echo json_encode( $json_response );
            exit;
        }else{
            redirect('login','refresh');
        }
    }
    
    public function deleteVoucher()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$voucher_id=$this->input->post('voucher_id');			
			$this->commondatamodel->deleteTableData('voucher_detail',array("voucher_master_id"=>$voucher_id));
			$this->commondatamodel->deleteTableData('voucher_master',array("id"=>$voucher_id));

			$user_activity = array(
				"activity_module" => 'generalvoucher',
				"action" => 'Delete',
				"from_method" => 'generalvoucher/deleteVoucher',
				"user_id" => $session['userid'],
				"ip_address" => getUserIPAddress(),
				"user_browser" => getUserBrowserName(),
				"user_platform" => getUserPlatform()
			 );
			 $insert=$this->commondatamodel->insertSingleTableData('activity_log',$user_activity);
			 if($insert)
             {
                 $json_response = array(
                     "msg_status" => HTTP_SUCCESS,
                     "msg_data" => "Deleted successfully",
                     
                 );
             }else{
                 $json_response = array(
                     "msg_status" => HTTP_FAIL,
                     "msg_data" => "There is some problem.Try again"
                 );
             }
             header('Content-Type: application/json');
             echo json_encode( $json_response );
             exit;

		}else{
			redirect('login','refresh');
		}
	}








} // end of class
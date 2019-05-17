<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contra extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('contramodel','contramodel',TRUE);
		$this->load->model('commondatamodel','commondatamodel',TRUE);
    }

    public function index()
	{
		 $session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$acd_session_id=$session['acd_session_id'];
			$accnt_year_id=$session['accnt_year_id'];
			$school_id=$session['school_id'];
		  //  print_r("index");exit;
            $header = "";
            $result="";
			$result['ContraList'] = $this->contramodel->getAllContraVoucherList($school_id,$acd_session_id,$accnt_year_id); 
			$page = "dashboard/admin_dashboard/contra/contra_list";
			// $page = "dashboard/admin_dashboard/contra/add_edit_contra";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
    }
    
    public function contra()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$header = "";
			$result['AccountList'] = $this->contramodel->getAccountList($session['school_id']);

			$accntYearData=$this->commondatamodel->getSingleRowByWhereCls('accounting_year_master',array("id"=>$session['accnt_year_id']));
			$strtDt=str_replace('-','/',$accntYearData->start_date);
			$endDt=str_replace('-','/',$accntYearData->end_date);
			$result['acnt_dt_start']= date('m/d/Y',strtotime($strtDt));
			$result['acnt_dt_end']= date('m/d/Y',strtotime($endDt));
			
			if (empty($this->uri->segment(3)))
			{
                $result['mode']="ADD";           
                $result['module']="Add";
                $result['btnText']="Save";
                $result['btnTextLoader']="Saving...";
            }else{
                $result['mode']="EDIT";           
                $result['module']="Edit";
                $result['btnText']="Update";
                $result['btnTextLoader']="Updating...";
				$result['voucher_id']=$this->uri->segment(3);
				$where=[
					"id"=>$this->uri->segment(3)
				];
				$where1=[
					"voucher_master_id"=>$this->uri->segment(3),
					"is_debit"=>"Y"
				];
				$where2=[
					"voucher_master_id"=>$this->uri->segment(3),
					"is_debit"=>"N"
				];
				$result['ContraEditData']=$this->commondatamodel->getSingleRowByWhereCls('voucher_master',$where);
				$result['ContraDebitData']=$this->commondatamodel->getSingleRowByWhereCls('voucher_detail',$where1);
				$result['ContraCreditData']=$this->commondatamodel->getSingleRowByWhereCls('voucher_detail',$where2);
				// pre($result['ContraDebitData']);exit;
			}
            
                 
             	
            		
			$page = "dashboard/admin_dashboard/contra/add_edit_contra";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
	}

	public function createVoucherNumber($school_id,$accnt_year_id,$acd_session_id)
	{
		$where=[
			"id"=>$accnt_year_id
		];
		$year=$this->commondatamodel->getSingleRowByWhereCls('accounting_year_master',$where);
		$start_yr=substr($year->start_yr,2);
		$end_yr=substr($year->end_yr,2);
		$serial=$this->contramodel->getSerialnumber($school_id,$acd_session_id);
		
		$voucher_no="CN/".$serial."/".$start_yr."-".$end_yr;
		// echo $voucher_no;exit;
		return $voucher_no;
	}

	public function insertUpdate()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			
			$acd_session_id=$session['acd_session_id'];
			$accnt_year_id=$session['accnt_year_id'];
			$school_id=$session['school_id'];
			$userid=$session['userid'];

			$mode=$this->input->post('mode');

			// $voucherDate = str_replace('/', '-',$this->input->post('voucher_date'));		
			// $voucher_date=date("Y-m-d",strtotime($voucherDate));
			$voucher_date=date_ymd($this->input->post('voucher_date'));

			$narration=$this->input->post('narration');
			$cheque_number=$this->input->post('cheque_no');

			
			if ($this->input->post('cheque_date')!="" && !empty($this->input->post('cheque_date'))) {
				// $chequeDate = str_replace('/', '-', trim($this->input->post('cheque_date')));
				// $cheque_date=date("Y-m-d",strtotime($chequeDate));
				$cheque_date=date_ymd($this->input->post('cheque_date'));
			}else{
				$cheque_date=NULL;
			}
					

			$debit_ac=$this->input->post('debit_ac');		
			$debit_amount=$this->input->post('debit_amount');		
			$credit_ac=$this->input->post('credit_ac');		
			$credit_amount=$this->input->post('credit_amount');		
			$total_debit=$this->input->post('total_debit');		
			$total_credit=$this->input->post('total_credit');		
			

			if ($mode=='ADD') {
				/* Add mode part */
                $user_activity = array(
                    "activity_module" => 'contra',
                    "action" => 'Insert',
                    "from_method" => 'contra/insertUpdate',
                    "user_id" => $session['userid'],
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
				 );
				 $insert_arr=array(
					 "voucher_number"=>$this->createVoucherNumber($school_id,$accnt_year_id,$acd_session_id),
					 "voucher_date"=>$voucher_date,
					 "narration"=>$narration,
					 "cheque_number"=>$cheque_number,
					 "cheque_date"=>$cheque_date,
					 "chq_clear_on"=>"",
					 "is_chq_clear"=>"",
					 "transaction_type"=>'CN',
					 "created_by"=>$userid,
					 "school_id"=>$school_id,
					 "acdm_session_id"=>$acd_session_id,
					 "accnt_year_id"=>$accnt_year_id,
					 "serial_number"=>"0",
					 "vouchertype"=>NULL,
					 "paid_to"=>NULL,					
					 "total_debit"=>$total_debit,					
					 "total_credit"=>$total_credit					
				 );
				 $voucher_master_id=$this->commondatamodel->insertSingleTableDataRerurnInsertId("voucher_master",$insert_arr);
				 $arr_D=array(
					 "voucher_master_id"=>$voucher_master_id,
					 "account_master_id"=>$debit_ac,
					 "tran_type"=>NULL,
					 "voucher_amount"=>$debit_amount,
					 "is_debit"=>'Y'
				 );
				 $arr_C=array(
					 "voucher_master_id"=>$voucher_master_id,
					 "account_master_id"=>$credit_ac,
					 "tran_type"=>NULL,
					 "voucher_amount"=>$credit_amount,
					 "is_debit"=>'N'
				 );
				//  pre($arr_D);
				$insertArray=array($user_activity,$arr_D,$arr_C);
				$tblnameArry=array("activity_log","voucher_detail","voucher_detail");
				$insert=$this->commondatamodel->insertMultiTableData($tblnameArry,$insertArray);

			}else{
				/* Edit mode part */

				$voucher_id=$this->input->post('voucher_id');
				$user_activity = array(
                    "activity_module" => 'contra',
                    "action" => 'Update',
                    "from_method" => 'contra/insertUpdate',
                    "user_id" => $session['userid'],
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
				 );
				 $update_arr=array(					 
					 "voucher_date"=>$voucher_date,
					 "narration"=>$narration,
					 "cheque_number"=>$cheque_number,
					 "cheque_date"=>$cheque_date,					
					 "created_by"=>$userid,
					 "school_id"=>$school_id,
					 "acdm_session_id"=>$acd_session_id,					 					
					 "accnt_year_id"=>$accnt_year_id,					 					
					 "total_debit"=>$total_debit,					
					 "total_credit"=>$total_credit					
				 );	
				 $arr_D=array(
					"voucher_master_id"=>$voucher_id,
					"account_master_id"=>$debit_ac,
					"tran_type"=>null,
					"voucher_amount"=>$debit_amount,
					"is_debit"=>'Y'
				);
				$arr_C=array(
					"voucher_master_id"=>$voucher_id,
					"account_master_id"=>$credit_ac,
					"tran_type"=>null,
					"voucher_amount"=>$credit_amount,
					"is_debit"=>'N'
				);
				$where_updt=[
					"id"=>$voucher_id
				];

				$update=$this->commondatamodel->updateSingleTableData('voucher_master',$update_arr,$where_updt);

				if ($update) {
					$dlt_where=["voucher_master_id"=>$voucher_id];

					$this->commondatamodel->deleteTableData('voucher_detail',$dlt_where);//delete old data to insert updated data
					$insertArray=array($user_activity,$arr_D,$arr_C);
					$tblnameArry=array("activity_log","voucher_detail","voucher_detail");
					$insert=$this->commondatamodel->insertMultiTableData($tblnameArry,$insertArray);
				}
				
			}
			

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
             header('Content-Type: application/json');
             echo json_encode( $json_response );
             exit;
		}else{
			redirect('login','refresh');
		}
	}


	public function deleteContraVoucher()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$voucher_id=$this->input->post('voucher_id');			
			$this->commondatamodel->deleteTableData('voucher_detail',array("voucher_master_id"=>$voucher_id));
			$this->commondatamodel->deleteTableData('voucher_master',array("id"=>$voucher_id));

			$user_activity = array(
				"activity_module" => 'contra',
				"action" => 'Delete',
				"from_method" => 'contra/deleteContraVoucher',
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




}  // end of class
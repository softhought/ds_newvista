<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Journal extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		$this->load->model('commondatamodel','commondatamodel',TRUE);
		$this->load->model('journalmodel','journalmodel',TRUE);		
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
			$result['journalList'] = $this->journalmodel->getAllJournalVoucherList($school_id,$acd_session_id,$accnt_year_id); 
			$page = "dashboard/admin_dashboard/journal_entry/journal_list";
			// $page = "dashboard/admin_dashboard/journal_entry/journal";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
    }
    
    public function journal()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$header = "";
			$page ="";
			$result['AccountList'] = $this->journalmodel->getAccountList($session['school_id']);

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
				$page = "dashboard/admin_dashboard/journal_entry/journal";
				createbody_method($result, $page, $header, $session);
            }else{
				$existance=$this->commondatamodel->checkExistanceData("voucher_master",array("id"=>$this->uri->segment(3)));
				if ($existance) {
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
					];				
					$result['JournalEditData']=$this->commondatamodel->getSingleRowByWhereCls('voucher_master',$where);					
					$result['voucherDetailsData']=$this->commondatamodel->getAllRecordWhere('voucher_detail',$where1);					
					// pre($result['voucherDetailsData']);exit;
					$page = "dashboard/admin_dashboard/journal_entry/journal";
					createbody_method($result, $page, $header, $session);
				}else{
					$page = "dashboard/error_page/404_notfound";
					$this->load->view($page);
				}
                
			}            		
			
			
			
		}
		else
		{
			redirect('login','refresh');
		}
	}

	public function createVoucherNumber($school_id,$acd_session_id,$accnt_year_id)
	{
		$where=[
			"id"=>$accnt_year_id
		];
		$year=$this->commondatamodel->getSingleRowByWhereCls('accounting_year_master',$where);
		$start_yr=substr($year->start_yr,2);
		$end_yr=substr($year->end_yr,2);
		$serial=$this->commondatamodel->getSerialnumber($school_id,$acd_session_id);
		
		$voucher_no="JV/".$serial."/".$start_yr."-".$end_yr;
		// echo $voucher_no;exit;
		return $voucher_no;
	}
	public function addMore()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$result['count'] = $this->input->post('count');
			$result['AccountList'] = $this->journalmodel->getAccountList($session['school_id']);
			$page = 'dashboard/admin_dashboard/journal_entry/addmore.php';
			$this->load->view($page, $result);
		}else{
			redirect('login','refresh');
		}
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
			$voucher_date=date_ymd($this->input->post('voucher_date'));
			$narration=$this->input->post('narration');
			$cheque_number=$this->input->post('cheque_no');

			
			if ($this->input->post('cheque_date')!="" && !empty($this->input->post('cheque_date'))) {	
				$cheque_date=date_ymd($this->input->post('cheque_date'));
			}else{
				$cheque_date=NULL;
			}
					

			$ac_tag=$this->input->post('ac_tag');		
			$account=$this->input->post('account');		
			$amount=$this->input->post('amount');	
			$total_debit=$this->input->post('total_debit');		
			$total_credit=$this->input->post('total_credit');
			// pre($debit_ac)	;exit;	
			

			if ($mode=='ADD') {
				/* Add mode part */
                $user_activity = array(
                    "activity_module" => 'contra',
                    "action" => 'Insert',
                    "from_method" => 'journal/insertUpdate',
                    "user_id" => $session['userid'],
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
				 );
				 $insert_arr=array(
					 "voucher_number"=>$this->createVoucherNumber($school_id,$acd_session_id,$accnt_year_id),
					 "voucher_date"=>$voucher_date,
					 "narration"=>$narration,
					 "cheque_number"=>$cheque_number,
					 "cheque_date"=>$cheque_date,
					 "chq_clear_on"=>"",
					 "is_chq_clear"=>"",
					 "transaction_type"=>"JV",
					 "created_by"=>$userid,
					 "school_id"=>$school_id,
					 "acdm_session_id"=>$acd_session_id,
					 "accnt_year_id"=>$accnt_year_id,
					 "serial_number"=>"0",
					 "is_frm_receipt"=>'N',
					 "vouchertype"=>"JV",
					 "paid_to"=>NULL,					
					 "total_debit"=>$total_debit,					
					 "total_credit"=>$total_credit					
				 );
				$voucher_master_id=$this->commondatamodel->insertSingleTableDataRerurnInsertId("voucher_master",$insert_arr);
				for ($i=0; $i <sizeof($ac_tag) ; $i++) { 

					if ($ac_tag[$i]=='Dr') {
						$is_debit='Y';
					}else {
						$is_debit='N';
					}
					// $arr_D=array(
					// 	"voucher_master_id"=>$voucher_master_id,
					// 	"account_master_id"=>$debit_ac[$i],
					// 	"tran_type"=>NULL,
					// 	"voucher_amount"=>$debit_amount[$i],
					// 	"is_debit"=>'Y'
					// );
					$arr_Cr_Dr=array(
						"voucher_master_id"=>$voucher_master_id,
						"account_master_id"=>$account[$i],
						"tran_type"=>NULL,
						"voucher_amount"=>$amount[$i],
						"is_debit"=>$is_debit
					);
					$this->commondatamodel->insertSingleTableData("voucher_detail",$arr_Cr_Dr);
				}				 
				$insert=$this->commondatamodel->insertSingleTableData("activity_log",$user_activity);
				//  pre($arr_D);			

			}else{
				/* Edit mode part */

				$voucher_id=$this->input->post('voucher_id');
				$user_activity = array(
                    "activity_module" => 'contra',
                    "action" => 'Update',
                    "from_method" => 'journal/insertUpdate',
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
				 
				
				$dlt_where=["voucher_master_id"=>$voucher_id];
				$this->commondatamodel->deleteTableData('voucher_detail',$dlt_where);//delete old data to insert updated data

				$where_updt=[
					"id"=>$voucher_id
				];
				$update=$this->commondatamodel->updateSingleTableData('voucher_master',$update_arr,$where_updt);

				if ($update) {					
					for ($i=0; $i <sizeof($ac_tag) ; $i++) { 

						if ($ac_tag[$i]=='Dr') {
							$is_debit='Y';
						}else {
							$is_debit='N';
						}
						// $arr_D=array(
						// 	"voucher_master_id"=>$voucher_master_id,
						// 	"account_master_id"=>$debit_ac[$i],
						// 	"tran_type"=>NULL,
						// 	"voucher_amount"=>$debit_amount[$i],
						// 	"is_debit"=>'Y'
						// );
						$arr_Cr_Dr=array(
							"voucher_master_id"=>$voucher_id,
							"account_master_id"=>$account[$i],
							"tran_type"=>NULL,
							"voucher_amount"=>$amount[$i],
							"is_debit"=>$is_debit
						);
						$this->commondatamodel->insertSingleTableData("voucher_detail",$arr_Cr_Dr);
					}				
					
				}
				$insert=$this->commondatamodel->insertSingleTableData("activity_log",$user_activity);
				
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

	public function deleteVoucher()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$voucher_id=$this->input->post('voucher_id');			
			$this->commondatamodel->deleteTableData('voucher_detail',array("voucher_master_id"=>$voucher_id));
			$this->commondatamodel->deleteTableData('voucher_master',array("id"=>$voucher_id));

			$user_activity = array(
				"activity_module" => 'journal',
				"action" => 'Delete',
				"from_method" => 'journal/deleteVoucher',
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



}/* end of class */
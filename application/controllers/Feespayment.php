<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feespayment extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('Studentmodel','Studentmodel',TRUE);
		$this->load->model('feespaymentmodel','feespaymentmodel',TRUE);		
	}


	public function index()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$header = "";
			
				
			$result['classList']=$this->commondatamodel->getAllDropdownData('class_master');
			$result['sectionList']=$this->commondatamodel->getAllDropdownData('section_master');
			$result['monthList']=$this->commondatamodel->getAllDropdownData('month_master');				
			$page = "dashboard/admin_dashboard/fees_payment/fees_payment_view";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
	}

	public function paymentEdit()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$header = "";
			$result['mode'] = "EDIT";
			$paymentid = $this->uri->segment(3);
			$result['classList']=$this->commondatamodel->getAllDropdownData('class_master');
			$result['sectionList']=$this->commondatamodel->getAllDropdownData('section_master');
			$result['monthList']=$this->commondatamodel->getAllDropdownData('month_master');
			$result['studentinfo']=$this->feespaymentmodel->getStudentDetailsByPaymentId($paymentid);
			$result['DebitAccountId']=$this->feespaymentmodel->getDebitAccountId($paymentid);
			$result['fessComponentData']=$this->feespaymentmodel->getFeesComponentListbyPaymentId($paymentid);
			$result['paymentMonthList']=$this->feespaymentmodel->getPaymentMonthbyPaymentId($paymentid);
			$result['PaymentModeList']=$this->commondatamodel->getAllDropdownData('payment_mode_master');
			$result['AccountList']=$this->commondatamodel->getOnlyBankAndCashAccountList($session['school_id']);
// pre($result['studentinfo']);exit;

			  
			$accntYearData=$this->commondatamodel->getSingleRowByWhereCls('accounting_year_master',array("id"=>$session['accnt_year_id']));
			$strtDt=str_replace('-','/',$accntYearData->start_date);
			$endDt=str_replace('-','/',$accntYearData->end_date);
			$result['acnt_dt_start']= date('d/m/Y',strtotime($strtDt));
			$result['acnt_dt_end']= date('d/m/Y',strtotime($endDt));


			// pre($result);exit;
			foreach ($result['paymentMonthList'] as $key => $value) {
				$sel_month[]=$value->month_id;
			}

			foreach ($sel_month as  $value) {
            	$monthids[]=$value;
            	$where_mon_id = array('month_master.id' =>$value);
            	$monthData=$this->commondatamodel->getSingleRowByWhereCls('month_master',$where_mon_id);
            	$result['monthsname'][]=$monthData->month_code;
            }

             $result['monthids_string'] = implode(',', $monthids);
			// pre($result['DebitAccountId']);
			$page = "dashboard/admin_dashboard/fees_payment/fees_payment_view_edit";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
	}

	public function payment_history()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$header = "";
			
				
			$result['classList']=$this->commondatamodel->getAllDropdownData('class_master');
			$result['sectionList']=$this->commondatamodel->getAllDropdownData('section_master');
			$result['monthList']=$this->commondatamodel->getAllDropdownData('month_master');
			$where = array(						
				'academic_details.school_id' =>$session['school_id'],
				'academic_details.acdm_session_id' =>$session['acd_session_id'],
			);
			$result['studentList']=$this->feespaymentmodel->getStudentListbyAcademicSessionAndSchoolId($where);
			$page = "dashboard/admin_dashboard/fees_payment/payment_history_list_view";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
	}



	/* get  district by state*/
public function getStudent()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$classid = $this->input->post('acdm_class');
			$acdm_section = $this->input->post('acdm_section');

			/*$where_dist = array('district.state_id' => $stateid, ); 
			$result['districtList']=$this->commondatamodel->getAllRecordWhere('district',$where_dist);*/

			if ($classid!='0' && $acdm_section!='0') {
				
			$result['studentList']=$this->Studentmodel->getStudentListbyClassSection($classid,$acdm_section);
			}elseif($classid!='0'){
			$result['studentList']=$this->Studentmodel->getStudentListbyClass($classid);
			}
			else{
				$result['studentList']=[];	
			}


			/*pre($result['studentList']);

			exit;*/
			 

			$page = "dashboard/admin_dashboard/fees_payment/student_view";
			//$partial_view = $this->load->view($page,$result);
			echo $this->load->view($page, $result, TRUE);
			//echo $partial_view;
		}
		else
		{
			redirect('login','refresh');
		}
	}

	public function checkPaymentGivenMonths()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$studentid = $this->input->post('studentid');
			$acdm_class = $this->input->post('acdm_class');
			$school_id=$session['school_id'];
			$acd_session_id=$session['acd_session_id'];
			$accnt_year_id=$session['accnt_year_id'];
			
			$where=[
				"payment_master.student_id"=>$studentid,
				"payment_master.school_id"=>$school_id,
				"payment_master.acdm_session_id"=>$acd_session_id,
				"payment_master.accnt_year_id"=>$accnt_year_id,
				"payment_master.class_id"=>$acdm_class
			];
			$join_on="payment_master.payment_id=payment_month_dtl.payment_master_id";
			$month=$this->feespaymentmodel->getAlreadyPaidMonthList('payment_master','payment_month_dtl',$join_on,$where);

			if (sizeof($month)>0) {
				$month_id="";
				for ($i=0; $i <sizeof($month) ; $i++) { 
					$month_id.=$month[$i].',';
				}
				
				// pre($month_id);
				// exit;
							
				$result['PaidMonthList']=$month_id;
			}else{				
				$result['PaidMonthList']="";
			}
			$result['monthList']=$this->commondatamodel->getAllDropdownData('month_master');	

			
			 

			$page = "dashboard/admin_dashboard/fees_payment/month_list_view";			
			echo $this->load->view($page, $result, TRUE);			
		}
		else
		{
			redirect('login','refresh');
		}
	}



	public function getPaymentComponentList()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$formData = $this->input->post('formDatas');
			//pre($formData);exit;
			parse_str($formData, $dataArry);
			$result=[];

		    $result['mode'] = "ADD";
		    $result['btnText'] = "Save";
			
            $studentid = $dataArry['studentid'];
            $result['studentid']=$studentid;
            $sel_month = $dataArry['sel_month'];
            $class_id = $dataArry['acdm_class'];
            $session['school_id'];
            $session['acd_session_id'];
            

            foreach ($sel_month as  $value) {
            	$monthids[]=$value;
            	$where_mon_id = array('month_master.id' =>$value);
            	$monthData=$this->commondatamodel->getSingleRowByWhereCls('month_master',$where_mon_id);
            	$result['monthsname'][]=$monthData->month_code;
            }

             $result['monthids_string'] = implode(',', $monthids);
            //$destination_array = explode(',', $string_version);
            //print_r($destination_array);
			$result['studentData']=$this->Studentmodel->getStudentDataEditbyId($studentid,$session['acd_session_id']);
			$result['PaymentModeList']=$this->commondatamodel->getAllDropdownData('payment_mode_master');
			$result['AccountList']=$this->commondatamodel->getOnlyBankAndCashAccountList($session['school_id']);
          
          	$classid=$result['studentData']->class_id;
			  
			$accntYearData=$this->commondatamodel->getSingleRowByWhereCls('accounting_year_master',array("id"=>$session['accnt_year_id']));
			$strtDt=str_replace('-','/',$accntYearData->start_date);
			$endDt=str_replace('-','/',$accntYearData->end_date);
			$result['acnt_dt_start']= date('d/m/Y',strtotime($strtDt));
			$result['acnt_dt_end']= date('d/m/Y',strtotime($endDt));


			// pre($accntYearData->start_date);

			  //$result['fessComponentData']=$this->feespaymentmodel->getFeesComponentListbyClass($classid,$monthids,$session['acd_session_id']);
			  

			 // $result['GetPaidComponentId']=$this->feespaymentmodel->getPaidComponentIdForSelectedMonth($studentid,$session['school_id'],$session['acd_session_id']);
			 

			 $GetPaidComponentArr=array();
			 $GetPaidComponentArr1=array();
			 $getAllComponentIdArr=array();
			 
			 foreach ($sel_month as  $month_id) {
				/**************paid component**************/
				$GetPaidComponentId=$this->feespaymentmodel->getPaidComponentId($studentid,$month_id,$class_id,$session['school_id'],$session['acd_session_id']);
					array_push($GetPaidComponentArr,$GetPaidComponentId);
				
				foreach ($GetPaidComponentId as $value) {
					$object = (object) $value;				 
				 	array_push($GetPaidComponentArr1,$object);
					
				 }

				/**************All component**************/
				$getAllComponentId=$this->feespaymentmodel->getAllComponentId($month_id,$class_id,$session['school_id'],$session['acd_session_id']);				
				array_push($getAllComponentIdArr,$getAllComponentId);
				
			}


			/**************paid component final array **************/

			$amount=[];
			$comp_desc=[];
			$feesID=[];
			$month=[];
			$monthCode=[];
			$total_amount=[];	
				
			foreach ($GetPaidComponentArr1 as $value) {
				
			$indexx = $value->fees_id;
				if (!array_key_exists($indexx, $total_amount)) {
					$comp_desc[$indexx]='';
					$amount[$indexx]=0;
					$feesID[$indexx]=0;
					$month[$indexx]="";
					$total_amount[$indexx]=0;
					$monthCode[$indexx]="";
				}
				
				$total_amount[$indexx]+=$value->amount;
				$amount[$indexx]=$value->amount;
				$comp_desc[$indexx]=$value->fees_desc;
				$feesID[$indexx]=$value->fees_id;
				if($month[$indexx]=="")
				{
					$month[$indexx]=$value->month_id;
				}else{
					$month[$indexx]=$month[$indexx].','.$value->month_id;
				}

				if($monthCode[$indexx]=="")
				{
					$monthCode[$indexx]=$value->month_code;
				}else{
					$monthCode[$indexx]=$monthCode[$indexx].','.$value->month_code;
				}

				
			}
			$PaidComponentFinalArray=array();
			foreach ($total_amount as $key => $total_amount2) {
				$PaidComponentFinalArray[]=[
					"fees_id"=>$feesID[$key],
					"fees_desc"=>$comp_desc[$key],
					 "month_id"=>$month[$key],
					 "month_code"=>$monthCode[$key],
					"amount"=>$amount[$key],
					"total_amount"=>$total_amount2
				];
				}

		//	pre($PaidComponentFinalArray);

			/************** -/ paid component final array /- **************/



			/**************not paid component final array**************/
			$notPaidComponentArr=array();			
			for ($i=0; $i <sizeof($getAllComponentIdArr) ; $i++) { 
				//if(!empty($getAllComponentIdArr[$i]))	{			
					$diff=array_diff(array_map('json_encode',$getAllComponentIdArr[$i]),array_map('json_encode',$GetPaidComponentArr[$i]));
					$notPaidComponent=array_map('json_decode',$diff);					
					foreach ($notPaidComponent as $value) {
						//pre($value);
						array_push($notPaidComponentArr,$value);
					}
				//}
			}

			$d_comamt=[];
			$d_comdesc=[];
			$d_feesID=[];
			$d_month=[];
			$d_monthCode=[];
			$d_comtotalamt=[];

			foreach ($notPaidComponentArr as  $value) {				
				$index = $value->fees_id;

				if (!array_key_exists($index, $d_comtotalamt)) {$d_comdesc[$index]='';$d_comamt[$index]=0;$d_feesID[$index]=0;$d_month[$index]="";$d_comtotalamt[$index]=0;$d_monthCode[$index]="";}
				
				$d_comtotalamt[$index]+=$value->amount;
				$d_comamt[$index]=$value->amount;
				$d_comdesc[$index]=$value->fees_desc;
				$d_feesID[$index]=$value->fees_id;
				if($d_month[$index]=="")
				{
					$d_month[$index]=$value->month_id;
				}else{
					$d_month[$index]=$d_month[$index].','.$value->month_id;
				}

				if($d_monthCode[$index]=="")
				{
					$d_monthCode[$index]=$value->month_code;
				}else{
					$d_monthCode[$index]=$d_monthCode[$index].','.$value->month_code;
				}
				
			}
			$NotPaidComponentSumArray=array();
			foreach ($d_comtotalamt as $key => $d_comtotalamt) {
				$NotPaidComponentSumArray[]=[
					"fees_id"=>$d_feesID[$key],
					"fees_desc"=>$d_comdesc[$key],
					 "month_id"=>$d_month[$key],
					 "month_code"=>$d_monthCode[$key],
					"amount"=>$d_comamt[$key],
					"total_amount"=>$d_comtotalamt
				];
			}
			/************** -/ not paid component final array /- **************/



			// echo "SumArray";
			// pre($NotPaidComponentSumArray);

			// echo "notpaid";
			// pre($notPaidComponentArr);
			// echo "<br>";
			// echo "paid";
			//  pre($PaidComponentFinalArray);
			//pre($GetPaidComponentArr1);

			//pre($getAllComponentIdArr);
			//pre($GetPaidComponentArr);
			
		/*********** yearly once fees *****************/			

			$OnceInAyearComponent=$this->feespaymentmodel->getOnceInAyearComponentId($class_id,$session['school_id'],$session['acd_session_id']);

			$OnceInAyearPaidComponent=$this->feespaymentmodel->getOnceInAyearPaidComponentId($studentid,$class_id,$session['school_id'],$session['acd_session_id']);
			
				$OnceInAyearNotPaidComponent=array();				
						$diff1=array_diff(array_map('json_encode',$OnceInAyearComponent),array_map('json_encode',$OnceInAyearPaidComponent));
						$OnceInAyearNotPaidComponent= array_map('json_decode',$diff1);		
					
		/*********** yearly once fees *****************/



		/*********** once in life time fees *****************/			

			$OnceInLifeTimeComponent=$this->feespaymentmodel->getOnceInLifeTimeComponentId($session['school_id']);

			$OnceInLifeTimePaidComponent=$this->feespaymentmodel->getOnceInLifeTimePaidComponentId($studentid,$session['school_id']);
			
				$OnceInLifeTimeNotPaidComponent=array();				
						$diff1=array_diff(array_map('json_encode',$OnceInLifeTimeComponent),array_map('json_encode',$OnceInLifeTimePaidComponent));
						$OnceInLifeTimeNotPaidComponent= array_map('json_decode',$diff1);		
					
		/*********** once in life time fees *****************/

				
				$result['GetPaidComponentArr']=$PaidComponentFinalArray;
				$result['notPaidComponentArr']=$NotPaidComponentSumArray;

				$result['OnceInAyearComponent']=$OnceInAyearComponent;
				$result['OnceInAyearNotPaidComponent']=$OnceInAyearNotPaidComponent;
				$result['OnceInAyearPaidComponent']=$OnceInAyearPaidComponent;

				$result['OnceInLifeTimeComponent']=$OnceInLifeTimeComponent;
				$result['OnceInLifeTimeNotPaidComponent']=$OnceInLifeTimeNotPaidComponent;
				$result['OnceInLifeTimePaidComponent']=$OnceInLifeTimePaidComponent;
		

	//	pre($result['OnceInAyearPaidComponent']);
	// echo "All"	;
	// 	pre($result['OnceInAyearComponent']);		
	// echo "not paid"	;
	// 	pre($result['OnceInAyearNotPaidComponent']);
		// echo "paid"	;
		// pre($result['OnceInAyearPaidComponent']);
						
		//exit;


		
			$page = "dashboard/admin_dashboard/fees_payment/fees_payment_compnent_view.php";
			$partial_view = $this->load->view($page, $result, TRUE);
			echo $partial_view;
		}
		else
		{
			redirect('login','refresh');
		}
	}
	
/* get component list for edit*/

public function getPaymentComponentListPaymentEdit()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			$result=[];

		    $result['mode'] = "EDIT";
		    $result['btnText'] = "Update";
			
            $studentid = $dataArry['studentid'];
            $result['paymentID'] = $dataArry['paymentID'];
           
            $result['studentid']=$studentid;
            $sel_month = $dataArry['sel_month'];
            $session['school_id'];
            $session['acd_session_id'];


            foreach ($sel_month as  $value) {
            	$monthids[]=$value;
            	$where_mon_id = array('month_master.id' =>$value);
            	$monthData=$this->commondatamodel->getSingleRowByWhereCls('month_master',$where_mon_id);
            	$result['monthsname'][]=$monthData->month_code;
            }

             $result['monthids_string'] = implode(',', $monthids);
            //$destination_array = explode(',', $string_version);
            //print_r($destination_array);
            $result['studentData']=$this->Studentmodel->getStudentDataEditbyId($studentid,$session['acd_session_id']);
          
          	$classid=$result['studentData']->class_id;
          	

          	$result['fessComponentData']=$this->feespaymentmodel->getFeesComponentListbyClass($classid,$monthids);
			$result['PaymentModeList']=$this->commondatamodel->getAllDropdownData('payment_mode_master');
			$result['AccountList']=$this->commondatamodel->getOnlyBankAndCashAccountList($session['school_id']);
  
			// pre($result['fessComponentData']);
			$page = "dashboard/admin_dashboard/fees_payment/fees_payment_compnent_view.php";
			$partial_view = $this->load->view($page, $result, TRUE);
			echo $partial_view;
		}
		else
		{
			redirect('login','refresh');
		}
	}

	public function createVoucherNumber($school_id,$acd_session_id,$prefix)
	{
		$where=[
			"id"=>$acd_session_id
		];
		$year=$this->commondatamodel->getSingleRowByWhereCls('academic_session_master',$where);
		$start_yr=substr($year->start_yr,2);
		$end_yr=substr($year->end_yr,2);
		$serial=$this->commondatamodel->getSerialnumber($school_id,$acd_session_id);
		
		$voucher_no=$prefix."/".$serial."/".$start_yr."-".$end_yr;
		// echo $voucher_no;exit;
		return $voucher_no;
	}

	/* payment details save and edit */

	public function payment_action()
	{
		
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$acd_session_id=$session['acd_session_id'];
			$accnt_year_id=$session['accnt_year_id'];
			$school_id=$session['school_id'];
			$userid=$session['userid'];
			//pre($this->input->post());exit;
			$paymentID = $this->input->post('paymentID');
			$mode = $this->input->post('mode');
			$studentid = $this->input->post('studentid');
			$monthids = $this->input->post('monthids');
			$payment_mode = $this->input->post('payment_mode');
			$payment_date = $this->input->post('payment_date');

			$paid_amount= $this->input->post('paid_amount');
			$cheque_no= $this->input->post('cheque_no');
			$bank_name= $this->input->post('bank_name');
			$cheque_date= $this->input->post('cheque_date');
			$branch_name= $this->input->post('branch_name');
			$narration= $this->input->post('narration');
			$account_debit= $this->input->post('account_debit');

			$selected_component_ids=$this->input->post('selected_component_ids');
			$fessComponentData=json_decode($selected_component_ids);
			//pre($fessComponentData);
		
			// $component_amount_total= base64_decode($this->input->post('component_amount_total'));			
			// $fessComponentData=json_decode($component_amount_total);
			


			

			// $fees_id=explode(',',$fees_id);
			
			$monthids_array = explode(',', $monthids);

			 if($payment_date!=""){
				$payment_date = str_replace('/', '-', $payment_date);
				$payment_date = date("Y-m-d",strtotime($payment_date));
			 }
			 else{
				 $payment_date = NULL;
			}
			
			if($cheque_date!=""){
				$cheque_date = str_replace('/', '-', $cheque_date);
				$cheque_date = date("Y-m-d",strtotime($cheque_date));
			 }
			 else{
				 $cheque_date = NULL;
			}
			
			$total_pay_amount = $this->input->post('total_pay_amount');

			
			$result['studentData']=$this->Studentmodel->getStudentDataEditbyId($studentid,$session['acd_session_id']);
          
          	$classid=$result['studentData']->class_id;
          	$academic_dtl_id=$result['studentData']->academic_dtl_id;

			if($studentid!="")
			{
	
				
				
				if($paymentID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					$payment_master_id=$paymentID;
					$payment_mst_array_upd = array(
						"payment_date" => $payment_date,
						"payment_mode" => $payment_mode,
						"total_amount" => $total_pay_amount,
						// "total_amount" => $total_pay_amount,

						"paid_amount"=>$paid_amount,
						"cheque_no"=>$cheque_no,
						"bank_name"=>$bank_name,
						"cheque_date"=>$cheque_date,
						"branch_name"=>$branch_name,
						"narration"=>$narration,

						"last_modified" => date('Y-m-d')
					);
					// pre($payment_mst_array_upd);

					$where_upd_payment_mst = array(
						"payment_master.payment_id" => $paymentID
					);

					$user_activity = array(
						"activity_module" => 'caste',
						"action" => 'Update',
						"from_method" => 'Feespayment/payment_action',
						"user_id" => $session['userid'],
						"ip_address" => getUserIPAddress(),
						"user_browser" => getUserBrowserName(),
						"user_platform" => getUserPlatform()
					 );
					
					 

					/*
					@updateData_WithUserActivity('update table name','update table data','update table where condition','user activity table name','user activity table data');
					*/
					$update = $this->commondatamodel->updateData_WithUserActivity('payment_master',$payment_mst_array_upd,$where_upd_payment_mst,'activity_log',$user_activity);

					$where_payment_mon_dtl = array('payment_month_dtl.payment_master_id' =>$paymentID);
					$delete1 = $this->commondatamodel->deleteTableData('payment_month_dtl',$where_payment_mon_dtl);

					$where_payment_details = array('payment_details.payment_master_id' =>$paymentID);
					$delete1 = $this->commondatamodel->deleteTableData('payment_details',$where_payment_details);

					///////////////////////////////////////////////////////////////////////////////////



					$prefix=array('JV','RC');
					for ($i=0; $i <sizeof($prefix) ; $i++) { 
						if ($prefix[$i]=='JV') 
						{
							$amount=$total_pay_amount;
							$voucher_tag="J";
						}else{
							$amount=$paid_amount;
							$voucher_tag="R";
						}
						
						/* update voucher master  */
						$update_arr=array(							
							"voucher_date"=> $payment_date,
							"narration"=>$narration,
							"cheque_number"=>$cheque_no,
							"cheque_date"=>$cheque_date,
							"chq_clear_on"=>"",
							"is_chq_clear"=>"",
							// "transaction_type"=>'COL',
							"transaction_type"=>$prefix[$i],
							"created_by"=>$userid,
							"school_id"=>$school_id,
							"acdm_session_id"=>$acd_session_id,
							"accnt_year_id"=>$accnt_year_id,
							"serial_number"=>"0",
							"is_frm_receipt"=>"Y",
							"vouchertype"=>NULL,
							"paid_to"=>NULL,					
							"total_debit"=>$amount,					
							"total_credit"=>$amount					
						);
						$where_voucher_master_id=[
							"payment_id"=>$paymentID,
							"voucher_tag"=>$voucher_tag
						];
						$voucher_master_ids=$this->commondatamodel->getSingleRowByWhereCls('payment_voucher_ref',$where_voucher_master_id); // voucher master id

						$where_id=[
							"id"=>$voucher_master_ids->voucher_id
						];

						// pre($voucher_master_id->voucher_id);						
						$this->commondatamodel->updateSingleTableData('voucher_master',$update_arr,$where_id);
						/* update voucher master  end */

						

						/* update voucher detail */
						if ($prefix[$i]=='JV') 
						{
							$del_Where=[
								"voucher_master_id"=>$voucher_master_ids->voucher_id
							];							
							$this->commondatamodel->deleteTableData('voucher_detail',$del_Where);

							$whereS=[
								"student_id"=>$studentid
							];
							$arr_D=array(
								"voucher_master_id"=>$voucher_master_ids->voucher_id,
								"account_master_id"=>$this->feespaymentmodel->getSingleColumnData('account_id','student_master',$whereS),
								"tran_type"=>NULL,
								"voucher_amount"=>$total_pay_amount,
								"is_debit"=>'Y'
							);

							
							$this->commondatamodel->insertSingleTableData('voucher_detail',$arr_D);
	
							foreach ($fessComponentData as $fescomonent) {
								$where=[
									"id"=>$fescomonent->fees_id
								]; 
								$arr_C=array(
									"voucher_master_id"=>$voucher_master_ids->voucher_id,
									"account_master_id"=>$this->feespaymentmodel->getSingleColumnData('account_id','fees_structure',$where),
									"tran_type"=>NULL,
									"voucher_amount"=>$fescomonent->amount,
									"is_debit"=>'N'
								);
								
								$this->commondatamodel->insertSingleTableData('voucher_detail',$arr_C);
							}
							
						}else{
							$del_Where=[
								"voucher_master_id"=>$voucher_master_ids->voucher_id
							];							
							$this->commondatamodel->deleteTableData('voucher_detail',$del_Where);
							$whereS=[
								"student_id"=>$studentid
							];
							$arr_C=array(
								"voucher_master_id"=>$voucher_master_ids->voucher_id,
								"account_master_id"=>$this->feespaymentmodel->getSingleColumnData('account_id','student_master',$whereS),
								"tran_type"=>NULL,
								"voucher_amount"=>$paid_amount,
								"is_debit"=>'N'
							);
							// $where=[
							// 		"id"=>$fescomonent->fees_id
							// 	]; 
								$arr_D=array(
									"voucher_master_id"=>$voucher_master_ids->voucher_id,
									"account_master_id"=>$account_debit,
									"tran_type"=>NULL,
									"voucher_amount"=>$paid_amount,
									"is_debit"=>'Y'
								);
							$table_arr=array("voucher_detail","voucher_detail");
							$ins_data_arr=array($arr_C,$arr_D);
							$this->commondatamodel->insertMultiTableData($table_arr,$ins_data_arr);
							
						}								
						/* update voucher detail end */

						/* update payment voucher ref */
						$data_arr=array(
							"payment_mode" => $payment_mode,
							"paid_amount"=>$amount,
							"cheque_no"=>$cheque_no,
							"cheque_date"=>$cheque_date,
							"bank_name"=>$bank_name,							
							"branch_name"=>$branch_name,
							"narration"=>$narration
						);
						
						$data_arr_where=array(
							"voucher_id"=>$voucher_master_ids->voucher_id,
							"voucher_type"=>"P",
							"payment_id" => $paymentID
						);
						$this->commondatamodel->updateSingleTableData('payment_voucher_ref',$data_arr,$data_arr_where);
						
						/* update payment voucher ref end */
						
					}//end of voucher for



					///////////////////////////////////////////////////////////////////////////////////

					/* start month loop*/
					foreach ($monthids_array as $key => $value) {
						$monthid=$value;
						$fessComponentListData=$this->feespaymentmodel->getFeesComponentListbyClassMonth($classid,$value);
						$fessComsumData=$this->feespaymentmodel->getFeesComponentListSumbyClassMonth($classid,$value);
						$total_amount_monthly=$fessComsumData->sum_amount;

						// pre($fessComponentListData);

						$payment_month_dtl_array = array(
							'payment_master_id' => $payment_master_id, 
							'month_id' => $monthid, 
							'amount' => $total_amount_monthly, 
						    'created_by' => $session['userid']
						);

						$month_dtl_insertId = $this->commondatamodel->insertSingleTableDataRerurnInsertId('payment_month_dtl',$payment_month_dtl_array);

							foreach ($fessComponentListData as $fesscomlistdata) {

								$payment_details_array = array(
										'payment_master_id' => $payment_master_id, 
										'month_id' => $monthid, 
										'payment_month_dtl_id' => $month_dtl_insertId, 
										'fees_component_id' => $fesscomlistdata->fees_comp_id, 
										'amount' => $fesscomlistdata->amount, 
										'created_by' => $session['userid']
										 );

								$user_activity = array(
								"activity_module" => 'Feespayment',
								"action" => 'Insert',
								"from_method" => 'Feespayment/payment_action',
								"user_id" => $session['userid'],
								"ip_address" => getUserIPAddress(),
								"user_browser" => getUserBrowserName(),
								"user_platform" => getUserPlatform()
								
							 );

						$tbl_name = array('payment_details','activity_log');
						$insert_array = array($payment_details_array,$user_activity);
						$insertData = $this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);

							}


						
					} /* end of month loop*/
					
					
					if($update)
					{
						$json_response = array(
							"msg_status" => HTTP_SUCCESS,
							"msg_data" => "Updated successfully",
							"mode" => "EDIT"
						);
					}
					else
					{
						$json_response = array(
							"msg_status" => HTTP_FAIL,
							"msg_data" => "There is some problem while updating ...Please try again."
						);
					}



				} // end if mode
				else
				{
					/*  ADD MODE
					 *	-----------------
					*/
								

					/* insert into payment master */
					$array_payment_master = array(
						"academic_dtl_id" => $academic_dtl_id,
						"class_id" => $classid,
						"school_id" => $session['school_id'],
						"acdm_session_id" => $session['acd_session_id'],
						"accnt_year_id" => $session['accnt_year_id'],
						"student_id" => $studentid,
						"payment_date" => $payment_date,
						"payment_mode" => $payment_mode,
						"total_amount" => $total_pay_amount,

						"paid_amount"=>$paid_amount,
						"cheque_no"=>$cheque_no,
						"bank_name"=>$bank_name,
						"cheque_date"=>$cheque_date,
						"branch_name"=>$branch_name,
						"narration"=>$narration,
						"voucher_master_id"=>NULL,
						"created_by" => $userid
					);
					
					$payment_master_id = $this->commondatamodel->insertSingleTableDataRerurnInsertId('payment_master',$array_payment_master);
					/* insert into payment master end */

					$prefix=array('JV','RC');
					for ($i=0; $i <sizeof($prefix) ; $i++) { 
						if ($prefix[$i]=='JV') 
						{
							$amount=$total_pay_amount;
							$voucher_tag="J";
						}else{
							$amount=$paid_amount;
							$voucher_tag="R";
						}
						
						/* insert into voucher master  */
						$insert_arr=array(
							"voucher_number"=>$this->createVoucherNumber($school_id,$acd_session_id,$prefix[$i]),
							"voucher_date"=> $payment_date,
							"narration"=>$narration,
							"cheque_number"=>$cheque_no,
							"cheque_date"=>$cheque_date,
							"chq_clear_on"=>"",
							"is_chq_clear"=>"",
							"transaction_type"=>$prefix[$i],
							// "transaction_type"=>'COL',
							"created_by"=>$userid,
							"school_id"=>$school_id,
							"acdm_session_id"=>$acd_session_id,
							"accnt_year_id"=>$accnt_year_id,
							"serial_number"=>"0",
							"is_frm_receipt"=>"Y",
							"vouchertype"=>NULL,
							"paid_to"=>NULL,					
							"total_debit"=>$amount,					
							"total_credit"=>$amount					
						);
						$voucher_master_id=$this->commondatamodel->insertSingleTableDataRerurnInsertId("voucher_master",$insert_arr);
						/* insert into voucher master  end */
						
						/* insert into voucher detail */
						if ($prefix[$i]=='JV') 
						{
							$whereS=[
								"student_id"=>$studentid
							];
							$arr_D=array(
								"voucher_master_id"=>$voucher_master_id,
								"account_master_id"=>$this->feespaymentmodel->getSingleColumnData('account_id','student_master',$whereS),
								"tran_type"=>NULL,
								"voucher_amount"=>$total_pay_amount,
								"is_debit"=>'Y'
							);
	
							$this->commondatamodel->insertSingleTableData('voucher_detail',$arr_D);
	
							foreach ($fessComponentData as $fescomonent) {
								$where=[
									"id"=>$fescomonent->fees_id
								]; 
								$arr_C=array(
									"voucher_master_id"=>$voucher_master_id,
									"account_master_id"=>$this->feespaymentmodel->getSingleColumnData('account_id','fees_structure',$where),
									"tran_type"=>NULL,
									"voucher_amount"=>$fescomonent->amount,
									"is_debit"=>'N'
								);
								$this->commondatamodel->insertSingleTableData('voucher_detail',$arr_C);
							}
							
						}else{
							$whereS=[
								"student_id"=>$studentid
							];
							$arr_C=array(
								"voucher_master_id"=>$voucher_master_id,
								"account_master_id"=>$this->feespaymentmodel->getSingleColumnData('account_id','student_master',$whereS),
								"tran_type"=>NULL,
								"voucher_amount"=>$paid_amount,
								"is_debit"=>'N'
							);
							// $where=[
							// 		"id"=>$fescomonent->fees_id
							// 	]; 
								$arr_D=array(
									"voucher_master_id"=>$voucher_master_id,
									"account_master_id"=>$account_debit,
									"tran_type"=>NULL,
									"voucher_amount"=>$paid_amount,
									"is_debit"=>'Y'
								);
							$table_arr=array("voucher_detail","voucher_detail");
							$ins_data_arr=array($arr_C,$arr_D);
							$this->commondatamodel->insertMultiTableData($table_arr,$ins_data_arr);
							
						}								
						/* insert into voucher detail end */

						/* insert into payment voucher ref */
						$data_arr=array(
							"payment_id"=>$payment_master_id,
							"voucher_id"=>$voucher_master_id,
							"voucher_tag"=>$voucher_tag,
							"payment_mode" => $payment_mode,
							"paid_amount"=>$amount,
							"cheque_no"=>$cheque_no,
							"cheque_date"=>$cheque_date,
							"bank_name"=>$bank_name,							
							"branch_name"=>$branch_name,
							"narration"=>$narration,
							"voucher_type"=>'P'
						);
						$this->commondatamodel->insertSingleTableData('payment_voucher_ref',$data_arr);
						/* insert into payment voucher ref end */
						
					}//end of voucher for

					
					/* start month loop*/

					
					// foreach ($monthids_array as $key => $value) {	
						$total_amount_monthly=0;
						$month="";
						$amnt=0;
						$newArr=[];
						$newArr1=[];
	
						for ($j=0; $j <sizeof($monthids_array) ; $j++) {
								for ($i=0; $i <sizeof($fessComponentData) ; $i++) { 
									if ($monthids_array[$j]==$fessComponentData[$i]->month) {
										array_push($newArr,$fessComponentData[$i]);
									}
								}
								
								
									foreach ($newArr as $item) {
										$total_amount_monthly += $item->amount;
									}
							$monthid=$monthids_array[$j];
							
						
						// pre($fessComponentListData);
							$payment_month_dtl_array = array(
								'payment_master_id' => $payment_master_id, 
								'month_id' => $monthid, 
								'amount' => $total_amount_monthly, 
								'created_by' => $session['userid']
							);
	
							$month_dtl_insertId = $this->commondatamodel->insertSingleTableDataRerurnInsertId('payment_month_dtl',$payment_month_dtl_array);
						
	
								foreach ($fessComponentData as $fesscomlistdata) {
									if ($monthid==$fesscomlistdata->month) {
										
									$payment_details_array = array(
											'payment_master_id' => $payment_master_id, 
											'month_id' => $monthid, 
											'payment_month_dtl_id' => $month_dtl_insertId, 
											'fees_component_id' => $fesscomlistdata->fees_id, 
											'amount' => $fesscomlistdata->amount, 
											'created_by' => $session['userid'],
											'fees_session_id'=>"null"
											 );
	
									$user_activity = array(
									"activity_module" => 'caste',
									"action" => 'Insert',
									"from_method" => 'caste/caste_action',
									"user_id" => $session['userid'],
									"ip_address" => getUserIPAddress(),
									"user_browser" => getUserBrowserName(),
									"user_platform" => getUserPlatform()
									
								 );
	
							$tbl_name = array('payment_details','activity_log');
							$insert_array = array($payment_details_array,$user_activity);
							$insertData = $this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);
								// pre($payment_details_array);
								}
							}
	
							$total_amount_monthly=0;
							
						} /* end of month loop*/
					
	
					

					if($insertData)
					{
						$json_response = array(
							"msg_status" => HTTP_SUCCESS,
							"msg_data" => "Saved successfully",
							"mode" => "ADD"
						);
					}
					else
					{
						$json_response = array(
							"msg_status" => HTTP_FAIL,
							"msg_data" => "There is some problem.Try again"
						);
					}

				} // end add mode ELSE PART

			}
			else
			{
				$json_response = array(
						"msg_status" =>0,
						"msg_data" => "All fields are required"
					);
			}

			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
		}
		else
		{
			redirect('login','refresh');
		}
	}


/* payment list details*/



public function getPaymentList()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			$result=[];

			 $from_date = $dataArry['from_date'];
			 $to_date = $dataArry['to_date'];
			 $acdm_class = $dataArry['acdm_class'];
			 if ($acdm_class=='') {
			 	$acdm_class=0;
			 }
			 $acdm_section = $dataArry['acdm_section'];
			 $studentid = $dataArry['studentid'];

			 	 if($from_date!=""){
				$from_date = str_replace('/', '-', $from_date);
				$from_date = date("Y-m-d",strtotime($from_date));
				 }
				 else{
					 $from_date = NULL;
			    }

			    if($to_date!=""){
				$to_date = str_replace('/', '-', $to_date);
				$to_date = date("Y-m-d",strtotime($to_date));
				 }
				 else{
					 $to_date = NULL;
			    }

			    $result['from_date']=$from_date;
			    $result['to_date']=$to_date;
			    $result['acdm_class']=$acdm_class;
			    $result['acdm_section']=$acdm_section;
				$result['studentid']=$studentid;				
			    
			
//exit;
			$page = "dashboard/admin_dashboard/fees_payment/payment_history_partial_view.php";
			$partial_view = $this->load->view($page, $result, TRUE);
			echo $partial_view;
		}
		else
		{
			redirect('login','refresh');
		}
	}


public function updatePaymentMaster(){
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$paymentID = trim($this->input->post('paymentID'));
			$mode = trim($this->input->post('mode'));
			$payment_mode = trim($this->input->post('payment_mode'));
			$payment_date = trim($this->input->post('payment_date'));

			$paid_amount= $this->input->post('paid_amount');
			$cheque_no= $this->input->post('cheque_no');
			$bank_name= $this->input->post('bank_name');
			$cheque_date= $this->input->post('cheque_date');
			$branch_name= $this->input->post('branch_name');
			$narration= $this->input->post('narration');
			$account_debit= $this->input->post('account_debit');

			 if($payment_date!=""){
				$payment_date = str_replace('/', '-', $payment_date);
				$payment_date = date("Y-m-d",strtotime($payment_date));
			 }
			 else{
				 $payment_date = NULL;
		    }
			 if($cheque_date!=""){
				$cheque_date = str_replace('/', '-', $cheque_date);
				$cheque_date = date("Y-m-d",strtotime($cheque_date));
			 }
			 else{
				 $cheque_date = NULL;
			}
			
			$voucher_id=$this->feespaymentmodel->getVoucherIdByPaymentId($paymentID,'R');
			
			$update_array  = array(
				"payment_date" => $payment_date,
				"payment_mode" => $payment_mode,				
				"paid_amount"=>$paid_amount,
				"cheque_no"=>$cheque_no,
				"bank_name"=>$bank_name,
				"cheque_date"=>$cheque_date,
				"branch_name"=>$branch_name,
				"narration"=>$narration
				);
				
			$where = array(
				"payment_id" => $paymentID
				);
			
			
				$user_activity = array(
								"activity_module" => 'Feespayment',
								"action" => 'Update',
								"from_method" => 'Feespayment/updatePaymentMaster',
								"user_id" => $session['userid'],
								"ip_address" => getUserIPAddress(),
								"user_browser" => getUserBrowserName(),
								"user_platform" => getUserPlatform()
								
							 );		
				// pre(array($update_array,$user_activity));exit;		
				$update = $this->commondatamodel->updateData_WithUserActivity('payment_master',$update_array,$where,'activity_log',$user_activity);
				
				
				/****************voucher_master*******************/
				$wherem=[
					"id"=>$voucher_id
				];
				$datam=[
					"total_debit"=>$paid_amount,
					"total_credit"=>$paid_amount
				];
				
				$this->commondatamodel->updateSingleTableData('voucher_master',$datam,$wherem);
				/****************voucher_master*******************/

				/****************voucher_detail*******************/
				
				$where_D_1=[
					"voucher_master_id"=>$voucher_id,
					"is_debit"=>'N'
				];
				$data_D_1=[					
					"voucher_amount"=>$paid_amount
				];	
				$this->commondatamodel->updateSingleTableData('voucher_detail',$data_D_1,$where_D_1);
				$where_D_2=[
					"voucher_master_id"=>$voucher_id,
					"is_debit"=>'Y'
				];
				$data_D_2=[
					"account_master_id"=>$account_debit,				
					"voucher_amount"=>$paid_amount
				];
				// pre(array($where_D_2,$data_D_2));exit;
				$this->commondatamodel->updateSingleTableData('voucher_detail',$data_D_2,$where_D_2);

				/****************voucher_detail*******************/
				
				/****************payment_voucher_ref*******************/
				$data_arr=array(
					"payment_mode" => $payment_mode,
					"paid_amount"=>$paid_amount,
					"cheque_no"=>$cheque_no,
					"cheque_date"=>$cheque_date,
					"bank_name"=>$bank_name,							
					"branch_name"=>$branch_name,
					"narration"=>$narration					
				);

				$where_data_arr=[
					"payment_id"=>$paymentID,
					"voucher_tag"=>'R',
					"voucher_type"=>'P'
				];

				$this->commondatamodel->updateSingleTableData('payment_voucher_ref',$data_arr,$where_data_arr);
				/****************payment_voucher_ref*******************/

			if($update)
			{
				$json_response = array(
					"msg_status" => 1,
					"msg_data" => "Updated Successfully."
				);
			}
			else
			{
				$json_response = array(
					"msg_status" => 0,
					"msg_data" => "Failed to update"
				);
			}


		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

		}else{
			redirect('login','refresh');
		}
	}

	public function feespaymentouchermodal()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$payment_id=$this->input->post('payment_id');		
			$result['VoucherData']=$this->feespaymentmodel->getVoucherDataByPaymentId($payment_id);
			$page = "dashboard/admin_dashboard/fees_payment/voucher_partial_view.php";
			$partial_view = $this->load->view($page, $result, TRUE);
			echo $partial_view;
		}else{
			redirect('login','refresh');
		}
	}

	public function duePaymentAddEdit()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$payment_id=$this->input->post('payment_id');	
			
			$result['PaymentModeList']=$this->commondatamodel->getAllDropdownData('payment_mode_master');
			$result['AccountList']=$this->commondatamodel->getOnlyBankAndCashAccountList($session['school_id']);
			if ($this->uri->segment(3)) {
				$voucher_id=$this->uri->segment(3);
				$payment_id=$this->uri->segment(4);
				$result['payment_id']=$payment_id;
				$result['mode']='EDIT';
				$result['voucher_id']=$voucher_id;
				$result['DebitAccountId']=$this->feespaymentmodel->getDebitAccountIdByVoucherId($voucher_id);
				$result['VoucherPaymentRef']=$this->feespaymentmodel->getVoucherPaymentRefData('voucher_id',$voucher_id);
				
				$title="Edit Receipt Due Fees";
			}else {
				$result['payment_id']=$payment_id;
				$result['mode']='ADD';
				$title="Receipt Due Fees";
			}

			$page = "dashboard/admin_dashboard/fees_payment/due_payment_add_edit_partial_view.php";
			$partial_view = $this->load->view($page, $result, TRUE);
			$json_response = array(
				"status" => 200,
				"title"=>$title,
				"modal" =>$partial_view
			);
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
		}else{
			redirect('login','refresh');
		}
	}

	public function duePaymentAdjustmentAddEdit()
	{
		//	added on 24.05.2019
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$payment_id=$this->input->post('payment_id');	
			
			$result['PaymentModeList']=$this->commondatamodel->getAllDropdownData('payment_mode_master');
			$result['AccountList']=$this->commondatamodel->getListOfAccountWhereAccountsAreNotInBankAndCashGroup($session['school_id']);
			if ($this->uri->segment(3)) {
				$voucher_id=$this->uri->segment(3);
				$payment_id=$this->uri->segment(4);
				$result['payment_id']=$payment_id;
				$result['mode']='EDIT';
				$result['voucher_id']=$voucher_id;
				$result['CreditAccountId']=$this->feespaymentmodel->getDebitAccountIdByVoucherId($voucher_id);
				$result['VoucherPaymentRef']=$this->feespaymentmodel->getVoucherPaymentRefData('voucher_id',$voucher_id);
				
				$title="Edit Due Fees Adjustment";
			}else {
				$result['payment_id']=$payment_id;
				$result['mode']='ADD';
				$title="Due Fees Adjustment";
			}

			$page = "dashboard/admin_dashboard/fees_payment/due_payment_adjustment_partial_view.php";
			$partial_view = $this->load->view($page, $result, TRUE);
			$json_response = array(
				"status" => 200,
				"title"=>$title,
				"modal" =>$partial_view
			);
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
		}else{
			redirect('login','refresh');
		}
	}

	public function checkDuePayment()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$school_id=$session['school_id'];
			$acd_session_id=$session['acd_session_id'];
			$accnt_year_id=$session['accnt_year_id'];

			$payment_id=$this->input->post('payment_id');

			$where=['payment_id'=>$payment_id];
			$paymentData=$this->commondatamodel->getSingleRowByWhereCls('payment_master',$where);
			$dueAmount=$paymentData->total_amount-$paymentData->paid_amount;
			if ($dueAmount>0) {
				
					$paidamnt_C=$this->feespaymentmodel->getSumOfPaidAmount($payment_id);// paymnt from due Receipt  
					$DiscountedAmount=$this->feespaymentmodel->getSumOfDiscountedAmount($payment_id);
					$totalPaidAmnt=$paymentData->paid_amount+$paidamnt_C;
					$totalDueAmnt=($paymentData->total_amount-$totalPaidAmnt)-$DiscountedAmount;					
					$result['totalAmnt']=$paymentData->total_amount;					
					$result['payment_id']=$payment_id;					
					$result['VoucherData']=$this->feespaymentmodel->getDuePaymentDataByPaymentId($payment_id);
					//pre($result['VoucherData']);
					$page = "dashboard/admin_dashboard/fees_payment/due_payment_list_partial_view.php";
					$partial_view = $this->load->view($page, $result, TRUE);
				
				
				if ($totalDueAmnt>0) {
					$text= "( Total Due Amount - ".$totalDueAmnt." )";
				}else {
					$text=" ( No Due Found )";
				}

				$json_response = array(
					"status" => 200,
					"title"=>'Receipt / Adjust Due Fees '.$text,
					"modal" =>$partial_view
				);

			}else {

				$json_response = array(
					"status" => 201,
					"title"=>'Receipt / Adjust Due Fees ',
					"modal" => "No Due Found"
				);
			}
			
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
		}else{
			redirect('login','refresh');
		}
	}


	public function duePayment_action()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$school_id=$session['school_id'];
			$acd_session_id=$session['acd_session_id'];
			$accnt_year_id=$session['accnt_year_id'];
			$userid=$session['userid'];

			 //pre($this->input->post());exit;
			$payment_date=date("Y-m-d",strtotime($this->input->post('payment_date')));
			$paid_amount=$this->input->post('paid_amount');
			$payment_mode=$this->input->post('payment_mode');
			$account_debit=$this->input->post('account_debit');
			$cheque_no=$this->input->post('cheque_no');
			$bank_name=$this->input->post('bank_name');
			
			$branch_name=$this->input->post('branch_name');
			$narration=$this->input->post('narration');
			$payment_id=$this->input->post('payment_id');
			$mode=$this->input->post('mode');

			if ($this->input->post('cheque_date')!="") {
				$cheque_date=date("Y-m-d",strtotime($this->input->post('cheque_date')));
			}else {
				$cheque_date=NULL;
			}

			if ($mode=='ADD') {
					/* insert into voucher master  */
					$insert_arr=array(
						"voucher_number"=>$this->createVoucherNumber($school_id,$acd_session_id,'RC'),
						"voucher_date"=> $payment_date,
						"narration"=>$narration,
						"cheque_number"=>$cheque_no,
						"cheque_date"=>$cheque_date,
						"chq_clear_on"=>"",
						"is_chq_clear"=>"",
						"transaction_type"=>'RC',
						"created_by"=>$userid,
						"school_id"=>$school_id,
						"acdm_session_id"=>$acd_session_id,
						"accnt_year_id"=>$accnt_year_id,
						"serial_number"=>"0",
						"vouchertype"=>NULL,
						"paid_to"=>NULL,					
						"total_debit"=>$paid_amount,					
						"total_credit"=>$paid_amount					
					);
					$voucher_master_id=$this->commondatamodel->insertSingleTableDataRerurnInsertId("voucher_master",$insert_arr);
					// pre($voucher_master_id);exit;
					/* insert into voucher master  end */
					
					
					$arr_C=array(
						"voucher_master_id"=>$voucher_master_id,
						"account_master_id"=>$this->feespaymentmodel->getStudentAccountIdByPaymentId($payment_id),
						"tran_type"=>NULL,
						"voucher_amount"=>$paid_amount,
						"is_debit"=>'N'
					);

					$arr_D=array(
						"voucher_master_id"=>$voucher_master_id,
						"account_master_id"=>$account_debit,
						"tran_type"=>NULL,
						"voucher_amount"=>$paid_amount,
						"is_debit"=>'Y'
					);
					$data_arr=array(
						"payment_id"=>$payment_id,
						"voucher_id"=>$voucher_master_id,
						"voucher_tag"=>'R',
						"payment_mode" => $payment_mode,
						"paid_amount"=>$paid_amount,
						"cheque_no"=>$cheque_no,
						"cheque_date"=>$cheque_date,
						"bank_name"=>$bank_name,							
						"branch_name"=>$branch_name,
						"narration"=>$narration,
						"voucher_type"=>'C'
					);
				$table_arr=array("voucher_detail","voucher_detail","payment_voucher_ref");
				$ins_data_arr=array($arr_D,$arr_C,$data_arr);
				$this->commondatamodel->insertMultiTableData($table_arr,$ins_data_arr);
				$user_activity = array(
					"activity_module" => 'feespayment',
					"action" => 'Insert',
					"from_method" => 'feespayment/duePayment_action',
					"user_id" => $session['userid'],
					"ip_address" => getUserIPAddress(),
					"user_browser" => getUserBrowserName(),
					"user_platform" => getUserPlatform()
					
				 );
				
				$insert=$this->commondatamodel->insertSingleTableData('activity_log',$user_activity);
				if ($insert) {
					$json_response = array(
						"status" => 200,
						"message"=>"Saved Successfully",
						
					);
				}else {
					$json_response = array(
						"status" => 201,
						"message"=>'having difficulty in saving',
					);
				}
				
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
				
			}else {
				/******Edit mode******/
				$voucher_id=$this->input->post('voucher_id');				

				/* update voucher master  */
				$update_arr=array(							
					"voucher_date"=> $payment_date,
					"narration"=>$narration,
					"cheque_number"=>$cheque_no,
					"cheque_date"=>$cheque_date,
					"chq_clear_on"=>"",
					"is_chq_clear"=>"",
					"transaction_type"=>'RC',
					// "transaction_type"=>$prefix[$i],
					"created_by"=>$userid,
					"school_id"=>$school_id,
					"acdm_session_id"=>$acd_session_id,
					"accnt_year_id"=>$accnt_year_id,
					"serial_number"=>"0",
					"vouchertype"=>NULL,
					"paid_to"=>NULL,					
					"total_debit"=>$paid_amount,					
					"total_credit"=>$paid_amount					
				);
				$where_voucher_master_id=[
					"id"=>$voucher_id,					
				];						
				$this->commondatamodel->updateSingleTableData('voucher_master',$update_arr,$where_voucher_master_id);
				/* update voucher master  end */
				
				$del_Where=[
					"voucher_master_id"=>$voucher_id
				];							
				$this->commondatamodel->deleteTableData('voucher_detail',$del_Where);
				
				$data_arr=array(			
					
					"payment_mode" => $payment_mode,
					"paid_amount"=>$paid_amount,
					"cheque_no"=>$cheque_no,
					"cheque_date"=>$cheque_date,
					"bank_name"=>$bank_name,							
					"branch_name"=>$branch_name,
					"narration"=>$narration,
					
				);
				$data_arr_update=array('voucher_id'=>$voucher_id);
				$this->commondatamodel->updateSingleTableData('payment_voucher_ref',$data_arr,$data_arr_update);

				$user_activity = array(
								"activity_module" => 'feespayment',
								"action" => 'Update',
								"from_method" => 'feespayment/duePayment_action',
								"user_id" => $session['userid'],
								"ip_address" => getUserIPAddress(),
								"user_browser" => getUserBrowserName(),
								"user_platform" => getUserPlatform()
								
							);
				
				$arr_C=array(
					"voucher_master_id"=>$voucher_id,
					"account_master_id"=>$this->feespaymentmodel->getStudentAccountIdByPaymentId($payment_id),
					"tran_type"=>NULL,
					"voucher_amount"=>$paid_amount,
					"is_debit"=>'N'
				);

				$arr_D=array(
					"voucher_master_id"=>$voucher_id,
					"account_master_id"=>$account_debit,
					"tran_type"=>NULL,
					"voucher_amount"=>$paid_amount,
					"is_debit"=>'Y'
				);
				$tbl_name = array('voucher_detail','voucher_detail','activity_log');
				$insert_array = array($arr_C,$arr_D,$user_activity);
				$insert = $this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);
				if ($insert) {
					$json_response = array(
						"status" => 200,
						"message"=>"Update Successfully",
						
					);
				}else {
					$json_response = array(
						"status" => 201,
						"message"=>'having difficulty While Updating',
					);
				}
				
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;

			}

		}else{
			redirect('login','refresh');
		}
	}

	public function dueAdjustmentPayment_action()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$school_id=$session['school_id'];
			$acd_session_id=$session['acd_session_id'];
			$accnt_year_id=$session['accnt_year_id'];
			$userid=$session['userid'];

			 //pre($this->input->post());exit;
			$payment_date=date("Y-m-d",strtotime($this->input->post('payment_date')));
			$paid_amount=$this->input->post('paid_amount');
			$payment_mode=$this->input->post('payment_mode');
			$account_debit=$this->input->post('account_debit');
			$cheque_no=$this->input->post('cheque_no');
			$bank_name=$this->input->post('bank_name');
			
			$branch_name=$this->input->post('branch_name');
			$narration=$this->input->post('narration');
			$payment_id=$this->input->post('payment_id');
			$mode=$this->input->post('mode');

			if ($this->input->post('cheque_date')!="") {
				$cheque_date=date("Y-m-d",strtotime($this->input->post('cheque_date')));
			}else {
				$cheque_date=NULL;
			}

			if ($mode=='ADD') {
					/* insert into voucher master  */
					$insert_arr=array(
						"voucher_number"=>$this->createVoucherNumber($school_id,$acd_session_id,'JV'),
						"voucher_date"=> $payment_date,
						"narration"=>$narration,
						"cheque_number"=>$cheque_no,
						"cheque_date"=>$cheque_date,
						"chq_clear_on"=>"",
						"is_chq_clear"=>"",
						"transaction_type"=>'JV',
						"created_by"=>$userid,
						"school_id"=>$school_id,
						"acdm_session_id"=>$acd_session_id,
						"accnt_year_id"=>$accnt_year_id,
						"serial_number"=>"0",
						"vouchertype"=>NULL,
						"paid_to"=>NULL,					
						"total_debit"=>$paid_amount,					
						"total_credit"=>$paid_amount					
					);
					$voucher_master_id=$this->commondatamodel->insertSingleTableDataRerurnInsertId("voucher_master",$insert_arr);
					// pre($voucher_master_id);exit;
					/* insert into voucher master  end */
					
					
					$arr_C=array(
						"voucher_master_id"=>$voucher_master_id,
						"account_master_id"=>$this->feespaymentmodel->getStudentAccountIdByPaymentId($payment_id),
						"tran_type"=>NULL,
						"voucher_amount"=>$paid_amount,
						"is_debit"=>'N'
					);

					$arr_D=array(
						"voucher_master_id"=>$voucher_master_id,
						"account_master_id"=>$account_debit,
						"tran_type"=>NULL,
						"voucher_amount"=>$paid_amount,
						"is_debit"=>'Y'
					);
					$data_arr=array(
						"payment_id"=>$payment_id,
						"voucher_id"=>$voucher_master_id,
						"voucher_tag"=>'J',
						"payment_mode" => $payment_mode,
						"paid_amount"=>$paid_amount,
						"cheque_no"=>$cheque_no,
						"cheque_date"=>$cheque_date,
						"bank_name"=>$bank_name,							
						"branch_name"=>$branch_name,
						"narration"=>$narration,
						"voucher_type"=>'C'
					);
				$table_arr=array("voucher_detail","voucher_detail","payment_voucher_ref");
				$ins_data_arr=array($arr_D,$arr_C,$data_arr);
				$this->commondatamodel->insertMultiTableData($table_arr,$ins_data_arr);
				$user_activity = array(
					"activity_module" => 'feespayment',
					"action" => 'Insert',
					"from_method" => 'feespayment/dueAdjustmentPayment_action',
					"user_id" => $session['userid'],
					"ip_address" => getUserIPAddress(),
					"user_browser" => getUserBrowserName(),
					"user_platform" => getUserPlatform()
					
				 );
				
				$insert=$this->commondatamodel->insertSingleTableData('activity_log',$user_activity);
				if ($insert) {
					$json_response = array(
						"status" => 200,
						"message"=>"Saved Successfully",
						
					);
				}else {
					$json_response = array(
						"status" => 201,
						"message"=>'having difficulty in saving',
					);
				}
				
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
				
			}else {
				/******Edit mode******/
				$voucher_id=$this->input->post('voucher_id');				

				/* update voucher master  */
				$update_arr=array(							
					"voucher_date"=> $payment_date,
					"narration"=>$narration,
					"cheque_number"=>$cheque_no,
					"cheque_date"=>$cheque_date,
					"chq_clear_on"=>"",
					"is_chq_clear"=>"",
					"transaction_type"=>'JV',
					// "transaction_type"=>$prefix[$i],
					"created_by"=>$userid,
					"school_id"=>$school_id,
					"acdm_session_id"=>$acd_session_id,
					"accnt_year_id"=>$accnt_year_id,
					"serial_number"=>"0",
					"vouchertype"=>NULL,
					"paid_to"=>NULL,					
					"total_debit"=>$paid_amount,					
					"total_credit"=>$paid_amount					
				);
				$where_voucher_master_id=[
					"id"=>$voucher_id,					
				];						
				$this->commondatamodel->updateSingleTableData('voucher_master',$update_arr,$where_voucher_master_id);
				/* update voucher master  end */
				
				$del_Where=[
					"voucher_master_id"=>$voucher_id
				];							
				$this->commondatamodel->deleteTableData('voucher_detail',$del_Where);
				
				$data_arr=array(			
					
					"payment_mode" => $payment_mode,
					"paid_amount"=>$paid_amount,
					"cheque_no"=>$cheque_no,
					"cheque_date"=>$cheque_date,
					"bank_name"=>$bank_name,							
					"branch_name"=>$branch_name,
					"narration"=>$narration,
					
				);
				$data_arr_update=array('voucher_id'=>$voucher_id);
				$this->commondatamodel->updateSingleTableData('payment_voucher_ref',$data_arr,$data_arr_update);

				$user_activity = array(
								"activity_module" => 'feespayment',
								"action" => 'Update',
								"from_method" => 'feespayment/dueAdjustmentPayment_action',
								"user_id" => $session['userid'],
								"ip_address" => getUserIPAddress(),
								"user_browser" => getUserBrowserName(),
								"user_platform" => getUserPlatform()
								
							);
				
				$arr_C=array(
					"voucher_master_id"=>$voucher_id,
					"account_master_id"=>$this->feespaymentmodel->getStudentAccountIdByPaymentId($payment_id),
					"tran_type"=>NULL,
					"voucher_amount"=>$paid_amount,
					"is_debit"=>'N'
				);

				$arr_D=array(
					"voucher_master_id"=>$voucher_id,
					"account_master_id"=>$account_debit,
					"tran_type"=>NULL,
					"voucher_amount"=>$paid_amount,
					"is_debit"=>'Y'
				);
				$tbl_name = array('voucher_detail','voucher_detail','activity_log');
				$insert_array = array($arr_C,$arr_D,$user_activity);
				$insert = $this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);
				if ($insert) {
					$json_response = array(
						"status" => 200,
						"message"=>"Update Successfully",
						
					);
				}else {
					$json_response = array(
						"status" => 201,
						"message"=>'having difficulty While Updating',
					);
				}
				
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;

			}

		}else{
			redirect('login','refresh');
		}
	}

public function deleteFeesPayment()
{
	$session = $this->session->userdata('user_data');
	if($this->session->userdata('user_data'))
	{
		$payment_id=$this->input->post('payment_id');

		$voucherList=$this->commondatamodel->getAllRecordWhere('payment_voucher_ref',array('payment_id'=>$payment_id));	

		//Delete from payment_month_dtl
		$this->commondatamodel->deleteTableData('payment_month_dtl',array('payment_master_id'=>$payment_id));

		//Delete from payment_details
		$this->commondatamodel->deleteTableData('payment_details',array('payment_master_id'=>$payment_id));

		// //Delete from payment_master
		$this->commondatamodel->deleteTableData('payment_master',array('payment_id'=>$payment_id));

		//Delete from payment_Voucher_ref
		$this->commondatamodel->deleteTableData('payment_voucher_ref',array('payment_id'=>$payment_id));

		//Delete Voucher data
		foreach ($voucherList as $value) {
			$voucher_id=$value->voucher_id;

			//Delete from voucher_detail
			$this->commondatamodel->deleteTableData('voucher_detail',array('voucher_master_id'=>$voucher_id));

			//Delete from voucher_master
			$this->commondatamodel->deleteTableData('voucher_master',array('id'=>$voucher_id));
		}

		$user_activity = array(
			"activity_module" => 'feespayment',
			"action" => 'Delete',
			"from_method" => 'feespayment/deleteFeesPayment',
			"user_id" => $session['userid'],
			"ip_address" => getUserIPAddress(),
			"user_browser" => getUserBrowserName(),
			"user_platform" => getUserPlatform()
			
		);
		$insert=$this->commondatamodel->insertSingleTableData('activity_log',$user_activity);
		if ($insert) {
			$json_response = array(
				"status" => 200,
				"message"=>"Delete Successfully",
			);
		}else {
			$json_response = array(
				"status" => 201,
				"message"=>'having difficulty in Delete',
				);
		}

		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;

	}else{
		redirect('login','refresh');
	}
}

public function deleteDuePaymentVoucher()
{
	$session = $this->session->userdata('user_data');
	if($this->session->userdata('user_data'))
	{
		$voucher_id=$this->input->post('voucher_id');

		//Delete from voucher_detail
		$this->commondatamodel->deleteTableData('voucher_detail',array('voucher_master_id'=>$voucher_id));

		//Delete from payment_Voucher_ref
		$this->commondatamodel->deleteTableData('payment_voucher_ref',array('voucher_id'=>$voucher_id));

		//Delete from voucher_master
		$this->commondatamodel->deleteTableData('voucher_master',array('id'=>$voucher_id));

		$user_activity = array(
			"activity_module" => 'feespayment',
			"action" => 'Delete',
			"from_method" => 'feespayment/deleteDuePaymentVoucher',
			"user_id" => $session['userid'],
			"ip_address" => getUserIPAddress(),
			"user_browser" => getUserBrowserName(),
			"user_platform" => getUserPlatform()
			
		);
		$insert=$this->commondatamodel->insertSingleTableData('activity_log',$user_activity);
		if ($insert) {
			$json_response = array(
				"status" => 200,
				"message"=>"Delete Successfully",
			);
		}else {
			$json_response = array(
				"status" => 201,
				"message"=>'having difficulty in Delete',
				);
		}

		header('Content-Type: application/json');
		echo json_encode( $json_response );
		exit;
}else{
		redirect('login','refresh');
	}
}

public function payment_DueReport()
{
	// added on 18.05.2019 
	$session = $this->session->userdata('user_data');
	if($this->session->userdata('user_data'))
	{
		$this->load->library('Pdf');
        $pdf = $this->pdf->load();
		ini_set('memory_limit', '256M'); 
			
		//pre($this->uri->segment(3));
		$from_date=date('Y-m-d',strtotime($this->uri->segment(3)));
		$to_date=date('Y-m-d',strtotime($this->uri->segment(4)));
		$acdm_class=$this->uri->segment(5);
		$acdm_section=$this->uri->segment(6);
		$studentid=$this->uri->segment(7);
		$DueOnly=$this->uri->segment(8);
		
		$paymentDueReport=$this->feespaymentmodel->paymentDueReport($from_date,$to_date,$acdm_class,$acdm_section,$studentid,$DueOnly,$session['school_id'],$session['acd_session_id']);

		$this->freeDBResource($this->db->conn_id);


		$ReportArr = array();
		$ReportArr1 = array();
		foreach ($paymentDueReport as $key => $item) {			
			$ReportArr[$item->studentname.",".$item->student_id]=[
				"studentname"=>$item->studentname,
				"classname"=>$item->classname,
				"section"=>$item->section,
				"roll"=>$item->roll	,
				"PaymentDetails"=>array()				
			];
			$ReportArr1[$item->student_id."-PaymentDetails"][]=[
				"payment_date"=>$item->payment_date,
				"amount"=>$item->amount,
				"account_head"=>$item->account_head,
				"paid"=>$item->paid,
				"AdjustmentAmnt"=>$item->AdjustmentAmnt,
				"due"=>$item->due
			];
			array_push($ReportArr[$item->studentname.",".$item->student_id]['PaymentDetails'],$ReportArr1[$item->student_id."-PaymentDetails"]);
		}
		ksort($ReportArr, SORT_STRING );

		$result['company']=  $this->commondatamodel->getCompanyNameById($session['school_id']);
        $result['companylocation']=  $this->commondatamodel->getCompanyAddressById($session['school_id']);
		$result['ReportArr']=$ReportArr;
		$result['fromDate']=$this->uri->segment(3);
		$result['toDate']=$this->uri->segment(4);
		$result['DueOnly']=$DueOnly;
		$result['classname']=$this->commondatamodel->getNameById(array('id'=>$acdm_class),'classname','class_master');
		$result['section']=$this->commondatamodel->getNameById(array('id'=>$acdm_section),'section','section_master');
		$result['StudentName']=$this->commondatamodel->getNameById(array('student_id'=>$studentid),'name','student_master');
		//pre($ReportArr);exit;
	
		$page = 'dashboard/admin_dashboard/fees_payment/paymentDueReportPdf';
		$html = $this->load->view($page, $result, TRUE);
				// render the view into HTML
				//$html="Hello";
		$pdf->WriteHTML($html); 
		if($DueOnly!=0){
			$output = 'DueRegister' . date('Y_m_d_H_i_s') . '_.pdf'; 
		}else{
			$output = 'ReceiptRegister' . date('Y_m_d_H_i_s') . '_.pdf'; 
		}
		
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








}//end of class
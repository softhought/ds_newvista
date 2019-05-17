<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feescomponent extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('feescomponentmodel','feescommodel',TRUE);
	}


	public function index()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
            $header = "";
            
			//$result['feescomponentList'] = $this->feescommodel->getAllFeescomponentList($session['school_id']);
			$result['feescomponentList'] = $this->feescommodel->getAllFeescomponentListWithMonth($session['school_id']);

			$page = "dashboard/admin_dashboard/fees_component/fees_component_list_view.php";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
    }


    public function addFeesComponent()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			//echo "seg:".$this->uri->segment(3);exit;
			if (empty($this->uri->segment(3)))
			{
				$result['mode'] = "ADD";
				$result['btnText'] = "Save";
				$result['btnTextLoader'] = "Saving...";
				$feesComID = 0;
				$result['feesComponentEditdata'] = [];
				$result['feesComponentEditMonthdata'] = [];
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
				$feesComID = $this->uri->segment(3);
				$whereAry = array(
					'fees_structure.id' => $feesComID
				);
				// getSingleRowByWhereCls(tablename,where params)
				$result['feesComponentEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('fees_structure',$whereAry); 
				$where_fees_strucrure_month = array('fees_strucrure_month_dtl.fees_structure_id' =>$feesComID);
				$result['feesComponentEditMonthdata']= $this->commondatamodel->getAllRecordWhere('fees_strucrure_month_dtl',$where_fees_strucrure_month);

				
				
			}
			$where_ac_master = array('account_master.school_id' => $session['school_id']);
			$result['accountList']=$this->commondatamodel->getAllRecordWhere('account_master',$where_ac_master);
			$header = "";
			$result['monthList']=$this->commondatamodel->getAllDropdownData('month_master'); 
			$page = "dashboard/admin_dashboard/fees_component/fees_component_add_edit_view.php";
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
		}
	}
	
	
	public function feesComponent_action()
	{
		
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			
			
			
			$feesComID = trim(htmlspecialchars($dataArry['feesComID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));
		
			$fees_desc = trim(htmlspecialchars($dataArry['fees_desc']));
			$acconut = trim(htmlspecialchars($dataArry['acconut']));
			$sel_month = $dataArry['sel_month'];

			if (isset($dataArry['is_yearly_once'])) {
				$is_yearly_once='Y';
			} else {
				$is_yearly_once='N';
			}
			
			if (isset($dataArry['is_once_in_life_time'])) {
				$is_once_in_life_time='Y';
			} else {
				$is_once_in_life_time='N';
			}
			



			/*pre($sel_month);
			exit;*/
			if ($acconut=='') {
				$acconut=NULL;
			}

			if($fees_desc!="")
			{
	
				
				
				if($feesComID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					$array_upd = array(
						"fees_desc" => $fees_desc,
						"account_id" => $acconut,
						"school_id" => $session['school_id'],
						"last_modified" => date('y-m-d'),
						"is_yearly_once" =>$is_yearly_once,
						"is_once_in_life_time" =>$is_once_in_life_time
					);

					$where_upd = array(
						"fees_structure.id" => $feesComID
					);

					$user_activity = array(
						"activity_module" => 'feescomponent',
						"action" => 'Update',
						"from_method" => 'feescomponent/feesComponent_action',
						"user_id" => $session['userid'],
						"ip_address" => getUserIPAddress(),
						"user_browser" => getUserBrowserName(),
						"user_platform" => getUserPlatform()
					 );


					/*
					@updateData_WithUserActivity('update table name','update table data','update table where condition','user activity table name','user activity table data');
					*/
					$update = $this->commondatamodel->updateData_WithUserActivity('fees_structure',$array_upd,$where_upd,'activity_log',$user_activity);

					$delete=$this->feescommodel->deleteFeesMonthDetails($feesComID);
					

							foreach ($sel_month as $key => $value) {		
							$array_fee_month_dtl = array(
									"fees_structure_id" => $feesComID,
									"month_id" => $value,
									
								);
								
								
									$user_activity = array(
									"activity_module" => 'feescomponent',
									"action" => 'Insert',
									"from_method" => 'feescomponent/feesComponent_action',
									"user_id" => $session['userid'],
									"ip_address" => getUserIPAddress(),
									"user_browser" => getUserBrowserName(),
									"user_platform" => getUserPlatform()
									
								 );

									
								$tbl_name = array('fees_strucrure_month_dtl','activity_log');
								$insert_array = array($array_fee_month_dtl,$user_activity);
								$insertData = $this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);

			    	} //end of foreach
						


					
					
					
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


					$array_insert = array(
						"fees_desc" => $fees_desc,
						"account_id" => $acconut,
						"school_id" => $session['school_id'],
						"created_by" => $session['userid'],
						"is_yearly_once" =>$is_yearly_once,
						"is_once_in_life_time" =>$is_once_in_life_time
					);
					
					$insertId=$this->commondatamodel->insertSingleTableDataRerurnInsertId('fees_structure',$array_insert);
	
				

						
					/*$tbl_name = array('fees_structure','activity_log');
					$insert_array = array($array_insert,$user_activity);
					$insertData = $this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);*/

						foreach ($sel_month as $key => $value) {		
							$array_fee_month_dtl = array(
									"fees_structure_id" => $insertId,
									"month_id" => $value,
									
								);
								
								
									$user_activity = array(
									"activity_module" => 'feescomponent',
									"action" => 'Insert',
									"from_method" => 'feescomponent/feesComponent_action',
									"user_id" => $session['userid'],
									"ip_address" => getUserIPAddress(),
									"user_browser" => getUserBrowserName(),
									"user_platform" => getUserPlatform()
									
								 );

									
								$tbl_name = array('fees_strucrure_month_dtl','activity_log');
								$insert_array = array($array_fee_month_dtl,$user_activity);
								$insertData = $this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);

			    	} //end of foreach

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

	public function deleteFeesComponent()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$id=$this->input->post('fees_id');
			$check=$this->feescommodel->checkIfTheComponentHaveAnyEntry($session['school_id'],$id);

			if ($check) 
			{				
				$json_response = array(
					"msg_status" => HTTP_SUCCESS,
					"msg_data" => "Deleted successfully",
				);
			}else{
				$json_response = array(
					"msg_status" => HTTP_FAIL,
					"msg_data" => "Can't delete! Have Entry in Fees Structure "
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
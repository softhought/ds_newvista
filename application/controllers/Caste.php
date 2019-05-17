<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Caste extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('castemodel','castemodel',TRUE);
	}


	public function index()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$header = "";
			$result['btnText'] = "Save";
			$result['btnTextLoader'] = "Saving...";
			$result['casteList'] = $this->castemodel->getAllCasteList(); 
			$page = "dashboard/admin_dashboard/caste/caste_list_view";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
	}


	public function addcaste()
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
				$casteID = 0;
				$result['casteEditdata'] = [];
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
				$casteID = $this->uri->segment(3);
				$whereAry = array(
					'caste_master.id' => $casteID
				);
				// getSingleRowByWhereCls(tablename,where params)
				$result['casteEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('caste_master',$whereAry); 
				
				
			}
			
			$header = "";

			$page = "dashboard/admin_dashboard/caste/caste_add_edit_view";
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
		}
	}


	public function caste_action()
	{
		
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			
			
			
			$casteID = trim(htmlspecialchars($dataArry['casteID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));
		
			$caste = trim(htmlspecialchars($dataArry['caste']));


			if($caste!="")
			{
	
				
				
				if($casteID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					$array_upd = array(
						"caste" => $caste,
						"last_modified" => date('Y-m-d')
					);

					$where_upd = array(
						"caste_master.id" => $casteID
					);

					$user_activity = array(
						"activity_module" => 'caste',
						"action" => 'Update',
						"from_method" => 'caste/caste_action',
						"user_id" => $session['userid'],
						"ip_address" => getUserIPAddress(),
						"user_browser" => getUserBrowserName(),
						"user_platform" => getUserPlatform()
					 );


					/*
					@updateData_WithUserActivity('update table name','update table data','update table where condition','user activity table name','user activity table data');
					*/
					$update = $this->commondatamodel->updateData_WithUserActivity('caste_master',$array_upd,$where_upd,'activity_log',$user_activity);
					
					
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
						"caste" => $caste,
						"is_active" => 1,
						"created_by" => $session['userid']
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

						
					$tbl_name = array('caste_master','activity_log');
					$insert_array = array($array_insert,$user_activity);
					$insertData = $this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);

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



	



}  // end of class
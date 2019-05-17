<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Relationship extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('relationshipmodel','relationshipmodel',TRUE);
	}


	public function index()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$header = "";
			$result['relationshipList'] = $this->relationshipmodel->getAllRelationList(); 
			$page = "dashboard/admin_dashboard/relationship/relationship_list_view";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
	}


	public function addrelation()
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
				$relationID = 0;
				$result['relationEditdata'] = [];
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
				$relationID = $this->uri->segment(3);
				$whereAry = array(
					'relationship_master.id' => $relationID
				);
				// getSingleRowByWhereCls(tablename,where params)
				$result['relationEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('relationship_master',$whereAry); 
				
				
			}
			
			$header = "";

			$page = "dashboard/admin_dashboard/relationship/relationship_add_edit_view";
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
		}
	}


	public function relation_action()
	{
		
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			
			
			
			$relationID = trim(htmlspecialchars($dataArry['relationID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));
		
			$relation = trim(htmlspecialchars($dataArry['relation']));


			if($relation!="")
			{
	
				
				
				if($relationID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					$array_upd = array(
						"relation" => $relation,
						"last_modified" => date('Y-m-d')
					);

					$where_upd = array(
						"relationship_master.id" => $relationID
					);

					$user_activity = array(
						"activity_module" => 'Relationship',
						"action" => 'Update',
						"from_method" => 'Relationship/relation_action',
						"user_id" => $session['userid'],
						"ip_address" => getUserIPAddress(),
						"user_browser" => getUserBrowserName(),
						"user_platform" => getUserPlatform()
					 );


					/*
					@updateData_WithUserActivity('update table name','update table data','update table where condition','user activity table name','user activity table data');
					*/
					$update = $this->commondatamodel->updateData_WithUserActivity('relationship_master',$array_upd,$where_upd,'activity_log',$user_activity);
					
					
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
						"relation" => $relation,
						"is_active" => 1,
						"created_by" => $session['userid']
					);
					
					
	
					$user_activity = array(
						"activity_module" => 'Relationship',
						"action" => 'Insert',
						"from_method" => 'Relationship/relation_action',
						"user_id" => $session['userid'],
						"ip_address" => getUserIPAddress(),
						"user_browser" => getUserBrowserName(),
						"user_platform" => getUserPlatform()
						
					 );

						
					$tbl_name = array('relationship_master','activity_log');
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
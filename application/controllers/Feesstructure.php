<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feesstructure extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('Feesstructuremodel','feesstrmodel',TRUE);
		$this->load->model('commondatamodel','commondatamodel',TRUE);
	}


	public function index()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
            $header = "";
            
			$result['feesstructureList'] = $this->feesstrmodel->getAllFeesstructureList($session['school_id'],$session['acd_session_id']); 
			$page = "dashboard/admin_dashboard/fees_structure/fees_structure_list_view.php";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
    }


    public function addFeesStructure()
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
				$feesStrID = 0;
				$result['feesStructureEditdata'] = [];
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
				$feesStrID = $this->uri->segment(3);
				$whereAry = array(
					'fees_session.id' => $feesStrID
				);
				// getSingleRowByWhereCls(tablename,where params)
				$result['feesStructureEditdata'] = $this->commondatamodel->getSingleRowByWhereCls('fees_session',$whereAry); 
				
			
			}
			
			$header = "";

			$result['classList'] = $this->commondatamodel->getAllDropdownData('class_master'); 
			$where_fest = array('fees_structure.school_id' =>$session['school_id'] );
			$result['feesList'] = $this->commondatamodel->getAllRecordWhere('fees_structure',$where_fest); 
			$page = "dashboard/admin_dashboard/fees_structure/fees_structure_add_edit_view.php";
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
		}
	}
	
	
	public function feesStructure_action()
	{
		
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$json_response = array();
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			
			
			
			$feesStrID = trim(htmlspecialchars($dataArry['feesStrID']));
			$mode = trim(htmlspecialchars($dataArry['mode']));
		
			$classid = trim(htmlspecialchars($dataArry['classid']));
			$feesid = trim(htmlspecialchars($dataArry['feesid']));
			$amount = trim(htmlspecialchars($dataArry['amount']));
			

			if($amount!="")
			{
	
				
				
				if($feesStrID>0 && $mode=="EDIT")
				{
					/*  EDIT MODE
					 *	-----------------
					*/

					$array_upd = array(
						"fees_id" => $feesid,
						"class_id" => $classid,
						"amount" => $amount,
						"school_id" => $session['school_id'],
						"acdm_session_id" => $session['acd_session_id'],
						"accnt_year_id" => $session['accnt_year_id'],
						"last_modified" => date('y-m-d')
					);

					$where_upd = array(
						"fees_session.id" => $feesStrID
					);

					$user_activity = array(
						"activity_module" => 'feesstructure',
						"action" => 'Update',
						"from_method" => 'feesstructure/feesStructure_action',
						"user_id" => $session['userid'],
						"ip_address" => getUserIPAddress(),
						"user_browser" => getUserBrowserName(),
						"user_platform" => getUserPlatform()
					 );


					/*
					@updateData_WithUserActivity('update table name','update table data','update table where condition','user activity table name','user activity table data');
					*/
					$update = $this->commondatamodel->updateData_WithUserActivity('fees_session',$array_upd,$where_upd,'activity_log',$user_activity);
					
					
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
						"fees_id" => $feesid,
						"class_id" => $classid,
						"amount" => $amount,
						"school_id" => $session['school_id'],
						"acdm_session_id" => $session['acd_session_id'],
						"accnt_year_id" => $session['accnt_year_id'],
						"created_by" => $session['userid']
					);
					
					
	
					$user_activity = array(
						"activity_module" => 'feesstructure',
						"action" => 'Insert',
						"from_method" => 'feesstructure/feesStructure_action',
						"user_id" => $session['userid'],
						"ip_address" => getUserIPAddress(),
						"user_browser" => getUserBrowserName(),
						"user_platform" => getUserPlatform()
						
					 );

						
					$tbl_name = array('fees_session','activity_log');
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



	/* get present district by state*/
public function getFeesList()
{
	$session = $this->session->userdata('user_data');
	if($this->session->userdata('user_data'))
	{   $feesid=[];
		$classid = trim($this->input->post('classid'));
		$where = array(
								'fees_session.class_id' =>$classid,
								'fees_session.acdm_session_id' =>$session['acd_session_id'],
								'fees_session.accnt_year_id' =>$session['accnt_year_id'],
								'fees_session.school_id' =>$session['school_id']
							 );
	
		  
	
		   $result['feesList']=$this->feesstrmodel->getfeesList($session['school_id'],$classid,$session['acd_session_id']);
		   //pre($result['feesList']);




		$page = "dashboard/admin_dashboard/fees_structure/fees_view.php";
		//$partial_view = $this->load->view($page,$result);
		echo $this->load->view($page, $result, TRUE);
		//echo $partial_view;
	}
	else
	{
		redirect('login','refresh');
	}
}

public function deleteFeesStructure()
{
	$session = $this->session->userdata('user_data');
	if($this->session->userdata('user_data'))
	{
		$id=$this->input->post('fees_id');		
		$check=$this->feesstrmodel->checkIfThefeesStructureHaveAnyEntry($session['school_id'],$session['acd_session_id'],$id);
		if ($check) 
		{
			$where=[
				"id"=>$id
			];
			$this->commondatamodel->deleteTableData('fees_session',$where);
			$json_response = array(
				"msg_status" => HTTP_SUCCESS,
				"msg_data" => "Deleted successfully",
			);
		}else{
			$json_response = array(
				"msg_status" => HTTP_FAIL,
				"msg_data" => "Can't delete! Already Done Payment Against this  "
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
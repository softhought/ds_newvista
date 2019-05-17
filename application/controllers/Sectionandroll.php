<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sectionandroll extends CI_Controller 
{
	public function __construct()
	{
	     parent::__construct();
		$this->load->library('session');
		$this->load->model('classmodel','classmodel',TRUE);
		$this->load->model('sectionandrollmodel','sectionandrollmodel');
		$this->load->model('commondatamodel','commondatamodel');
    }
    
    public function index()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
		  //  print_r("index");exit;
			$header = "";
			$result['module']="Section & Roll Assignment";
			$result['classList'] = $this->classmodel->getAllClassList(); 
			$page = "dashboard/admin_dashboard/student/section_and_roll_assignment/view_students.php";
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
	}


	public function sectionRollAssignmentStudentList()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$acd_session_id=$session['acd_session_id'];
            // $school_id=$session['school_id'];
			$userid=$session['userid'];			     
			$formData = $this->input->post('formDatas');			
			parse_str($formData, $dataArry);		

			$table="section_master";
			$where=[
				"is_active"=>"1",
				"created_by"=>$userid
			];
			$result['studentList']=$this->sectionandrollmodel->getStudentListByClass($dataArry['classList'],$acd_session_id,$userid);
			$result['sectionList']=$this->commondatamodel->getAllRecordWhere($table,$where);
			// print_r($result['sectionList']);

			$header = "";
			$page = "dashboard/admin_dashboard/student/section_and_roll_assignment/section_roll_assignment_list";			
			$partial_view = $this->load->view($page, $result, TRUE);
			echo $partial_view;

		}else{
			redirect('login','refresh');
		}
	}

	public function updateRollSection()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			// print_r($this->input->post());exit;
			$section_id= $this->input->post('section_id');
			$rollno= $this->input->post('rollno');
			$student_id= $this->input->post('student_id');
			$class_id= $this->input->post('class_id');
			$school_id= $this->input->post('school_id');
			$acdm_session_id= $this->input->post('acdm_session_id');
			$upd_tbl_name="academic_details";
			$user_actvty_tbl="activity_log";
			$upd_data=[
				"section_id"=>$section_id,
				"rollno"=>$rollno
			];
			$upd_where=[
				"student_id"=>$student_id,
				"class_id"=>$class_id,
				"school_id"=>$school_id,
				"acdm_session_id"=>$acdm_session_id
			];
			$user_actvy_data= array(
				"activity_module" => 'sectionandroll',
				"action" => 'Update',
				"from_method" => 'sectionandroll/updateRollSection',
				"user_id" => $session['userid'],
				"ip_address" => getUserIPAddress(),
				"user_browser" => getUserBrowserName(),
				"user_platform" => getUserPlatform()
			 );
			$insert=$this->commondatamodel->updateData_WithUserActivity($upd_tbl_name,$upd_data,$upd_where,$user_actvty_tbl,$user_actvy_data);
			if($insert)
			{				
				$json_response = array(
					"msg_status" => HTTP_SUCCESS,
					"msg_data" => "Updated Successfully"
				);
			}
			else
			{
				$json_response = array(
					"msg_status" => HTTP_FAIL,
					"msg_data" => "Please try Again!"
				);
			}	
			header('Content-Type: application/json');
			echo json_encode( $json_response );
			exit;
		}else{
			redirect('login','refresh');
		}
	}


	function checkRoll()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$rollno=$this->input->post('rollno');
			$section_id=$this->input->post('section_id');
			$student_id= $this->input->post('student_id');
			$class_id= $this->input->post('class_id');
			$school_id= $this->input->post('school_id');
			$acdm_session_id= $this->input->post('acdm_session_id');

			$where =[
				"rollno"=>$rollno,
				"section_id"=>$section_id,
				// "student_id"=>$student_id,
				"class_id"=>$class_id,
				"school_id"=>$school_id,
				"acdm_session_id"=>$acdm_session_id
			];

			$check_data=$this->commondatamodel->duplicateValueCheck('academic_details',$where);

			if($check_data)
				{
					$json_response = array(
						"msg_status" => HTTP_FAIL,
						"msg_data" => "Already Used"
					);
				}
				else
				{
					$json_response = array(
						"msg_status" => HTTP_SUCCESS,
						"msg_data" => "Available"
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












}//class end 
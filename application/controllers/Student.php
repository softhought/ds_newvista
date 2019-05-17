<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student extends CI_Controller {
	public function __construct()
	{
	    parent::__construct();
		$this->load->library('session');
		$this->load->model('studentmodel','studentmodel',TRUE);
		$this->load->model('accountsmodel','accountsmodel',TRUE);
	}


	public function index()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$header = "";
			$page = "dashboard/admin_dashboard/student/student_list_view";
			$result = [];
			$header = "";
			$result['classList']=$this->commondatamodel->getAllDropdownData('class_master');
			$result['sectionList']=$this->commondatamodel->getAllDropdownData('section_master');//only current session need to fetch
			$result['studentList']=$this->studentmodel->getStudentListByRegno($session['acd_session_id']);			
			$result['StudentNameList']=$this->studentmodel->getStudentNameListGroupByName($session['acd_session_id']);
			createbody_method($result, $page, $header, $session);
			
		}
		else
		{
			redirect('login','refresh');
		}
	}

	public function addstudent()
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
				$studentID = 0;
				$result['studentEditdata'] = [];
				
				
			
			}
			else
			{
				$result['mode'] = "EDIT";
				$result['btnText'] = "Update";
				$result['btnTextLoader'] = "Updating...";
				$studentID = $this->uri->segment(3);
				
				$result['studentEditdata'] = $this->studentmodel->getStudentDataEditbyId($studentID,$session['acd_session_id']);

	//pre($result['studentEditdata']);exit;
				$result['studentAcademicData'] = $this->studentmodel->getStudentAcademicHistory($studentID);
				$where_account=[
					"account_id"=>$result['studentEditdata']->account_id
				];
				$result['groupIdToselect']=$this->commondatamodel->getSingleRowByWhereCls('account_master',$where_account);//group id
				
				
			}

			$result['genderList']=$this->commondatamodel->getAllDropdownData('gender_master');
			$result['bloodgroupList']=$this->commondatamodel->getAllDropdownData('blood_group');
			$result['casteList']=$this->commondatamodel->getAllDropdownData('caste_master');
			$result['religionList']=$this->commondatamodel->getAllDropdownData('religion_master');
			$result['occupationList']=$this->commondatamodel->getAllDropdownData('occupation_master');
			$result['relationList']=$this->commondatamodel->getAllDropdownData('relationship_master');
			$result['stateList']=$this->commondatamodel->getAllDropdownData('states');
			$result['classList']=$this->commondatamodel->getAllDropdownData('class_master');

			$where_dist = array('district.state_id' => 41, ); /*41:west bengal*/
			$result['districtList']=$this->commondatamodel->getAllRecordWhere('district',$where_dist);

			$result['accountGroupList']=$this->accountsmodel->getAllGroupList();

			$where_acd_session = array('academic_session_master.id' =>$session['acd_session_id'] );
			$result['sessionList']=$this->commondatamodel->getAllRecordWhere('academic_session_master',$where_acd_session);

			$result['sectionList']=$this->commondatamodel->getAllDropdownData('section_master');
			$header = "";

			$page = "dashboard/admin_dashboard/student/student_add_edit_view";
			createbody_method($result, $page, $header,$session);
		}
		else
		{
			redirect('login','refresh');
		}
	}


	/* get present district by state*/
	public function getPresentDistrict()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$stateid = trim($this->input->post('stateid'));
			$where_dist = array('district.state_id' => $stateid, ); 
			$result['districtList']=$this->commondatamodel->getAllRecordWhere('district',$where_dist);
				
	//pre($result['districtList']);
			$page = "dashboard/admin_dashboard/student/present_district_view";
			//$partial_view = $this->load->view($page,$result);
			echo $this->load->view($page, $result, TRUE);
			//echo $partial_view;
		}
		else
		{
			redirect('login','refresh');
		}
	}

	/* get  district by state*/
	public function getDistrict()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$stateid = trim($this->input->post('stateid'));
			$where_dist = array('district.state_id' => $stateid, ); 
			$result['districtList']=$this->commondatamodel->getAllRecordWhere('district',$where_dist);
			 
	//pre($result['districtList']);
			$page = "dashboard/admin_dashboard/student/district_view";
			//$partial_view = $this->load->view($page,$result);
			echo $this->load->view($page, $result, TRUE);
			//echo $partial_view;
		}
		else
		{
			redirect('login','refresh');
		}
	}


	public function saveStudent()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			// pre($this->input->post());exit;
			$student_array = array();
			$user_activity = array();
			$tbl_name = array();
		
			$session = $this->session->userdata('user_data');
			$studentID = trim($this->input->post('studentID'));
			$mode = trim($this->input->post('mode'));
			
			
			$form_sl_no = trim($this->input->post('form_sl_no'));
			$admdt=$this->input->post('admdt');
			
			if($admdt!=""){
				$admdt = str_replace('/', '-', $admdt);
				$admdt = date("Y-m-d",strtotime($admdt));
			 }
			 else{
				 $admdt = NULL;
			 }
			
			$studentdob = trim($this->input->post('studentdob'));
			if($studentdob!=""){
				$studentdob = str_replace('/', '-', $studentdob);
				$studentdob = date("Y-m-d",strtotime($studentdob));
			 }
			 else{
				 $studentdob = NULL;
			 }
			$gender = $this->input->post('gender');
			
			$docType = 1;
			$userFilename = $this->input->post('userFileName');
			$fileDesc = $this->input->post('fileDesc');


			$student_array = array(
				"studentID" => $studentID,
				"mode" => $mode,
				"reg_no" => trim($this->input->post('reg_no')),
				"form_sl_no" => trim($this->input->post('form_sl_no')),
				"admission_dt" => $admdt,
				"dob" => $studentdob,
				"name" => trim($this->input->post('student_name')),
				"gender_id" => $this->input->post('gender'),
				"blood_gr_id" => $this->input->post('bloodgroup'),
				// "caste_id" => $this->input->post('caste'),
				// "religion_id" => $this->input->post('religion'),
				"caste_id" =>NULL,
				"religion_id" =>NULL,
				"father_name" => trim($this->input->post('father_name')),
				"father_contact_no" => trim($this->input->post('father_contact_no')),
				"father_occupation_id" => $this->input->post('father_occupation'),
				"fathers_income" => trim($this->input->post('father_income')),
				"mother_name" => trim($this->input->post('mother_name')),
				"mother_contact_no" => trim($this->input->post('mother_contact_no')),
				"mother_occupation_id" => $this->input->post('mother_occupation'),
				"mother_income" => trim($this->input->post('mother_income')),
				"guardian_name" => trim($this->input->post('guardian_name')),
				"relationship_id" => trim($this->input->post('guardian_relation')),
				"present_area" => trim($this->input->post('present_area')),
				"present_town" => trim($this->input->post('present_town')),
				"present_po" => trim($this->input->post('present_po')),
				"present_ps" => trim($this->input->post('present_ps')),
				"present_pin" => trim($this->input->post('present_pin')),
				"present_state_id" => $this->input->post('present_state'),
				"present_dist_id" => $this->input->post('present_dist'),
				"area" => $this->input->post('area'),
				"town" => $this->input->post('town'),
				"post_office" => $this->input->post('post_office'),
				"police_station" => $this->input->post('police_station'),
				
				"pin_code" => $this->input->post('pin_code'),
				"state_id" => $this->input->post('state'),
				"dist_id" => $this->input->post('district'),

				"acdm_session_id" => $this->input->post('academic_session'),
				"class_id" => $this->input->post('acdm_class'),
				"section_id" => $this->input->post('acdm_section'),
				"rollno" => $this->input->post('acdm_roll'),
				"account_id" => $this->input->post('account_group'),
				

				"docType" => $docType,
				"userFilename" => $userFilename,
				"docFile" => $_FILES,
				"fileDesc" => $fileDesc
				
			
				
			);

			if($studentID>0 && $mode=="EDIT")
			{
				
				
				$isFileChanged = $this->input->post('isChangedFile');
				$randomFileName = $this->input->post('randomFileName');
				$prvFilename = $this->input->post('prvFilename');
				$docDetailIDs = $this->input->post('docDetailIDs');
				
				$student_array_edit_info = array(
					'isChangedFile' => $isFileChanged ,
					'randomFileName' => $randomFileName, 
					'prvFilename' => $prvFilename, 
					"account" => $this->input->post('account'),
					'docDetailIDs' => $docDetailIDs 
				);

				$student_array_new = array_merge($student_array,$student_array_edit_info);
				

				$updateData = $this->studentmodel->updateStudent($student_array_new,$session);
				if($updateData)
				{
					$json_response = array(
						"msg_status" => HTTP_SUCCESS,
						"msg_data" => "Updated successfully"
					);
				}
				else
				{
					$json_response = array(
						"msg_status" => HTTP_SUCCESS,
						"msg_data" => "Error : There is some problem while saving ...Please try again."
					);
				}		
			}
			else
			{
				
				$isFileChanged = $this->input->post('isChangedFile');
				
				
				$student_array_add_info = array(
					'isChangedFile' => $isFileChanged 
				);

				$student_array_new_add = array_merge($student_array,$student_array_add_info);
				
				$insertData = $this->studentmodel->inserIntoStudent($student_array_new_add,$session);
				if($insertData)
				{
					$json_response = array(
						"msg_status" => HTTP_SUCCESS,
						"msg_data" => "Saved successfully"
					);
				}
				else
				{
					$json_response = array(
						"msg_status" => HTTP_FAIL,
						"msg_data" => "Error : There is some problem while saving ...Please try again."
					);
				}				
					
				
				    
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

	/* check reg no */
	public function checkRegNo()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$reg_no=$this->input->post('reg_no');

			$where = array('student_master.reg_no' => $reg_no );

			$check_data=$this->commondatamodel->duplicateValueCheck('student_master',$where);

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


	/* check form Sl no */
	public function checkFromSl()
	{
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{
			$form_sl_no=$this->input->post('form_sl_no');

			$where = array('student_master.form_sl_no' => $form_sl_no );

			$check_data=$this->commondatamodel->duplicateValueCheck('student_master',$where);

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






   public function studentListData()
	{ 
		$session = $this->session->userdata('user_data');
		if($this->session->userdata('user_data'))
		{       
		
			// pre($this->input->post());exit;
			$header = "";
			$formData = $this->input->post('formDatas');
			parse_str($formData, $dataArry);
			

			$result=[];
			
			if (($dataArry['sel_reg']!="")) {
				$student_id = $dataArry['sel_reg'];
				
				
			$result['studentList'] = $this->studentmodel->getStudentbyStudentId($student_id,$session['acd_session_id']); 	
           
			}elseif($dataArry['sel_name']!=""){
				$sel_name=$dataArry['sel_name'];
				
				$result['studentList'] = $this->studentmodel->getStudentListbyName($sel_name); 

			}elseif($dataArry['sel_class']!="" && $dataArry['sel_section']!=""){
				$sel_class=$dataArry['sel_class'];
				$sel_section=$dataArry['sel_section'];

				$result['studentList'] = $this->studentmodel->getStudentListbyClassSection($sel_class,$sel_section); 

			}elseif($dataArry['sel_class']!=""){
				$sel_class=$dataArry['sel_class'];			

				$result['studentList'] = $this->studentmodel->getStudentListbyClass($sel_class); 

			}
			else{
				$result['studentList']=[];
			}

			

   	
			$page = "dashboard/admin_dashboard/student/student_list_data";
			
			$partial_view = $this->load->view($page, $result, TRUE);

			echo $partial_view;
			
		}
		else
		{
			redirect('adminpanel','refresh');
		}
	}

} // end of class
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		$this->load->model('commondatamodel','commondatamodel',TRUE);
		$this->load->model('accountsmodel','accountsmodel',TRUE);
		$this->load->model('studentmodel','studentmodel',TRUE);
		$this->load->model('vendormodel','vendormodel',TRUE);
    }


    public function index()
    {
        $session=$this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{ 
            $header="";
            $result['module']="List";
            $result['VendorList']=$this->commondatamodel->getAllRecordOrderBy('vendor_master','name','ASC');
            
            
            $page = "dashboard/admin_dashboard/vendor/vendor";
			createbody_method($result, $page, $header, $session);

        }else{
            redirect('login','refresh');
        } 
    }


    public function vendor()
    {
        $session=$this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{             
            $header="";
            $result['groupList']=$this->accountsmodel->getAllGroupList();
            $result['stateList']=$this->commondatamodel->getAllDropdownData('states');
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
                $result['vendor_id']=$this->uri->segment(3);
                $whereAry = array(
					'id' =>$this->uri->segment(3)
                );
                $result['vendorEditData']=$this->commondatamodel->getSingleRowByWhereCls('vendor_master',$whereAry);

                $where_account=[
					"account_id"=>$this->uri->segment(4)
				];
				$result['groupIdToselect']=$this->commondatamodel->getSingleRowByWhereCls('account_master',$where_account);//group id
               
            }
            
            $page = "dashboard/admin_dashboard/vendor/vendor_add_edit";
			createbody_method($result, $page, $header, $session);

        }else{
            redirect('login','refresh');
        } 
    }

    public function AddEditVendor()
    {
        $session=$this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{ 
            // print_r($this->input->post());exit;
            $mode=$this->input->post('mode');
            $group_id=$this->input->post('group_id');
            $name=$this->input->post('vendor_name');           

            if($mode=="ADD")
            {
                /* Add mode part */
                $user_activity = array(
                    "activity_module" => 'vendor',
                    "action" => 'Insert',
                    "from_method" => 'vendor/AddEditVendor',
                    "user_id" => $session['userid'],
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
                 );
                 $account_master_data=[
                    "account_name"=>$name,
                    "group_id"=>$Group_id,
                    "bank_ifsc"=>$this->input->post('bank_ifsc'), 
                    "bank_ac_no"=>$this->input->post('bank_ac_no'), 
                    "bank_address"=>$this->input->post('bank_address'), 
                    "bank_branch"=>$this->input->post('bank_branch'), 
                    "school_id"=>$session['school_id'],
                    "is_special"=>"N",
                    "is_active"=>"Y",
                    "from_where"=>"O",
                    "created_By"=>$session['userid']
                ];

                $account_master_id=$this->commondatamodel->insertSingleTableData("account_master",$account_master_data);
                $data_arr=[
                    "name"=>$name,
                    "address"=>$this->input->post('address'),
                    "gst_no"=>$this->input->post('gst_no'),
                    "contact_no"=>$this->input->post('contact_no'),
                    "contact_persone"=>$this->input->post('contact_persone'),
                    "state_id"=>$this->input->post('state_id'),                    
                    "account_master_id"=>$account_master_id,
                    "bank_ifsc"=>$this->input->post('bank_ifsc'), 
                    "bank_ac_no"=>$this->input->post('bank_ac_no'), 
                    "bank_address"=>$this->input->post('bank_address'), 
                    "bank_branch"=>$this->input->post('bank_branch'), 
                    "is_active"=>"Y"  
                ];         


                $tbl_name = array('vendor_master','activity_log');
                $insert_array = array($data_arr,$user_activity);
                $insert=$this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);
                
                
            }else{
                /* Edit mode part */
                $account_id=$this->input->post('account_id');
                $user_activity = array(
                    "activity_module" => 'vendor',
                    "action" => 'Update',
                    "from_method" => 'vendor/AddEditVendor',
                    "user_id" => $session['userid'],
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
                 );

                $data_arr=[
                    "name"=>$name,
                    "address"=>$this->input->post('address'),
                    "gst_no"=>$this->input->post('gst_no'),
                    "contact_no"=>$this->input->post('contact_no'),
                    "contact_persone"=>$this->input->post('contact_persone'),
                    "state_id"=>$this->input->post('state_id'),
                    "account_master_id"=>$account_id,  
                    "bank_ifsc"=>$this->input->post('bank_ifsc'), 
                    "bank_ac_no"=>$this->input->post('bank_ac_no'), 
                    "bank_address"=>$this->input->post('bank_address'), 
                    "bank_branch"=>$this->input->post('bank_branch'),                  
                    "is_active"=>"Y"  
                ];
                $where=[
                    "id"=>$this->input->post('vendor_id')
                ];
                $data_arr2=[
                    "group_id"=>$group_id,
                    "bank_ifsc"=>$this->input->post('bank_ifsc'), 
                    "bank_ac_no"=>$this->input->post('bank_ac_no'), 
                    "bank_address"=>$this->input->post('bank_address'), 
                    "bank_branch"=>$this->input->post('bank_branch'),
                    "account_name"=>$name
                ];
                $where2=[
                    "account_id"=>$account_id
                ];
                $UpdatetblnameArry = array('vendor_master','account_master');
                $UpdateArray = array($data_arr,$data_arr2);
                $upd_whereArr=array($where,$where2);

                $insert=$this->vendormodel->updateMultiTableData_WithUserActivity($UpdatetblnameArry,$UpdateArray,$upd_whereArr,$user_activity,'activity_log'); 

            }
            // print_r($data_arr);exit;            

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






}/* end of class */
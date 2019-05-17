<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accounts extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
		$this->load->model('accountsmodel','accountsmodel',TRUE);
		$this->load->model('commondatamodel','commondatamodel',TRUE);
    }

    /* ******************* Group Section ******************* */

    public function index()
    {
        $session=$this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{           
            $header = "";
            $result['module'] = "Group";
            $result['groupList']=$this->accountsmodel->getAllGroupList();
            // print_r($result);exit;   
			$page = "dashboard/admin_dashboard/accounts/group/group_list";
			createbody_method($result, $page, $header, $session);
            
        }else{
            redirect('login','refresh');
        }
    }
    public function group()
    {
        $session=$this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
            // echo "ID-".$this->uri->segment(3);exit;
            if (empty($this->uri->segment(3)))
			{
               
                $result['module'] = "Group";		
                $result['mode'] = "ADD";		
                $result['btnText'] = "Submit";
                $result['btnTextLoader'] = "Saving...";
                $result['editgroup']=[];
                	
            }else{
                $result['module'] = "Group";	
                $result['mode'] = "EDIT";	
                $result['btnText'] = "Update";
                $result['btnTextLoader'] = "Updating...";
                $group_id = $this->uri->segment(3);
				$whereAry = array(
					'id' => $group_id
                );
                $result['editgroup'] = $this->commondatamodel->getSingleRowByWhereCls('group_master',$whereAry); 
            }	
            $header = "";
			$page = "dashboard/admin_dashboard/accounts/group/group";
			createbody_method($result, $page, $header, $session);
        }else{
			redirect('login','refresh');
		}

    }
    public function GroupInsert()
    {
        $session=$this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{
            //  print_r($this->input->post());exit;
            $group_description=$this->input->post("group_description");
            $main_category=$this->input->post("main_category");
            $sub_category=$this->input->post("sub_category");
            $mode=$this->input->post("mode"); 
            if($this->input->post("is_active")=="Y" && $this->input->post("is_active")!="")
                {
                    $is_active="Y";
                }else{
                    $is_active="N";
                } 
            if (!$this->input->post("is_bank")) {
                $is_bank="N";
            }else{
                $is_bank="Y";
            }
            $insert_arr['is_active']=$is_active ;                      
            $insert_arr['is_bank']=$is_bank;                      
            $insert_arr['group_description']=$group_description ;
            $insert_arr['main_category']=$main_category ;
            $insert_arr['sub_category']=$sub_category ; 
            $insert_arr['is_special']="N" ;
                
            if ($mode=="ADD") {  
                $user_activity = array(
                    "activity_module" => 'account',
                    "action" => 'Insert',
                    "from_method" => 'account/GroupInsert',
                    "user_id" => $session['userid'],
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
                 );
                 $tbl_name = array('group_master','activity_log');
                 $insert_array = array($insert_arr,$user_activity);
                $insert=$this->commondatamodel->insertMultiTableData($tbl_name,$insert_array);
            }else{
                $user_activity = array(
                    "activity_module" => 'account',
                    "action" => 'Update',
                    "from_method" => 'account/GroupInsert',
                    "user_id" => $session['userid'],
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
                 );
                $id=$this->input->post("id");
                // $insert_arr['is_special']=$this->input->post("is_special");
                $whereAry = array(
					'id' => $id
                );    
                $insert=$this->commondatamodel->updateData_WithUserActivity('group_master',$insert_arr,$whereAry,'activity_log',$user_activity);            
                // $insert=$this->commondatamodel->updateSingleTableData($table,$insert_arr,$whereAry);
            }
           
            if($insert)
            {
                $json_response = array(
                    "msg_status" => HTTP_SUCCESS,
                    "msg_data" => "Saved successfully",
                    "mode" => "ADD"
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

    /* ******************* Group Section End ******************* */


    /* ******************* Account Section  ******************* */

    public function account()
    {
        $session=$this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{  

            if (empty($this->uri->segment(3)))
            {
                
                $result['module'] = "Add";
                $result['mode'] = "ADD";
                $result['btnText'] = "Submit";
                $result['btnTextLoader'] = "Saving...";
            }else{
                $result['module'] = "Edit";	
                $result['mode'] = "EDIT";	
                $result['btnText'] = "Update";
                $result['btnTextLoader'] = "Updating...";
                $result['account_id'] = $this->uri->segment(3);
                $result['acountEditData']=$this->accountsmodel->getAcountEditData($this->uri->segment(3));
                // pre($result['acountEditData']);              

            }
            $header = "";
            $result['groupList']=$this->accountsmodel->getAllGroupList();
            
			$page = "dashboard/admin_dashboard/accounts/account/account";
			createbody_method($result, $page, $header, $session);
            
        }else{
            redirect('login','refresh');
        }
    }

    public function accountList()
    {
        $session=$this->session->userdata('user_data');
        if($this->session->userdata('user_data'))
		{     
            $accnt_year_id=$session['accnt_year_id'];      
            $header = "";
            $result['module'] = "List";
            $result['accountList']=$this->accountsmodel->getAllDataForAcountList($accnt_year_id);
            
			$page = "dashboard/admin_dashboard/accounts/account/account_list";
			createbody_method($result, $page, $header, $session);
            
        }else{
            redirect('login','refresh');
        }
    }

    public function accountAddEdit()
    {
        $session=$this->session->userdata('user_data');
    //    pre($session); exit;     
        if($this->session->userdata('user_data'))
		{ 
            $acd_session_id=$session['acd_session_id'];
            $accnt_year_id=$session['accnt_year_id'];
            $school_id=$session['school_id'];
            $userid=$session['userid'];
            //  print_r($this->input->post());exit;
             $account_name =$this->input->post('account_name');
             $group_id =$this->input->post('group_id');
             $opening_balance =$this->input->post('opening_balance');
             $mode =$this->input->post('mode');
             if($this->input->post("is_active")=="Y" && $this->input->post("is_active")!="")
                {
                    $is_active="Y";
                }else{
                    $is_active="N";
                }            
             $is_special='N';

             if ($this->input->post('bank_ifsc')!="") {
                $bank_ifsc=$this->input->post('bank_ifsc');
                $bank_ac_no=$this->input->post('bank_ac_no');
                $bank_address=$this->input->post('bank_address');
                $bank_branch=$this->input->post('bank_branch');
             }else{
                $bank_ifsc=NULL;
                $bank_ac_no=NULL;
                $bank_address=NULL;
                $bank_branch=NULL;
             }

             if($mode=="ADD")
             {
                $user_activity = array(
                    "activity_module" => 'account',
                    "action" => 'Insert',
                    "from_method" => 'account/accountAddEdit',
                    "user_id" => $session['userid'],
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
                 );
                

                 $data=[
                    "account_name"=>$account_name,
                    "group_id"=>$group_id,
                    "school_id"=>$school_id,
                    'bank_ifsc'=>$bank_ifsc,
                    'bank_ac_no'=>$bank_ac_no,
                    'bank_address'=>$bank_address,
                    'bank_branch'=>$bank_branch,
                    "is_special"=>$is_special,
                    "from_where"=>'S',
                    "is_active"=>$is_active,
                    "created_by"=>$userid
                ];

                $insert=$this->accountsmodel->insertAccount($data,$userid,$acd_session_id,$accnt_year_id,$school_id,$opening_balance,$user_activity);
             }else{
                $account_id =$this->input->post('account_id');
                $data1=[
                    "account_name"=>$account_name,
                    'bank_ifsc'=>$bank_ifsc,
                    'bank_ac_no'=>$bank_ac_no,
                    'bank_address'=>$bank_address,
                    'bank_branch'=>$bank_branch,
                    "group_id"=>$group_id,
                    "is_active"=>$is_active
                ];
                $where=[
                    "account_id"=>$account_id,
                    "school_id"=>$school_id,
                    "created_by"=>$userid
                ];
                $data2=[
                    "account_master_id"=>$account_id,
                    "school_id"=>$school_id,
                    "acdm_session_id"=>$acd_session_id,
                    "accnt_year_id"=>$accnt_year_id,
                    "opening_balance"=>$opening_balance,
                    "created_by"=>$userid
                ];
                $user_activity = array(
                    "activity_module" => 'account',
                    "action" => 'Update',
                    "from_method" => 'account/accountAddEdit',
                    "user_id" => $session['userid'],
                    "ip_address" => getUserIPAddress(),
                    "user_browser" => getUserBrowserName(),
                    "user_platform" => getUserPlatform()
                 );
                $insert=$this->accountsmodel->updateAccountMaster($data1,$where,$data2,$user_activity);
             }
             


             if($insert)
             {
                 $json_response = array(
                     "msg_status" => HTTP_SUCCESS,
                     "msg_data" => "Saved successfully",
                     "mode" => "ADD"
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


    /* ******************* Account Section End ******************* */







}
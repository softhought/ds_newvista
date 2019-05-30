<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Dashboard extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('commondatamodel','commondatamodel',TRUE);
        $this->load->model('dashboardmodel','dashboardmodel',TRUE);
       
    }
  public function index(){

    $session = $this->session->userdata('user_data');
    if($this->session->userdata('user_data'))
    {
      header("Access-Control-Allow-Origin: *");
      $session = $this->session->userdata('user_data');
      $where=[
        "academic_details.acdm_session_id"=>$session['acd_session_id'],
        "academic_details.school_id"=>$session['school_id'],
        "student_master.is_active"=>'1'
      ];
      $where1=[
        "academic_details.acdm_session_id"=>$session['acd_session_id'],
        "student_master.is_active"=>'1',
        "academic_details.school_id"=>$session['school_id'],
        "student_master.admission_dt"=>date('Y-m-d')
      ];
      $result['TodayCollectionSum']=$this->dashboardmodel->TodayCollectionSum($session['school_id']);
      $result['activeStdentCount']=$this->dashboardmodel->rowcountWithWhere('student_master',$where);
      $result['todayAdmissionCount']=$this->dashboardmodel->rowcountWithWhere('student_master',$where1);
      
      $month_id=$this->dashboardmodel->getMonthIdByMonthCode(strtoupper(date('M')));
      $totalDueThisMonth=$this->dashboardmodel->totalDueThisMonth($session['acd_session_id'],$session['school_id'],$month_id);
     pre($totalDueThisMonth);
      $total_due=0;
      foreach ($totalDueThisMonth as $key => $class) {
       foreach ($class as $key => $student) {
         $total_due +=$student['total_due_amount_monthly'];
       }
      }
      $result['totalDueThisMonth']=number_format($total_due,2);

      $page = 'dashboard/admin_dashboard/ds-home/dashboard-home';
 
      $header = "";
 


      createbody_method($result, $page, $header, $session);
      }
    else
    {
      redirect('login','refresh');
    }
  }
  
  public function groupByList()
  {
    $session = $this->session->userdata('user_data');
    if($this->session->userdata('user_data'))
    {
      header("Access-Control-Allow-Origin: *");
      $view=$this->input->post("viewname");
      if($view=="Studentlist")
      {
        $data['Studentlist']=$this->dashboardmodel->getStudentListGroupByClassName($session['school_id'],$session['acd_session_id']);
        $this->load->view('dashboard/admin_dashboard/ds-home/list_partial_view', $data); 
      }
      if($view=="todayAdmissionlist")
      {
        $data['from_date']="";
        $data['to_date']="";
        $data['todayAdmissionlist']=$this->dashboardmodel->todayAdmissionStudentListGroupByClassName($session['school_id'],$session['acd_session_id']);
        $this->load->view('dashboard/admin_dashboard/ds-home/list_partial_view_filterByDate', $data); 
      }
      
    }else{
      redirect('login','refresh');
    }
  }

  public function FilterByDate()
  {
    $session = $this->session->userdata('user_data');
    if($this->session->userdata('user_data'))
    {
      header("Access-Control-Allow-Origin: *");
     $from_date=date_dmy_to_ymd($this->input->post('from_date'));
     $to_date=date_dmy_to_ymd($this->input->post('to_date')); 
      
        $data['todayAdmissionlist']=$this->dashboardmodel->FilterByDateAdmissionStudentListGroupByClassName($session['school_id'],$session['acd_session_id'],$from_date,$to_date);
        $data['from_date']=$this->input->post('from_date');
        $data['to_date']=$this->input->post('to_date');
        $this->load->view('dashboard/admin_dashboard/ds-home/list_partial_view_filterByDate', $data); 
     
      
    }else{
      redirect('login','refresh');
    }
  }
  public function ListofDueThisMonthList()
  {
    $session = $this->session->userdata('user_data');
    if($this->session->userdata('user_data'))
    {
      $month_id=$this->dashboardmodel->getMonthIdByMonthCode(strtoupper(date('M')));
      $data['totalDueThisMonth']=$this->dashboardmodel->totalDueThisMonth($session['acd_session_id'],$session['school_id'],$month_id);     
      $this->load->view('dashboard/admin_dashboard/ds-home/due_list_partial_view', $data); 
    }else{
      redirect('login','refresh');
    }
  }




}/* end of class */

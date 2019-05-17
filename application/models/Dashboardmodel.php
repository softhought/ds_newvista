<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboardmodel extends CI_Model{
    public function rowcountWithWhere($table,$where)
    {
            
        $this->db->select('*')
                ->from($table)
                ->join('academic_details','student_master.student_id=academic_details.student_id')
                ->where($where);

        $query = $this->db->get();
        $rowcount = $query->num_rows();
        
        if($query->num_rows()>0){
            return $rowcount;
        }
        else
        {
            return 0;
        }
            
    }


    public function getStudentListGroupByClassName($school_id,$acd_session_id)
    {
        $where=[ 
            "academic_details.acdm_session_id"=>$acd_session_id,
            "academic_details.school_id"=>$school_id,  
            "student_master.is_active"=>'1'
        ];
        $data = [];
            $query = $this->db->select("student_master.*,district.name as distName,district.name as present_distName,states.name as stateName,states.name as present_stateName,academic_details.*,blood_group.*,class_master.classname,section_master.section")
                    ->from('academic_details')
                    ->join('student_master','academic_details.student_id=student_master.student_id','INNER')
                    ->join('class_master','academic_details.class_id=class_master.id','LEFT')
                    ->join('section_master','academic_details.section_id=section_master.id','LEFT')
                    ->join('blood_group','student_master.blood_gr_id=blood_group.id','LEFT')
                    ->join('states','student_master.state_id=states.id','LEFT')
                    ->join('district','student_master.dist_id=district.id','LEFT')
                    // ->join('states','student_master.present_state_id=states.id','LEFT')
                    // ->join('district','student_master.present_dist_id=district.id','LEFT')
                    ->where($where)
                    ->get();
                
                if($query->num_rows()> 0)
                {
                  foreach($query->result() as $rows)
                    {
                        $data[] = $rows;
                    }
                     
                }
                
                return $data;
    
    }
    public function todayAdmissionStudentListGroupByClassName($school_id,$acd_session_id)
    {
        $where=[ 
            "academic_details.acdm_session_id"=>$acd_session_id,
            "academic_details.school_id"=>$school_id,  
            "student_master.is_active"=>'1',
            "student_master.admission_dt"=>date('Y-m-d')
        ];
        $data = [];
            $query = $this->db->select("student_master.*,district.name as distName,district.name as present_distName,states.name as stateName,states.name as present_stateName,academic_details.*,blood_group.*,class_master.classname,section_master.section")
                    ->from('academic_details')
                    ->join('student_master','academic_details.student_id=student_master.student_id','INNER')
                    ->join('class_master','academic_details.class_id=class_master.id','LEFT')
                    ->join('section_master','academic_details.section_id=section_master.id','LEFT')
                    ->join('blood_group','student_master.blood_gr_id=blood_group.id','LEFT')
                    ->join('states','student_master.state_id=states.id','LEFT')
                    ->join('district','student_master.dist_id=district.id','LEFT')
                    // ->join('states','student_master.present_state_id=states.id','LEFT')
                    // ->join('district','student_master.present_dist_id=district.id','LEFT')
                    ->where($where)
                    ->get();
                
                if($query->num_rows()> 0)
                {
                  foreach($query->result() as $rows)
                    {
                        $data[] = $rows;
                    }
                     
                }
                
                return $data;
    
    }

    public function FilterByDateAdmissionStudentListGroupByClassName($school_id,$acd_session_id,$from_date,$to_date)
    {
        $where=[ 
            "academic_details.acdm_session_id"=>$acd_session_id,
            "academic_details.school_id"=>$school_id,  
            "student_master.is_active"=>'1'
        ];
        $data = [];
            $query = $this->db->select("student_master.*,district.name as distName,district.name as present_distName,states.name as stateName,states.name as present_stateName,academic_details.*,blood_group.*,class_master.classname,section_master.section")
                    ->from('academic_details')
                    ->join('student_master','academic_details.student_id=student_master.student_id','INNER')
                    ->join('class_master','academic_details.class_id=class_master.id','LEFT')
                    ->join('section_master','academic_details.section_id=section_master.id','LEFT')
                    ->join('blood_group','student_master.blood_gr_id=blood_group.id','LEFT')
                    ->join('states','student_master.state_id=states.id','LEFT')
                    ->join('district','student_master.dist_id=district.id','LEFT')
                    // ->join('states','student_master.present_state_id=states.id','LEFT')
                    // ->join('district','student_master.present_dist_id=district.id','LEFT')
                    ->where($where)
                    ->where("student_master.admission_dt >= '$from_date' AND  student_master.admission_dt <= '$to_date'","",FALSE)
                    ->get();
                    //q();
                if($query->num_rows()> 0)
                {
                  foreach($query->result() as $rows)
                    {
                        $data[] = $rows;
                    }
                     
                }
                
                return $data;
    
    }

    public  function TodayCollectionSum($school_id)
    {
        $data=[];
        $where=[
            "school_id"=>$school_id,
            "payment_date"=>date('Y-m-d')           
        ];
        $query = $this->db->select("SUM(paid_amount) today_collection")
                          ->from('payment_master')
                          ->where($where)
                          ->get();
               if($query->num_rows()> 0)
                {
                  foreach($query->result() as $rows)
                    {
                        $data=$rows->today_collection;
                    }
                     
                }
                
                return $data;
    }

    




}/* end of class */
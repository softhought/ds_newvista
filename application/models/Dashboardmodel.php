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

    // public function totalDueThisMonth($acdm_session_id,$school_id,$month_id)
    // {
    //     return $this->getClassIdInFessSession($acdm_session_id,$school_id,$month_id);
    // }
    
    //public function getClassIdInFessSession($acdm_session_id,$school_id,$month_id) // class wise student list
    public function totalDueThisMonth($acdm_session_id,$school_id,$month_id) // class wise student list
	{
        $data=[];
		$where=[
            "fees_session.acdm_session_id"=>$acdm_session_id,
            "fees_session.school_id"=>$school_id		
		];
		$query=$this->db->select("fees_session.class_id,class_master.classname")
                ->from('fees_session')
                ->join('class_master','fees_session.class_id=class_master.id','INNER')
                ->where($where)
                ->group_by('fees_session.class_id')
				->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				//$data[]= $rows->class_id;
				$data[$rows->classname]= $this->getAllStudentByClassId($acdm_session_id,$school_id,$rows->class_id,$rows->classname,$month_id);
            }
            return $data;
        }else{
             return $data;
         }
    }

    public function getAllStudentByClassId($acdm_session_id,$school_id,$class_id,$classname,$month_id) // student list
    {

        $data=[];
		$where=[
            "academic_details.acdm_session_id"=>$acdm_session_id,
            "academic_details.school_id"=>$school_id,
            "academic_details.class_id"=>$class_id	
		];
		$query=$this->db->select("student_master.student_id,student_master.name")
                ->from('academic_details')
                ->join('student_master','academic_details.student_id=student_master.student_id','INNER')
                ->where($where)
				->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
                $paid_amount=$this->getSumOfPaidAmount($rows->student_id,$month_id,$acdm_session_id,$school_id);
                $total_fees_amount=$this->getSumOfFeesAmountByMonthClassWise($acdm_session_id,$school_id,$class_id,$month_id);
                $data[$rows->name.'-'.$rows->student_id]= [
                   "student_id"=>$rows->student_id,
                   "student_name"=>$rows->name,
                   "classname"=>$classname,
                   "month_id"=>$month_id,
                   "paid_amount"=>$paid_amount,
                   "total_fees_amount"=>$total_fees_amount,
                   "total_due_amount_monthly"=>$total_fees_amount-$paid_amount
                ];
            }
            return $data;
        }else{
             return $data;
         }
    }
    
    public function getSumOfPaidAmount($student_id,$month_id,$acdm_session_id,$school_id)
	{
		
		$sql="SELECT 
        ((SELECT IFNULL(SUM(payment_voucher_ref.paid_amount),0) FROM payment_voucher_ref  
        WHERE payment_voucher_ref.payment_id IN(SELECT GROUP_CONCAT(payment_master.payment_id) FROM payment_master 
        INNER JOIN payment_details ON payment_master.payment_id = payment_details.payment_master_id 
        WHERE payment_master.student_id = $student_id AND payment_details.month_id =$month_id AND payment_master.acdm_session_id=$acdm_session_id AND payment_master.school_id=$school_id)
        AND payment_voucher_ref.voucher_tag = 'J'  AND payment_voucher_ref.voucher_type = 'C' )+
        (SELECT IFNULL(SUM( payment_voucher_ref.paid_amount),0) FROM payment_voucher_ref  
        WHERE payment_voucher_ref.payment_id  IN(SELECT GROUP_CONCAT(payment_master.payment_id) FROM payment_master 
        INNER JOIN payment_details ON payment_master.payment_id = payment_details.payment_master_id 
        WHERE payment_master.student_id = $student_id AND payment_details.month_id =$month_id AND payment_master.acdm_session_id=$acdm_session_id AND payment_master.school_id=$school_id)
        AND payment_voucher_ref.voucher_tag = 'R' )) AS paid_amount ";
		$query=$this->db->query($sql);
       //q();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				return $rows->paid_amount;
            }
        }else{
             return 0;
         }
	}
    public function getSumOfFeesAmountByMonthClassWise($acdm_session_id,$school_id,$class_id,$month_id)
	{
		$where=[
			"fees_session.acdm_session_id"=>$acdm_session_id,			
			"fees_session.school_id"=>$school_id,			
			"fees_session.class_id"=>$class_id,			
			"fees_strucrure_month_dtl.month_id"=>$month_id			
		];
		$query=$this->db->select("SUM(fees_session.amount) as total_fees_amount")
                ->from('fees_session')
                ->join('class_master','fees_session.class_id=class_master.id','INNER')
                ->join('fees_strucrure_month_dtl','fees_strucrure_month_dtl.fees_structure_id=fees_session.fees_id','INNER')
				->where($where)
				->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				return $rows->total_fees_amount;
            }
        }else{
             return 0;
         }
	}

    public function getMonthIdByMonthCode($MonthCode)
    {
        $where=[
			'month_code'=>$MonthCode,			
		];
		$query=$this->db->select("id")
				->from('month_master')
				->where($where)
				->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				return $rows->id;
            }
        }else{
             return 0;
         }
    }



}/* end of class */
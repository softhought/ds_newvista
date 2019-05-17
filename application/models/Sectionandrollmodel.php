<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sectionandrollmodel extends CI_Model
{
    public function getStudentListByClass($class_id,$session_id,$user_id)
    {
        $where=[
            "academic_details.class_id"=>$class_id,
            "academic_details.acdm_session_id"=>$session_id,
            "academic_details.created_by"=>$user_id,
            "student_master.is_active"=>'1'
        ];
        $data = array();
        $this->db->select("*")
                 ->from("academic_details")
                 ->join("student_master","academic_details.student_id=student_master.student_id")
                 ->join("class_master","academic_details.class_id=class_master.id")
                 ->where($where)
                 ->order_by('student_master.name');
        $query = $this->db->get();
        if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }
}
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feesstructuremodel extends CI_Model{

    public function __construct()
	{
		$this->load->model('commondatamodel','commondatamodel',TRUE);
		
	}
    
	public function getfeesList($school_id,$class_id,$acdm_session_id){
       
        $data = [];
        $where_sc = array('fees_structure.school_id' =>$school_id);
        $query = $this->db->select("fees_structure.*")
                ->from('fees_structure')
                ->join('fees_session',"fees_session.fees_id = fees_structure.id AND fees_session.school_id='".$school_id."' and fees_session.class_id='".$class_id."' and fees_session.acdm_session_id='".$acdm_session_id."'",'LEFT')
                ->where('fees_session.fees_id IS NULL')
                ->where($where_sc)
                ->order_by('fees_structure.id')
                ->get();
            // q();
            if($query->num_rows()> 0)
            {
              foreach($query->result() as $rows)
                {
                    $data[] = $rows;
                }
                 
            }
            
            return $data;
       
    
}



	public function getAllFeesstructureList($school_id,$acdm_session_id){
        $data = [];
        $where = array(
                        'fees_session.school_id' =>$school_id,
                        'fees_session.acdm_session_id' =>$acdm_session_id
                      );
        $query = $this->db->select("
                                    fees_session.*,
                                    class_master.classname,
                                    fees_structure.fees_desc
                                    ")
                ->from('fees_session')
                ->join('class_master','class_master.id = fees_session.class_id','INNER')
                ->join('fees_structure','fees_structure.id = fees_session.fees_id','INNER')
				->where($where)
			    ->order_by('fees_session.id')
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
    
    public function checkIfThefeesStructureHaveAnyEntry($school_id,$acdm_session_id,$id)
    {
        $where=[
            'fees_session.school_id' =>$school_id,
            'fees_session.acdm_session_id' =>$acdm_session_id,
            'fees_session.id'=>$id
        ];
        $this->db->select('*')
                 ->from('fees_session')
                 ->join('payment_details','fees_session.id=payment_details.fees_session_id','INNER')
                 ->where($where);
            $query = $this->db->get();           
           $rowcount = $query->num_rows();        
            if($query->num_rows()>0){
                // return $rowcount;

                return false;//if get any data

            }else{
                return true;
            }
    }


} //end of class
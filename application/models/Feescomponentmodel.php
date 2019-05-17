<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feescomponentmodel extends CI_Model{


	public function getAllFeescomponentList($school_id){
        $data = [];
        $where = array('fees_structure.school_id' =>$school_id);
		$query = $this->db->select("fees_structure.*,account_master.account_name")
				->from('fees_structure')
				->join('account_master','account_master.account_id = fees_structure.account_id','left')
				->where($where)
			    ->order_by('fees_structure.id')
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


	/* testing*/

	public function getAllFeescomponentListWithMonth($school_id){
		
		$data = [];
		$where = array('fees_structure.school_id' =>$school_id);
		$query = $this->db->select("fees_structure.*,account_master.account_name")
				->from('fees_structure')
				->join('account_master','account_master.account_id = fees_structure.account_id','left')
				->where($where)
			    ->order_by('fees_structure.id')
				->get();

	        if($query->num_rows()> 0)
				{
		          foreach($query->result() as $rows)
					{
						//$data[] = $rows;
						$data[] = array(
                        "FeesComponentData" => $rows,
                        "monthData" => $this->getFeeMonthDetails($rows->id)

                        
                    
				      ); 
					}
		             
		        }
			
	        return $data;
	       
	}


	function deleteFeesMonthDetails($fees_structure_id)
	{
  	   $this->db->where('fees_strucrure_month_dtl.fees_structure_id', $fees_structure_id)
                ->delete('fees_strucrure_month_dtl');
        if ($this->db->affected_rows()) {
            return 1;
        }else{
            return 0;
        }
	}



	public function checkIfTheComponentHaveAnyEntry($school_id,$id)
	{
		$where=[
            'fees_session.school_id' =>$school_id,           
            'fees_session.fees_id'=>$id
        ];
        $this->db->select('*')
                 ->from('fees_session')
                 ->where($where);
            $query = $this->db->get();           
            $rowcount = $query->num_rows();        
            if($query->num_rows()>0){
                // return $rowcount;
				return false;//if get any data
				
            }else{
                $month=$this->deleteFeesMonthDetails($id);				
				$this->db->where('id', $id)
					     ->delete('fees_structure');				
				return true;			
				
            }
	}

	public function getFeeMonthDetails($fees_structure_id){
     $data = [];
    	$where = array(
			
			"fees_strucrure_month_dtl.fees_structure_id"=>$fees_structure_id
		);
        $data = array();
		$this->db->select("month_master.month_code")
				->from('fees_strucrure_month_dtl')
				->join('month_master','month_master.id = fees_strucrure_month_dtl.month_id','INNER')
				->where($where);
		$query = $this->db->get();
		
		#echo $this->db->last_query();
		
		if($query->num_rows()> 0)
				{
		          foreach($query->result() as $rows)
					{
						$data[] = $rows;
					}
		             
		        }
		
		
            return $data;      
        
	}
	



} //end of class
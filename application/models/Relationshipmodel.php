<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Relationshipmodel extends CI_Model{


	public function getAllRelationList(){
		$data = [];
		$query = $this->db->select("*")
				->from('relationship_master')
			    ->order_by('relationship_master.relation')
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


} //end of class
<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Occupationmodel extends CI_Model{


	public function getAllOccupatioList(){
		$data = [];
		$query = $this->db->select("*")
				->from('occupation_master')
			    ->order_by('occupation_master.occupation')
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
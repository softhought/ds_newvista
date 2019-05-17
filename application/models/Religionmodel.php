<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Religionmodel extends CI_Model{


	public function getAllReligionList(){
		$data = [];
		$query = $this->db->select("*")
				->from('religion_master')
			    ->order_by('religion_master.religion')
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
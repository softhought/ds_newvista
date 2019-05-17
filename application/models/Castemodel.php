<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Castemodel extends CI_Model{


	public function getAllCasteList(){
		$data = [];
		$query = $this->db->select("*")
				->from('caste_master')
			    ->order_by('caste_master.caste')
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
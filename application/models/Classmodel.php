<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Classmodel extends CI_Model{


	public function getAllClassList(){
		$data = [];
		$query = $this->db->select("*")
				->from('class_master')
			    ->order_by('class_master.id')
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
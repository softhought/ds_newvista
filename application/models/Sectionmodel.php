<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Sectionmodel extends CI_Model{


	public function getAllSectionList(){
		$data = [];
		$query = $this->db->select("*")
				->from('section_master')
			    ->order_by('section_master.section')
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
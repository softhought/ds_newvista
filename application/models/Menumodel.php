<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class menumodel extends CI_Model{
	public function getAcademicSessionData(){
		$session = $this->session->userdata('user_data');
			$data = [];
			$where = array('academic_session_master.id' =>$session['acd_session_id']);
			$query = $this->db->select("*")
					->from('academic_session_master')
					->where($where)
				    ->limit(1);
					$query = $this->db->get();
				#q();
				if($query->num_rows()> 0)
				{
		           $row = $query->row();
		           return $data = $row;
		             
		        }
				else
				{
		            return $data;
		        }
			       
		
	}	
	public function getAllAdministrativeMenu($table)
	{
		$data = array();
		$where_Ary = array(
			"admin_menu_master.is_parent" => "P",
			"admin_menu_master.is_active" => "Y"
		);
		
		$this->db->select("*")
				->from($table)
				->where($where_Ary)
				->order_by('admin_menu_master.menu_srl','ASC');
		$query = $this->db->get();
		
		if ($query->num_rows() > 0) 
		   {
			  foreach($query->result() as $rows)
			  {
					$data[] = array(
							"FirstLevelMenuData" => $rows,
							"secondLevelMenu" => $this->getSecondLevelMenu($rows->adm_menu_id,$table) 
						 );
			 }
		   }
		   return $data;
	}
	
	public function getSecondLevelMenu($parentID,$table)
	{
		$data = array();
		$where_Ary = array(
			"admin_menu_master.parent_id" => $parentID,
			"admin_menu_master.is_active" => "Y"
		);
		
		$this->db->select("*")
				->from($table)
				->where($where_Ary)
				->order_by('admin_menu_master.menu_srl','ASC');
		$query = $this->db->get();
		
		if($query->num_rows() > 0) 
		   {
				foreach($query->result() as $rows)
				{
					$data[] = array(
							"secondLevelMenuData" => $rows,
							"thirdLevelMenu" => $this->getThirdLevelMenu($rows->adm_menu_id,$table) 
						 );
				}
		   }
		   return $data;
	}
	
	public function getThirdLevelMenu($parentID,$table)
	{
		$data = array();
		$where_Ary = array(
			"admin_menu_master.parent_id" => $parentID,
			"admin_menu_master.is_active" => "Y"
		);
		
		$this->db->select("*")
				->from($table)
				->where($where_Ary)
				->order_by('admin_menu_master.menu_srl','ASC');
		$query = $this->db->get();
		if($query->num_rows() > 0) 
		{
			foreach($query->result() as $rows)
			{
				$data[] = array(
						"thirdLevelMenuData" =>$rows,
					);
			}
		}
		   return $data;
	}
	
	
	public function getSiteMapMenuByTitle($menuTitle)
	{
		$data = array();
		$sql = "SELECT * FROM admin_menu_master WHERE admin_menu_master.`menu_title`='".$menuTitle."' AND admin_menu_master.`is_parent`='P'";
		
		$query = $this->db->query($sql);
		   if ($query->num_rows() > 0) 
		   {
			  foreach($query->result() as $rows)
			  {
						$data[] = array(
							"first_menu_id" => $rows->id,
							"menu_name" => $rows->menu_name,
							"menu_link" => $rows->menu_link,
							"is_parent" => $rows->is_parent,
							"parent_id" => $rows->parent_id,
							"is_new" => $rows->is_new,
							"secondLevelMenu" => $this->getSecondLevelMenu($rows->id) 
						 );
					
                
				}
		   }
		   return $data;
	}


	// public function getAllRoleById(){
	// 	$data = [];
	// 	$session = $this->session->userdata('user_data');
	// 	$where = array('role_master.id' =>$session['roleid']);
	// 	$query = $this->db->select("*")
	// 			->from('role_master')
	// 			->where($where)
	// 			->get();
	// 			 //q();
			
	// 	if($query->num_rows()> 0)
	// 	{
    //        $row = $query->row();
    //        return $data = $row;
             
    //     }
	// 	else
	// 	{
    //         return $data;
    //     }
			
	      
	       
	// }
	
	
	
	
	
	
}
?>
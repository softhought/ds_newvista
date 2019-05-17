<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Accountsmodel extends CI_Model 
{
	public function __construct()
    {
        parent::__construct();		
		$this->load->model('commondatamodel','commondatamodel',TRUE);
    }

    public function getAllGroupList(){
		$data = [];
		// $where=[
		// 	// "is_active"=>"Y"
		// ];
		$query = $this->db->select("*")
				->from('group_master')
				// ->where($where)
				->order_by("group_description", "asc")
				->get();
			
			if($query->num_rows()> 0)
			{
	          foreach($query->result() as $rows)
				{
					$data[] = $rows;
				}
	             
	        }
			// print_r($data);exit;
	        return $data;
	       
		
	}

	public function getAllDataForAcountList($accnt_year_id)
	{
		$where=[
			"account_opening_master.accnt_year_id"=>$accnt_year_id
		];
		
		$data = [];
		$query = $this->db->select("account_master.account_name,account_master.is_active AS account_is_active,account_master.is_special AS account_is_special,account_master.account_id,account_master.group_id,group_master.*,account_opening_master.*")
				->from('account_master')
				->join('group_master','account_master.group_id=group_master.id','left')
				->join('account_opening_master','account_master.account_id=account_opening_master.account_master_id','left')
				// ->where($where)
				->order_by("account_master.account_name", "asc")
				->get();
			// echo $this->db->last_query();exit;
			if($query->num_rows()> 0)
			{
	          foreach($query->result() as $rows)
				{
					$data[] = $rows;
				}
	             
	        }
			// print_r($data);exit;
	        return $data;
	}


	public function insertAccount($data,$userid,$acd_session_id,$accnt_year_id,$school_id,$opening_balance,$user_activity)
	{
		
		// print_r($data);exit;		
            $this->db->trans_begin();
            $this->db->insert('account_master', $data);
            $lastinsert_id = $this->db->insert_id();

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                // $lastinsert_id=0;
                // return $lastinsert_id;
                return False;
            } else {
				$data2=[
					"account_master_id"=>$lastinsert_id,
					"opening_balance"=>$opening_balance,
					"school_id"=>$school_id,
					"accnt_year_id"=>$accnt_year_id,
					"acdm_session_id"=>$acd_session_id,
					"created_by"=>$userid
					
				];
				$insert=$this->insert_openingAcountMaster($data2);
				if($insert){
					$this->commondatamodel->insertSingleTableData('activity_log',$user_activity);
					$this->db->trans_commit();
					// $lastinsert_id;
					return true;
				}else{
					$this->db->trans_rollback();					
					return False;
				}
				// return true; 
            }
       
	}


	public function updateAccountMaster($data1,$where,$data2,$user_activity)
	{
		$this->db->trans_begin();            
			$this->db->update('account_master',$data1,$where);
			$this->db->last_query();
            //$affectedRow = $this->db->affected_rows();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                
                return FALSE;
            } else {
                $insert=$this->insert_openingAcountMaster($data2);
				if($insert){
					$this->commondatamodel->insertSingleTableData('activity_log',$user_activity);
					$this->db->trans_commit();
					return true;
				}else{
					$this->db->trans_rollback();					
					return False;
				}
            }
	}

	public function insert_openingAcountMaster($data)
	{
		$where=[
			"account_master_id"=>$data['account_master_id'],
			"acdm_session_id"=>$data['acdm_session_id']
		];
		// print_r($where);exit;
	
		$table="account_opening_master";
		$this->db->trans_begin();
		$check=$this->commondatamodel->duplicateValueCheck($table,$where);
		if($check){
			$this->db->where($where)
				->delete($table);
		}	
		$this->db->insert($table, $data);
		// echo $this->db->last_query();exit;
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return False;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function getAcountEditData($id)
	{
		$data=array();
		$where=[
			"account_master.account_id"=>$id
		];
		$query=$this->db->select("*")
						->from('account_master')
						->join('account_opening_master','account_master.account_id=account_opening_master.account_master_id','left')	
						->where($where)	
						->limit(1)				
						->get();
										
		if($query->num_rows()> 0)
		{
	        foreach($query->result() as $rows)
			{
				$data= $rows;
			}
	             
	    }
		return $data;

	}





}/* end of class */

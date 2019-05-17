<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Feespaymentmodel extends CI_Model{

/* component list by class and multiple month*/
	public function getFeesComponentListbyClass($classid,$monthids,$acd_session_id){
		$where = array(
						'fees_session.class_id' =>$classid,
						'fees_session.acdm_session_id' =>$acd_session_id
					);

		$data = [];
		$query = $this->db->select("
									fees_structure.fees_desc,
									fees_structure.id as fees_id,
									SUM(fees_session.amount) AS sum_amount
				")
				->from('fees_session')
				->join('fees_structure','fees_structure.id = fees_session.fees_id','INNER')
				->join('fees_strucrure_month_dtl','fees_strucrure_month_dtl.fees_structure_id = fees_structure.id','INNER')
				->where($where)
				->where_in('fees_strucrure_month_dtl.month_id',$monthids)
				->group_by('fees_structure.fees_desc')
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


/* component list by class and single month*/

	public function getFeesComponentListbyClassMonth($classid,$monthid){
		$where = array(
						'fees_session.class_id' =>$classid,
						'fees_strucrure_month_dtl.month_id' =>$monthid
					);

		$data = [];
		$query = $this->db->select("
									fees_structure.fees_desc,
									fees_session.amount,
									fees_structure.id as fees_comp_id
				")
				->from('fees_session')
				->join('fees_structure','fees_structure.id = fees_session.fees_id','INNER')
				->join('fees_strucrure_month_dtl','fees_strucrure_month_dtl.fees_structure_id = fees_structure.id','INNER')
				->where($where)
				->get();
			#q();
			if($query->num_rows()> 0)
			{
	          foreach($query->result() as $rows)
				{
					$data[] = $rows;
				}
	             
	        }
			
	        return $data;
	       
		
	}


	/* component list sum amount by class and single month*/

	public function getFeesComponentListSumbyClassMonth($classid,$monthid){
		$where = array(
						'fees_session.class_id' =>$classid,
						'fees_strucrure_month_dtl.month_id' =>$monthid
					);

		$data = [];
		$query = $this->db->select("
									fees_structure.fees_desc,
									sum(fees_session.amount) as sum_amount,
									fees_session.id
				")
				->from('fees_session')
				->join('fees_structure','fees_structure.id = fees_session.fees_id','INNER')
				->join('fees_strucrure_month_dtl','fees_strucrure_month_dtl.fees_structure_id = fees_structure.id','INNER')
				->where($where)
				->get();
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



	/*student details by payment id*/

	public function getStudentDetailsByPaymentId($paymentid){
		$session = $this->session->userdata('user_data');
		$where = array(
						'payment_master.payment_id' =>$paymentid,
						'payment_master.acdm_session_id' =>$session['acd_session_id'],
						'payment_master.accnt_year_id' =>$session['accnt_year_id']
						
					);

		$data = [];
		$query = $this->db->select("payment_master.*,									
									class_master.classname,
									academic_details.rollno,
									section_master.section,
									student_master.name AS student_name")
				->from('payment_master')
				->join('class_master','class_master.id = payment_master.class_id','INNER')
				->join('academic_details','academic_details.id = payment_master.academic_dtl_id','INNER')
				->join('section_master','section_master.id = academic_details.section_id','LEFT')
				->join('student_master','student_master.student_id = payment_master.student_id','INNER')
				
				->where($where)
				->limit(1)
				->get();
			// q();
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

	public function getDebitAccountId($paymentId)
	{  
		$data="";
		$where=[
			"payment_voucher_ref.payment_id"=>$paymentId,
			"payment_voucher_ref.voucher_tag"=>"R",
			"voucher_detail.is_debit"=>"Y"
		];
		$query=$this->db->select('voucher_detail.account_master_id,voucher_detail.id')
						->from('payment_voucher_ref')
						->join('voucher_detail','payment_voucher_ref.voucher_id=voucher_detail.voucher_master_id','INNER')
						->where($where)
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
	public function getDebitAccountIdByVoucherId($VoucherId)
	{  
		// $data="";
		$where=[
			"voucher_master.id"=>$VoucherId,			
		];
		$query=$this->db->select('voucher_detail.account_master_id,voucher_detail.id')
						->from('voucher_master')
						->join('voucher_detail','voucher_master.id=voucher_detail.voucher_master_id','INNER')
						->where($where)
						->get();
						
		if($query->num_rows()> 0)
		{
	        foreach($query->result() as $rows)
			{
				return $rows->account_master_id;
			}
	             
	    }
			
	    return "";
	}


	/* get payment component list details for edit*/

	public function getFeesComponentListbyPaymentId($paymentid){
		$where = array(
						'payment_master.payment_id' =>$paymentid
						
					);

		$data = [];
		$query = $this->db->select("
									fees_structure.fees_desc,
									SUM(payment_details.amount) AS sum_amount
				")
				->from('payment_master')
				->join('payment_details','payment_details.payment_master_id=payment_master.payment_id','INNER')
				->join('fees_structure','fees_structure.id=payment_details.fees_component_id','INNER')
				->group_by('fees_structure.fees_desc')
				->where($where)
				->get();
			#q();
			if($query->num_rows()> 0)
			{
	          foreach($query->result() as $rows)
				{
					$data[] = $rows;
				}
	             
	        }
			
	        return $data;
	       
		
	}


		/* get payment month details by payment id for edit*/

	public function getPaymentMonthbyPaymentId($paymentid){
		$where = array(
						'payment_master.payment_id' =>$paymentid
						
					);

		$data = [];
		$query = $this->db->select("
									payment_month_dtl.month_id
				")
				->from('payment_master')
				->join('payment_month_dtl','payment_month_dtl.payment_master_id=payment_master.payment_id','INNER')
				
				->where($where)
				->get();
			#q();
			if($query->num_rows()> 0)
			{
	          foreach($query->result() as $rows)
				{
					$data[] = $rows;
				}
	             
	        }
			
	        return $data;	       
		
	}


	public function getSingleColumnData($column_name,$table,$where)
	{
		$query=$this->db->select($column_name)
						->from($table)
						->where($where)
						->get();
		if ($query->num_rows()>0) {
			foreach($query->result() as $rows)
			{
				$data= $rows->$column_name;
			}	             
		}
		return $data;
	}

	public function getAlreadyPaidMonthList($table,$join_table,$join_on,$where)
	{
		$data = [];
		$this->db->select('*')
				->from($table)
				->join($join_table,$join_on)
				->where($where);

		$query = $this->db->get();
		// $rowcount = $query->num_rows();
	
		if($query->num_rows()>0){
			foreach($query->result() as $rows)
			{
				$data[]= $rows->month_id;
			}
		}
		
		return $data;
	}

	public function getVoucherDataByPaymentId($payment_id)
	{
		$data=array();
		$where=[
			"payment_id"=>$payment_id
		];
		$query=$this->db->select('*')
						->from('payment_voucher_ref')
						->join('voucher_master','payment_voucher_ref.voucher_id=voucher_master.id','INNER')
						->where($where)
						->get();
		if ($query->num_rows()>0) {
			foreach($query->result() as $rows)
			{
				$data[]=array(
                    "id"=>$rows->id,
                    "voucher_ac_detail"=>$this->getVoucherDetailById($rows->id),
                    "voucher_number"=>$rows->voucher_number,
                    "voucher_date"=>$rows->voucher_date,
                    "narration"=>$rows->narration,
                    "cheque_number"=>$rows->cheque_number,
                    "cheque_date"=>$rows->cheque_date,
                    "chq_clear_on"=>$rows->chq_clear_on,
                    "is_chq_clear"=>$rows->is_chq_clear,
                    "transaction_type"=>$rows->transaction_type,
                    "created_by"=>$rows->created_by,
                    "school_id"=>$rows->school_id,
                    "acdm_session_id"=>$rows->acdm_session_id,
                    "serial_number"=>$rows->serial_number,
                    "vouchertype"=>$rows->vouchertype,
                    "paid_to"=>$rows->paid_to,
                    "total_debit"=>$rows->total_debit,					
                    "total_credit"=>$rows->total_credit
                );
			}	             
		}
		return $data;
	}

	public function getDuePaymentDataByPaymentId($payment_id)
	{
		$data=array();
		$where=[
			"payment_id"=>$payment_id,
			"voucher_tag"=>'R',
			"voucher_type"=>'C'
		];
		$query=$this->db->select('*')
						->from('payment_voucher_ref')					
						->where($where)
						->get();
		if ($query->num_rows()>0) {
			foreach($query->result() as $rows)
			{
				$data[]=array(
                    "id"=>$rows->id,
                    "voucher_ac_detail"=>$this->getVoucherDetailById($rows->voucher_id),
                    "payment_id"=>$rows->payment_id,
                    "voucher_id"=>$rows->voucher_id,
                    "voucher_no"=>$this->getVoucherDataByID($rows->voucher_id,'voucher_number'),
                    "voucher_date"=>$this->getVoucherDataByID($rows->voucher_id,'voucher_date'),
                    "voucher_tag"=>$rows->voucher_tag,
                    "payment_mode"=>$rows->payment_mode,
                    "paid_amount"=>$rows->paid_amount,
                    "cheque_no"=>$rows->cheque_no,
                    "cheque_date"=>$rows->cheque_date,
                    "bank_name"=>$rows->bank_name,
                    "branch_name"=>$rows->branch_name,
                    "narration"=>$rows->narration,
                    "voucher_type"=>$rows->voucher_type,                    
                );
			}	             
		}
		return $data;
	}

	public function getVoucherDataByID($id,$field_Name)
	{
		
		$where=['id'=>$id];
		$query=$this->db->select($field_Name)
				->from('voucher_master')
				->where($where)
				->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				return $rows->$field_Name;
            }
        }else{
             return 0;
         }
	}

	public function getSumOfPaidAmount($payment_id)
	{
		$where=[
			'payment_id'=>$payment_id,
			"voucher_type"=>"C",
			"voucher_tag"=>"R"
		];
		$query=$this->db->select("SUM(paid_amount) AS total_C_amnt")
				->from('payment_voucher_ref')
				->where($where)
				->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				return $rows->total_C_amnt;
            }
        }else{
             return 0;
         }
	}

	public function getVoucherDetailById($id)
	{
        $where=[
            "voucher_detail.voucher_master_id"=>$id
        ];
		$data = array();
		$this->db->select("voucher_detail.*,account_master.* ")
                ->from('voucher_detail')
                ->join('account_master','voucher_detail.account_master_id=account_master.account_id','LEFT')
				->where($where);
		$query = $this->db->get();
		#echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data[] = $rows;
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
    }

	public function getVoucherPaymentRefData($fieldName,$id)
	{
		$where=[
            "payment_voucher_ref.".$fieldName=>$id
        ];
		$data = array();
		$this->db->select("*")
                ->from('payment_voucher_ref')               
				->where($where);
		$query = $this->db->get();
		#echo $this->db->last_query();

		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				$data=array(
                    "id"=>$rows->id,
                    // "voucher_ac_detail"=>$this->getVoucherDetailById($rows->voucher_id),
                    "payment_id"=>$rows->payment_id,
                    "voucher_id"=>$rows->voucher_id,
                    // "voucher_no"=>$this->getVoucherDataByID($rows->voucher_id,'voucher_number'),
                    "voucher_date"=>$this->getVoucherDataByID($rows->voucher_id,'voucher_date'),
                    "voucher_tag"=>$rows->voucher_tag,
                    "payment_mode"=>$rows->payment_mode,
                    "paid_amount"=>$rows->paid_amount,
                    "cheque_no"=>$rows->cheque_no,
                    "cheque_date"=>$rows->cheque_date,
                    "bank_name"=>$rows->bank_name,
                    "branch_name"=>$rows->branch_name,
                    "narration"=>$rows->narration,
                    "voucher_type"=>$rows->voucher_type,                    
                );
            }
            return $data;
             
        }
		else
		{
             return $data;
         }
	}

	public function getStudentAccountIdByPaymentId($payment_id)
	{
		$where=[
			'payment_master.payment_id'=>$payment_id,
		];
		$query=$this->db->select("student_master.account_id")
				->from('payment_master')
				->join('student_master',' payment_master.student_id=student_master.student_id','INNER')
				->where($where)
				->get();
		if($query->num_rows()> 0)
		{
            foreach ($query->result() as $rows)
			{
				return $rows->account_id;
            }
        }else{
             return 0;
         }
	}


	public function getStudentListbyAcademicSessionAndSchoolId($where){	
		$data = [];		
		$query = $this->db->select("student_master.*,academic_details.rollno")
						->from('student_master')				
						->join('academic_details','academic_details.student_id = student_master.student_id','INNER')				
						->where($where)
						->order_by('student_master.name')
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

	public function getVoucherIdByPaymentId($payment_id,$prefix)
	{
		$query = $this->db->select("*")
						->from('payment_voucher_ref')	
						->where(array('payment_id'=>$payment_id,"voucher_tag"=>$prefix,'voucher_type'=>'P'))
						->get();
			
			if($query->num_rows()> 0)
			{
	          foreach($query->result() as $rows)
				{
					return $rows->voucher_id;
				}
	             
	        }else {
				return "";
			}
			
	         
	}
	
} //end of class
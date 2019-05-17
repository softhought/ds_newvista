<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Generalvouchermodel extends CI_Model{


    public function getGroupNameByAccId($account_id,$school_id)
    {
        $where=[
            "account_id"=>$account_id,
            "school_id"=>$school_id
        ];
        $query=$this->db->select('*')
                        ->from('account_master')
                        ->join('group_master','account_master.group_id=group_master.id','INNER')
                        ->where($where)
                        ->get();
        if($query->num_rows() > 0){
            foreach($query->result() as $rows){
                return $rows->group_description;
            }
        }else{
            return "";
        } 
    }

    public function getGeneralVoucherDetailData($voucherMaterId){
               
        $where=[
            "voucher_master.id"=>$voucherMaterId,
            "voucher_detail.is_master"=>'N'
        ];
        $data=array();


        $query=$this->db->select('voucher_master.id AS voucherMastId,voucher_detail.id AS VoucherDtlId,voucher_detail.is_debit,account_master.account_name, account_master.account_id AS accountId,voucher_detail.voucher_amount')
                        ->from('voucher_detail')
                        ->join('voucher_master','voucher_detail.voucher_master_id=voucher_master.id','INNER')
                        ->join('account_master','voucher_detail.account_master_id=account_master.account_id','INNER')
                        ->where($where)
                        ->get();
        
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data[] = array(
                    "voucherMastId"=>$rows->voucherMastId,
                    "VoucherDtlId"=>$rows->VoucherDtlId,
                    "is_debit"=>$rows->is_debit,
                    "account_name"=>$rows->account_name,                    
                    "accountId"=>$rows->accountId,
                    "VouchrDtlAmt"=>$rows->voucher_amount,
                   // "TotalDebit"=>$this->getTotalDebitedAmount($rows->voucherMastId)
                    
                );
            }


            return $data;
        } else {
            return $data;
        }
    }

    public function getAllGeneralVoucherList($school_id,$acd_session_id,$accnt_year_id)
    {
        $where=[
            "school_id"=>$school_id,
            "acdm_session_id"=>$acd_session_id,
            "accnt_year_id"=>$accnt_year_id,
            // "vouchertype"=>'GV'
            "transaction_type"=>'RC'
        ];
        $data = array();
        $query=$this->db->select('*')
                    ->from('voucher_master')
                    ->where($where)
                    ->order_by('id')
                    ->get();
        if($query->num_rows()> 0)
        {
            foreach ($query->result() as $rows)
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
                    "accnt_year_id"=>$rows->accnt_year_id,
                    "serial_number"=>$rows->serial_number,                    
                    "is_frm_receipt"=>$rows->is_frm_receipt,                    
                    "vouchertype"=>$rows->vouchertype,
                    "paid_to"=>$rows->paid_to,
                    "total_debit"=>$rows->total_debit,					
                    "total_credit"=>$rows->total_credit
                );
            }
            return $data;
        }else{
            return $data;
        }
    }

    public function getVoucherDetailById($id)
	{
        $where=[
            "voucher_detail.voucher_master_id="=>$id
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


    public function getGeneralVoucherMasterData($voucherMaterId,$school_id){        
            $where=[
                "voucher_master.id"=>$voucherMaterId,
                "voucher_master.school_id"=>$school_id,
                "voucher_detail.is_master"=>'Y'
            ];
            $data="";
            $query=$this->db->select("voucher_master.voucher_number,DATE_FORMAT(voucher_master.voucher_date,'%m/%d/%Y') AS VoucherDate,voucher_master.vouchertype,voucher_master.transaction_type,voucher_master.paid_to,voucher_master.cheque_number,DATE_FORMAT(voucher_master.cheque_date,'%m/%d/%Y') AS checqueDate,voucher_master.narration,voucher_master.serial_number,voucher_detail.voucher_amount,account_master.account_id AS accountId,account_master.account_name,voucher_master.total_credit,voucher_master.total_debit")
                            ->from('voucher_detail')
                            ->join('voucher_master','voucher_detail.voucher_master_id=voucher_master.id','INNER')
                            ->join('account_master','voucher_detail.account_master_id=account_master.account_id','INNER')
                            ->where($where)
                            ->get(); 
                            // q();           
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $rows) {
                $data = array(
                    "voucher_number"=>$rows->voucher_number,
                    "voucher_date"=>$rows->VoucherDate,
                    "vouchertype"=>$rows->vouchertype,
                    "transaction_type"=>$rows->transaction_type,
                    "paid_to"=>$rows->paid_to,
                    "cheque_number"=>$rows->cheque_number,
                    "cheque_date"=>$rows->checqueDate,
                    "narration"=>$rows->narration,
                    "serial_number"=>$rows->serial_number,
                    "voucher_amount"=>$rows->voucher_amount,
                    "accountId"=>$rows->accountId,
                    "account_name"=>$rows->account_name,
                    "total_debit"=>$rows->total_debit,
                    "total_credit"=>$rows->total_credit,
                    "groupname"=>$this->getGroupNameByAccId($rows->accountId,$school_id)
                 );
            }


            return $data;
        } else {
            return $data;
        }
    }    





} //end of class
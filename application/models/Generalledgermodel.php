<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Generalledgermodel extends CI_Model{

    public function getFiscalStartDt($yearid){
        // echo $yearid;exit;
        $sql="SELECT start_date FROM `accounting_year_master` WHERE id=".$yearid;
        $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    return $rows->start_date;
                }
         }
        
    }

    public function getAccountingPeriod($yearid){
        $data = array();
        $sql="SELECT * FROM `accounting_year_master` WHERE id=".$yearid;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    $data=[
                        "start_date"=>$rows->start_date,
                        "end_date"=>$rows->end_date
                    ];
                }
                return $data;
        }else{
            return $data;
        }
        
    }


     /*
  *getGeneralLedgerReportType3
  *03-04-2018
  *Multiple debit and multiple credit
  */
   public function getGeneralLedgerReportType3($frmDate,$toDate,$companyId,$yearid,$accId,$fiscalStartDt)
   {
       $data = [];
       $call_procedure = "CALL usp_generalLedgerStyle3('".$frmDate."','".$toDate."',"."$companyId,$yearid,$accId,'".$fiscalStartDt."')";
       $query =$this->db->query($call_procedure);
       if($query->num_rows()>0){
           foreach ($query->result() as $rows) {
           $data[] = [
              "vchId"=>$rows->vchId,
              "vchNumber"=>$rows->vchNumber,
              "debitamount"=>$rows->debitamount,
              "creditamount"=>$rows->creditamount,
              "isdebit"=>$rows->isdebit,
              "Naration"=>$rows->Naration,
              "VchType"=>$rows->VchType,
              "VchDate"=>$rows->VchDate,
              "VchAccountDetailscrdrtag"=>$rows->VchAccountDetailscrdrtag,
              "VchAccountDetailsAccountName"=>$rows->VchAccountDetailsAccountName,
              "VchAccountDetailsAmount"=>$rows->VchAccountDetailsAmount

           ];
       }
       }
       return $data;
   }

   public function getCompanyNameById($id) {        
    $query = $this->db->select('school_name')
                  ->from('school_master')
                  ->where('id',$id)
                  ->get();
    $row = $query->row();
    return $row->school_name;
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->school_name;
    }else{
        return '';
    }
}

public function getCompanyAddressById($id = '') {
$query = $this->db->select('address')
                  ->from('school_master')
                  ->where('id',$id)
                  ->get();
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return $row->address;
    }else{
        return '';
    }
}

public function getAccountnameById($accId){
    $data = array();
   $sql = "SELECT * FROM account_master WHERE account_master.account_id=".$accId;
   $query = $this->db->query($sql);
   
  if ($query->num_rows() > 0) {
           foreach ($query->result() as $rows) {
               return $rows->account_name;
           }
    }
    
}












} //end of class
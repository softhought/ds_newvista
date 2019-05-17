<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Trialbalancemodel extends CI_Model{

    public function getFiscalStartDt($yearid){
        $sql="SELECT start_date FROM `accounting_year_master` WHERE id=".$yearid;
        $query = $this->db->query($sql);
         if ($query->num_rows() > 0) {
                foreach ($query->result() as $rows) {
                    return $rows->start_date;
                }
         }
        
    }

    public function getTrialBalanceData($compny,$year,$frmDate,$toDate,$fiscalSdt){
     
      
        $data = array();
        $call_procedure = "CALL usp_TrialBalance($compny,$year,"."'".$frmDate."'".","."'".$toDate."'".","."'".$fiscalSdt."'".")";
        
    //   echo $call_procedure;
    //     exit;
        
      //  $call_procedure = "CALL usp_TrialBalance(1,6,'2016-04-01','2017-03-31','2016-04-01')";
         $query = $this->db->query($call_procedure);
           if ($query->num_rows() > 0) {
           foreach ($query->result() as $rows) {
                $data[] = array(
                  /*    "totalDebit"=>$rows->_totalDebit,
                      "totalCredit"=>$rows->_totalCredit,
                      "AccountName"=>$rows->_AccountName */
                    
                    "account"=>$rows->Account,
                    "opening"=> $rows->Opening,
                    "debit"=>$rows->Debit,
                    "credit"=>$rows->Credit,
                    "closingDebit"=>$rows->closingDebit,
                    "closingCredit"=>$rows->closingCredit
                    );
              
               
           }
        
           return $data;
       } 
       
       else {
           return $data;
       }
       
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

}/* end of class */
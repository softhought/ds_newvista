<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendormodel extends CI_Model
{

    public function updateMultiTableData_WithUserActivity($UpdatetblnameArry,$UpdateArray,$upd_whereArr,$insertArray,$inserttable){
		try{
            $this->db->trans_begin();
			
			for($i=0;$i<sizeof($UpdateArray);$i++)
			{
                $this->db->where($upd_whereArr[$i]);
                $this->db->update($UpdatetblnameArry[$i], $UpdateArray[$i]);
               	// echo($this->db->last_query());	 
            }
            
            $this->db->insert($inserttable, $insertArray);
			if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return false;
            } else {
                $this->db->trans_commit();
                return true;
            }
        }
		catch (Exception $err) {
            echo $err->getTraceAsString();
        }
    }
    
 


    
}/* end of classs */

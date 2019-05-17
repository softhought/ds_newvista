<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Closingblancetransfermodel extends CI_Model{

    public function getCurrentYear($currentYearId) {
        $data = array();
        $sql = "SELECT `accounting_year_master`.`period`,`accounting_year_master`.`id` ,accounting_year_master.end_date,accounting_year_master.start_date  FROM `accounting_year_master` 
                WHERE `accounting_year_master`.`id`=" . $currentYearId;
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $data = array(
                "period" => $row->period,
                "currentyearid" => $row->id,
                "end_date" => $row->end_date,
                "start_date" => $row->start_date,
                "next_year" => $this->nextAccountingYear($row->id, $row->end_date),
            );
        }
        return $data;
    }

    public function nextAccountingYear($id, $lastdate) {
        $nextyeardate = date('Y-m-d', strtotime('+1 day', strtotime($lastdate)));
        $sql = " SELECT `accounting_year_master`.`period`,`accounting_year_master`.`id`,DATE_FORMAT(`accounting_year_master`.`end_date`,'%d-%m-%Y') AS end_date FROM 
            `accounting_year_master`  WHERE `accounting_year_master`.`start_date`='" . $nextyeardate . "'";
        $nextyear = "";
        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            $nextyear = array("nextPeriod" => $row->period, "nextId" => $row->id);
        }
        return $nextyear;
    }

    public function transferclosingbalance($school_id,$fromyearid,$toyearid,$fromdate,$todate,$fiscalsatrtdate,$acd_session_id) {
        $data = array();
        try {

            $call_procedure = "CALL sp_closingbalancetransfer($school_id,$toyearid,$fromyearid," . "'" . $fromdate . "'" . "," . "'" . $todate . "'" . "," . "'" . $fiscalsatrtdate . "',$acd_session_id)";
            $query = $this->db->simple_query($call_procedure);
            if ($query) {
                $sql = "select `account_master`.`account_name`,`account_opening_master`.`opening_balance` 
                        FROM `account_master` 
                        LEFT JOIN `account_opening_master`  ON `account_master`.`account_id` = `account_opening_master`.`account_master_id`
                        WHERE `account_opening_master`.`school_id`=" . $school_id . 
                        " AND `account_opening_master`.`accnt_year_id`=" . $toyearid . " ORDER BY `account_master`.`account_name`";

                $query = $this->db->query($sql);
                if ($query->num_rows() > 0) {
                    foreach ($query->result() as $rows) {
                        $data[] = array(
                            "account_name" => $rows->account_name,
                            "opening_balance" => $rows->opening_balance
                        );
                    }
                    return $data;
                }
            } else {
                return $data;
            }
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }


} //end of class
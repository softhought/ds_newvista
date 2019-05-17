<?php


if(!function_exists('pre'))
{
	
	function pre($printarry){
		$CI =& get_instance();
		echo "<pre>";
		print_r($printarry);
		echo "</pre>";
	}
}

if(!function_exists('q'))
{
	
	function q(){
		$CI =& get_instance();
        $CI->load->database();
        echo $CI->db->last_query();
	}
}

if(!function_exists('date_ymd'))
{
	//added by sandipan sarkar on 25.02.2019
	function date_ymd($date)
	{
		$dateEx = explode('/',$date);
            $month  = $dateEx[0];
            $day  = $dateEx[1];
			$year  = $dateEx[2];
			$stringDate = $day."-".$month."-".$year;
			$formated_date = date("Y-m-d",strtotime($stringDate));
			return $formated_date;
	}
}

if(!function_exists('date_dmy_to_ymd'))
{
	//added by sandipan sarkar on 25.02.2019
	function date_dmy_to_ymd($date)
	{
		$dateEx = explode('/',$date);
            $month  = $dateEx[1];
            $day  = $dateEx[0];
			$year  = $dateEx[2];
			$stringDate = $day."-".$month."-".$year;
			$formated_date = date("Y-m-d",strtotime($stringDate));
			return $formated_date;
	}
}

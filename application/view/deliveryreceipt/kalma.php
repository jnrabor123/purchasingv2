<?php


$array = array_date("2019/01");

echo json_encode($array);

function array_date($date)
{
	// $date = '2019/01';	

	$day = explode("/",$date)[1]; 
	$year = explode("/",$date)[0];
	$dayspermonth = cal_days_in_month(CAL_GREGORIAN,$day,$year);

	$arraydate_temp = array();
	$arraydate = array();
	$array = array();

	for($a = 0; $a < $dayspermonth; $a++)
	{
		($a < 9) ? $myDate = $date . "/0" . ($a + 1) : $myDate = $date . "/" . ($a + 1);

		// echo $myDate . "<br/>";

		$dayname = date("l", strtotime($myDate));
		// echo $dayname . "<br/>";
		array_push($arraydate_temp, $myDate);

		if($dayname == "Saturday")
		{	

			$reset = reset($arraydate_temp);
			$end = end($arraydate_temp);

			array_push($arraydate, $reset . '-' . $end);
			$arraydate_temp = $array;
		}

		// LAST WEEK
		if($a == ($dayspermonth - 1))
		{
			$reset = reset($arraydate_temp);
			$end = end($arraydate_temp);

			array_push($arraydate, $reset . '-' . $end);
			$arraydate_temp = $array;
		}


	}

	// echo json_encode($arraydate);
	return $arraydate;
}
	


?>
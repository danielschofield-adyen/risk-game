<?php

	$host       = "ec2-54-220-86-118.eu-west-1.compute.amazonaws.com";
	$dbname     = "dff58ne6abfhe2";
	$user       = "jbwrbjykvuahhh";
	$password   = "7d249d82e458cb41f9ff393d72ce1b304353ad833a7effce16ae52e3bac5bbd3";
	$port       = "5432";
	
	$conn_string = "host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$password."";
	$db = pg_connect($conn_string);
	
	if(!$db) {
		//echo "Error : Unable to open database\n";
		return;
		} else {
		//echo "Opened database successfully\n";
		$select_query = "SELECT psp_reference,shopper_reference,fraud_score,result_code FROM leaderboard LIMIT 1";
		$result = pg_query($db,$select_query);
		$html = '';

        return $result;

		while($data = pg_fetch_array($result)) {
	
			$html .= '<tr>';
			$html .= '	<td>'.$data['psp_reference'].'</td>';
			$html .= '	<td>'.$data['shopper_reference'].'</td>';
			$html .= '	<td>'.$data['fraud_score'].'</td>';
			$html .= '	<td>'.$data['result_code'].'</td>';
			$html .= '</tr>';
		}
	}
?>
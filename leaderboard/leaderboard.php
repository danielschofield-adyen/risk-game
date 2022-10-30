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
		
		//TRANSACTION LIST
		$select_query = "SELECT psp_reference,shopper_reference,fraud_score,result_code FROM leaderboard ORDER BY creation_date DESC LIMIT 20";
		$result = pg_query($db,$select_query);
		$html = '';

		while ($data = pg_fetch_array($result)) {
	
			$html .= '<tr>';
			$html .= '	<td>'.$data['psp_reference'].'</td>';
			$html .= '	<td>'.$data['shopper_reference'].'</td>';
			$html .= '	<td>'.$data['fraud_score'].'</td>';
			$html .= '	<td>'.($data['result_code']=="Refused" ? "拒否" : "承認").'</td>';
			$html .= '</tr>';
		}

		//TOP 3 PERFORMERS
		$select_query = "SELECT shopper_reference, count(psp_reference) FROM leaderboard WHERE CAST (fraud_score AS INTEGER) < 100 GROUP BY shopper_reference ORDER BY count(psp_reference) DESC LIMIT 3";
		$result = pg_query($db,$select_query);
		$html2 = '';

		while ($data = pg_fetch_array($result)) {
	
			$html2 .= '<div class="col-sm-4">';
			$html2 .= '<div class="leaderboard-card">';
			$html2 .= '<div class="leaderboard-card__top" style="background-color:#00112C; color:#0ABF53">';
			$html2 .= '<h3 class="text-center">スコア = '.$data['count'].'</h3>';
			$html2 .= '</div>';
			$html2 .= '<div class="leaderboard-card__body">';
			$html2 .= '<div class="text-center">';
			$html2 .= '<img src="img/user.png" class="circle-img mb-2" alt="User Img">';
			$html2 .= '<h5 class="mb-0">'.$data['shopper_reference'].'</h5>';
			$html2 .= '</div>';
			$html2 .= '</div>';
			$html2 .= '</div>';
			$html2 .= '</div>';
		}


	}

	//every minute
	//run x code to do above function ^
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Leaderboard</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">	
<script>
window.setTimeout( function() {
	window.location.reload();
}, 5000);
</script>

</head>
<body>
	<br/>

	<div class="container">
		<h1><!--Top performances-->ベストスコア</h1>
		<br/>
		<div class="row">
			<?php echo $html2;?>
		</div>

		<table class="table">
		<thead>
			<tr>
				<th><!--PSP Reference-->取引番号</th>
				<th><!--Shopper Reference-->名前</th>
				<th><!--Fraud Score-->不正利用スコア</th>
				<th><!--Result Code-->結果コード</th>
			</tr>
		</thead>
		<tbody>
			<?php echo $html;?>
		</tbody>
		</table>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
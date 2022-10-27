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
		$select_query = "SELECT psp_reference,shopper_reference,fraud_score,result_code FROM leaderboard LIMIT 20";
		$result = pg_query($db,$select_query);
		$html = '';

		while($data = pg_fetch_array($result)) {
	
			$html .= '<tr>';
			$html .= '	<td>'.$data['psp_reference'].'</td>';
			$html .= '	<td>'.$data['shopper_reference'].'</td>';
			$html .= '	<td>'.$data['fraud_score'].'</td>';
			$html .= '	<td>'.$data['result_code'].'</td>';
			$html .= '</tr>';
		}
	}

	//every minute
	//run x code to do above function ^
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Leaderboard UI Design</title>
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">	
</head>
<body>
	<section class="main-content">
		<div class="container">
			<h1>Top Gainers</h1>
			<br>
			<br>

			<div class="row">
				<div class="col-sm-4">
					<div class="leaderboard-card">
						<div class="leaderboard-card__top">
							<h3 class="text-center">$1,051</h3>
						</div>
						<div class="leaderboard-card__body">
							<div class="text-center">
								<img src="img/user2.jpg" class="circle-img mb-2" alt="User Img">
								<h5 class="mb-0">Sandeep Sandy</h5>
								<p class="text-muted mb-0">@sandeep</p>
								<hr>
								<div class="d-flex justify-content-between align-items-center">
									<span><i class="fa fa-map-marker"></i> Bangalore</span>
									<button class="btn btn-outline-success btn-sm">Congratulate</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="leaderboard-card leaderboard-card--first">
						<div class="leaderboard-card__top">
							<h3 class="text-center">$1,254</h3>
						</div>
						<div class="leaderboard-card__body">
							<div class="text-center">
								<img src="img/user1.jpg" class="circle-img mb-2" alt="User Img">
								<h5 class="mb-0">Kiran Acharya</h5>
								<p class="text-muted mb-0">@kiranacharyaa</p>
								<hr>
								<div class="d-flex justify-content-between align-items-center">
									<span><i class="fa fa-map-marker"></i> Bangalore</span>
									<button class="btn btn-outline-success btn-sm">Congratulate</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="leaderboard-card">
						<div class="leaderboard-card__top">
							<h3 class="text-center">$1,012</h3>
						</div>
						<div class="leaderboard-card__body">
							<div class="text-center">
								<img src="img/user3.jpg" class="circle-img mb-2" alt="User Img">
								<h5 class="mb-0">John doe</h5>
								<p class="text-muted mb-0">@johndoe</p>
								<hr>
								<div class="d-flex justify-content-between align-items-center">
									<span><i class="fa fa-map-marker"></i> Bangalore</span>
									<button class="btn btn-outline-success btn-sm">Congratulate</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>


			<h4>All Users</h4>

			<table class="table">
				<thead>
					<tr>
						<th>PSP Reference</th>
						<th>Shopper Reference</th>
						<th>Fraud Score</th>
						<th>Result Code</th>
					</tr>
				</thead>
				<tbody>
				<?php echo $html;?>
					<!--<tr>
						<td>PSP Reference</td>
						<td>Shopper Reference</td>
						<td>Fraud Score</td>
						<td>Result Code</td>
					</tr>-->
					<!--
					<tr>
						<td>
							<div class="d-flex align-items-center">
								<img src="img/user5.jpg" class="circle-img circle-img--small mr-2" alt="User Img">
								<div class="user-info__basic">
									<h5 class="mb-0">Tom harry</h5>
									<p class="text-muted mb-0">@tomharry</p>
								</div>
							</div>
						</td>
						<td>
							<div class="d-flex align-items-baseline">
								<h4 class="mr-1">$951</h4><small class="text-success"><i class="fa fa-arrow-up"></i>5%</small>
							</div>
						</td>
						<td>Bangalore</td>
						<td>kiran@kiranmail.com</td>
						<td>
							<button class="btn btn-success btn-sm">Congratulate</button>
						</td>
					</tr>
				-->
				</tbody>
			</table>
		</div>
	</section>
	
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>
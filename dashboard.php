<?php include 'server/server.php' ?>
<?php

$query = "SELECT * FROM tbl_employee WHERE `status`!=3";
$result = $conn->query($query);
$total = $result->num_rows;

$query1 = "SELECT * FROM tbl_employee WHERE gender='Male' AND `status`!=3";
$result1 = $conn->query($query1);
$male = $result1->num_rows;

$query2 = "SELECT * FROM tbl_employee WHERE gender='Female' AND `status`!=3";
$result2 = $conn->query($query2);
$female = $result2->num_rows;

$query3 = "SELECT * FROM tbl_users";
$result3 = $conn->query($query3);
$users = $result3->num_rows;

$query4 = "SELECT * FROM tbl_teams";
$result4 = $conn->query($query4);
$teams = $result4->num_rows;

$query5 = "SELECT * FROM tbl_employee WHERE sports IS NOT NULL AND `status`!=3";
$result5 = $conn->query($query5);
$has_sports = $result5->num_rows;

$query6 = "SELECT * FROM tbl_employee WHERE sports IS NULL AND `status`!=3";
$result6 = $conn->query($query6);
$no_sports = $result6->num_rows;


$Leave = "On-Leave";
$Normal = "Fit";
$Health = "Unfit";

$OfficialTime ="On Official Time";
$OfficialBusiness ="On Official Business";

$query7 = "SELECT * FROM tbl_employee WHERE stat = '$Leave'  AND `status`!=3";
$result7 = $conn->query($query7);
$Leave = $result7->num_rows;

$query8 = "SELECT * FROM tbl_employee WHERE stat = '$Normal'  AND `status`!=3";
$result8 = $conn->query($query8);
$Normal = $result8->num_rows;

$query9 = "SELECT * FROM tbl_employee WHERE  stat = '$Health'  AND `status`!=3";
$result9 = $conn->query($query9);
$Health = $result9->num_rows;

$query9 = "SELECT * FROM tbl_sports WHERE type IS NULL  ";
$result9 = $conn->query($query9);
$sports = $result9->num_rows;

$query10  = "SELECT * FROM tbl_employee WHERE stat = '$OfficialTime'  AND `status`!=3 ";
$result10 = $conn->query($query10 );
$OfficialTime = $result10->num_rows;

$query11  = "SELECT * FROM tbl_employee WHERE stat = '$OfficialBusiness'  AND `status`!=3 ";
$result11 = $conn->query($query11 );
$OfficialBusiness = $result11->num_rows;

// $query12  = "SELECT * FROM tbl_employee WHERE stat = '$OfficialBusiness'  AND `status`!=3 ";
// $result12 = $conn->query($query12 );
// $OfficialBusiness = $result12->num_rows;

$Pwd = "PWD";
$Fever = "Fever";
$Asthma = "Asthma";
$Allergies = "Allergies";
$HeartDisease = "Heart Disease";
$CardiovascularDisease = "Cardiovascular Disease";
$Cancer = "Cancer";
$Diabetes = "Diabetes";
$Hypertension = "Hypertension";
$Injuries = "Injuries";
$Stroke = "Stroke";
$Pregnant = "Pregnant";


$query12 = "SELECT * FROM tbl_employee WHERE stat = '$Pwd'  AND `status`!=3";
$result12 = $conn->query($query12);
$Pwd = $result12->num_rows;

$query13 = "SELECT * FROM tbl_employee WHERE stat = '$Fever'  AND `status`!=3";
$result13 = $conn->query($query13);
$Fever = $result13->num_rows;

$query14 = "SELECT * FROM tbl_employee WHERE stat = '$Asthma'  AND `status`!=3";
$result14 = $conn->query($query14);
$Asthma = $result14->num_rows;

$query15 = "SELECT * FROM tbl_employee WHERE stat = '$Allergies'  AND `status`!=3";
$result15 = $conn->query($query15);
$Allergies = $result15->num_rows;

$query16 = "SELECT * FROM tbl_employee WHERE stat = '$HeartDisease'  AND `status`!=3";
$result16 = $conn->query($query16);
$HeartDisease = $result16->num_rows;

$query17 = "SELECT * FROM tbl_employee WHERE stat = '$CardiovascularDisease'  AND `status`!=3";
$result17 = $conn->query($query17);
$CardiovascularDisease = $result17->num_rows;

$query18 = "SELECT * FROM tbl_employee WHERE stat = '$Cancer'  AND `status`!=3";
$result18 = $conn->query($query18);
$Cancer = $result18->num_rows;

$query19 = "SELECT * FROM tbl_employee WHERE stat = '$Diabetes'  AND `status`!=3";
$result19 = $conn->query($query19);
$Diabetes = $result19->num_rows;

$query20 = "SELECT * FROM tbl_employee WHERE stat = '$Hypertension'  AND `status`!=3";
$result20 = $conn->query($query20);
$Hypertension = $result20->num_rows;

$query21 = "SELECT * FROM tbl_employee WHERE stat = '$Injuries'  AND `status`!=3";
$result21 = $conn->query($query21);
$Injuries = $result21->num_rows;

$query22 = "SELECT * FROM tbl_employee WHERE stat = '$Stroke'  AND `status`!=3";
$result22 = $conn->query($query22);
$Stroke = $result22->num_rows;

$query23 = "SELECT * FROM tbl_employee WHERE stat = '$Pregnant'  AND `status`!=3";
$result23 = $conn->query($query23);
$Pregnant = $result23->num_rows;


$query24 = "SELECT * FROM tbl_employee WHERE `status`!=3";
$result24 = $conn->query($query24);
$total = $result24->num_rows;




// // for team leader
// $team = $_SESSION['team_assigned'];
// $gender = isset($_POST['gender']);
// $query7 = "SELECT * FROM tbl_employee WHERE team='$team' AND `status`!=3";
// $query8 = "SELECT * FROM tbl_employee WHERE gender='Male' AND team='$team' AND `status`!=3";
// $query9 = "SELECT * FROM tbl_employee WHERE gender='Female' AND team='$team' AND `status`!=3";
// $query10 = "SELECT * FROM tbl_employee WHERE team='$team' AND sports IS NOT NULL AND `status`!=3";
// $query11 = "SELECT * FROM tbl_employee WHERE team='$team' AND sports='None' AND `status`!=3";

// // members
// $result7 = $conn->query($query7);
// $total_members = $result7->num_rows;

// // male
// $result8 = $conn->query($query8);
// $total_male = $result8->num_rows;

// // female
// $result9 = $conn->query($query9);
// $total_female = $result9->num_rows;

// // has sports
// $result10 = $conn->query($query10);
// $total_has_sports = $result10->num_rows;

// // no sports
// $result11 = $conn->query($query11);
// $total_no_sports = $result11->num_rows;

// ?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'templates/header.php' ?>
	<title>Dashboard - Team Management System</title>
	<style>
      /* Define the initial scale for cards */
	  .card-stats {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0); /* Initial box-shadow */
        }

        /* Apply the scaling effect and glowing effect when hovering over the card */
        .card-stats:hover {
            transform: scale(1.05);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5); /* Adjust glow effect as needed */
        }

        /* Apply the scaling effect and glowing effect when the card is clicked */
        .card-stats:active {
            transform: scale(1.1);
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.8); /* Intensify glow effect as needed */
        }
		/* Define the glow effect for the doughnut charts */
        .chart-container {
            position: relative;
            overflow: hidden;
        }

       
    </style>
</head>

<body>
	<?php include 'templates/loading_screen.php' ?>

	<div class="wrapper">
		<!-- Main Header -->
		<?php include 'templates/main-header.php' ?>
		<!-- End Main Header -->

		<!-- Sidebar -->
		<?php include 'templates/sidebar.php' ?>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white fw-bold">Dashboard</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner mt--2">
					<?php if (isset($_SESSION['message'])) : ?>
						<div class="alert alert-<?= $_SESSION['success']; ?> <?= $_SESSION['success'] == 'danger' ? 'bg-danger text-light' : null ?>" role="alert">
							<?php echo $_SESSION['message']; ?>
						</div>
						<?php unset($_SESSION['message']); ?>
					<?php endif ?>
					<div class="row">
						<!-- <div class="col-md-4">
							<div class="card card-stats card-success card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-3">
											<div class="icon-big text-center">
												<i class="fa fa-users"></i>
											</div>
										</div>
										<div class="col-3 col-stats">
										</div>
										<div class="col-6 col-stats">
											<div class="numbers mt-4">
												<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
													<h2 class="fw-bold text-uppercase">Employees</h2>
													<h1 class="fw-bold text-uppercase"><?= number_format($total) ?></h1>

												<?php else : ?>
													<h2 class="fw-bold text-uppercase">Members</h2>
													<h1 class="fw-bold text-uppercase"><?= number_format($total_members) ?></h1>
												<?php endif ?>

											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<a href="resident_info.php?state=all" class="card-link text-light">Total Employees </a>
								</div>
							</div>
						</div> -->
						<!-- <div class="col-md-4">
							<div class="card card-stats card-primary card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-3">
											<div class="icon-big text-center">
												<i class="fa fa-male"></i><i class="fa fa-mars"></i>
											</div>
										</div>
										<div class="col-3 col-stats">
										</div>
										<div class="col-6 col-stats">
											<div class="numbers mt-4">
												<h2 class="fw-bold text-uppercase">Male</h2>
												<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
													<h1 class="fw-bold"><?= number_format($male) ?></h1>
												<?php else : ?>
													<h1 class="fw-bold"><?= number_format($total_male) ?></h1>
												<?php endif ?>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<a href="resident_info.php?state=male" class="card-link text-light">Total Male </a>
								</div>
							</div>
						</div> -->
						<!-- <div class="col-md-4">
							<div class="card card-stats card-danger card-round">
								<div class="card-body">
									<div class="row">
										<div class="col-3">
											<div class="icon-big text-center">
												<i class="fa fa-female"></i><i class="fa fa-venus"></i>
											</div>
										</div>
										<div class="col-3 col-stats">
										</div>
										<div class="col-6 col-stats">
											<div class="numbers mt-4">
												<h2 class="fw-bold text-uppercase">Female</h2>
												<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
													<h1 class="fw-bold"><?= number_format($female) ?></h1>
												<?php else : ?>
													<h1 class="fw-bold"><?= number_format($total_female) ?></h1>
												<?php endif ?>
											</div>
										</div>
									</div>
								</div>
								<div class="card-body">
									<a href="resident_info.php?state=female" class="card-link text-light">Total Female </a>
								</div>
							</div>
						</div> -->
					</div>

					<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'team leader') : ?>
						<div class="row">
							<div class="col-md-4">
								<div class="card card-stats card-success card-round">
									<div class="card-body">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
													<i class="fa fa-check-square"></i>
												</div>
											</div>
											<div class="col-3 col-stats">
											</div>
											<div class="col-6 col-stats">
												<div class="numbers mt-4">
													<h2 class="fw-bold text-uppercase">With Sport</h2>
													<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
														<h1 class="fw-bold"><?= number_format($has_sports) ?></h1>
													<?php else : ?>
														<h1 class="fw-bold"><?= number_format($total_has_sports) ?></h1>
													<?php endif ?>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<!-- <a href="resident_info.php?state=all" class="card-link text-light">Total Employees </a> -->
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card card-stats card-danger card-round">
									<div class="card-body">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
													<i class="fa fa-minus-square"></i>
												</div>
											</div>
											<div class="col-3 col-stats">
											</div>
											<div class="col-6 col-stats">
												<div class="numbers mt-4">
													<h2 class="fw-bold text-uppercase">No Sport</h2>
													<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
														<h3 class="fw-bold"><?= number_format($no_sports) ?></h3>
													<?php else : ?>
														<h3 class="fw-bold"><?= number_format($total_no_sports) ?></h3>
													<?php endif ?>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<!-- <a href="resident_info.php?state=male" class="card-link text-light">Total Male </a> -->
									</div>
								</div>
							</div>

						</div>
					<?php endif ?>

					<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>

						<div class="row">
							
						<div class="col-md-3">
							<div class="card card-stats card-round card-success" style="height: 100px;">
							<a href="statistics.php" class="card-link text-light">
								<div class="card-body">
									<div class="row">
										<div class="col-3">
											<div class="icon-big text-center">
											<i class="bi bi-stack"></i>
											<svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-stack" viewBox="0 0 16 16">
  <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.6.6 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.6.6 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.6.6 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535z"/>
  <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.6.6 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0z"/>
</svg></a>
											</div>
										</div>
										<div class="col-3 col-stats">
										</div>
										<div class="col-6 col-stats">
											<div class="numbers mt-1">
												<h4 class="fw-bold text-uppercase">EMPLOYEES</h4>
												<h1 class="fw-bold text-uppercase"><?= number_format($total) ?></h1>
											</div>
										</div>
									</div>
								</div>
								<!-- <div class="card-body">
									<a href="statistics.php" class="card-link text-light">Information</a>
								</div> -->
							</div>
						</div> 
						
							<div class="col-md-3">
								<div class="card card-stats card-primary card-primary" style="height: 100px;">
								<a href="summary.php" class="card-link text-light">
									<div class="card-body py-9">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
													<i class="fas fa-sitemap"></i></a>
												</div>
											</div>
											<div class="col-3 col-stats">
											</div>
											<div class="col-6 col-stats">
												<div class="numbers mt-1">
													<h4 class="fw-bold text-uppercase">Teams</h4>
													<h1 class="fw-bold text-uppercase"><?= number_format($teams) ?></h1>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<!-- <a href="resident_info.php?state=voters" class="card-link text-light">Total Teams </a> -->
									</div>
								</div>
							</div>
							
	
							<div class="col-md-3">
								<div class="card card-stats card-warning card-primary" style="height: 100px;">
									<div class="card-body">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
												<i class='fas fa-table-tennis'></i>
												</div>
											</div>
											<div class="col-3 col-stats">
											</div>
											<div class="col-6 col-stats">
												<div class="numbers mt-1">
													<h4 class="fw-bold text-uppercase">Sports</h4>
													<h1 class="fw-bold text-uppercase"><?= number_format($sports) ?></h1>
												</div>
											</div>
										</div>
									</div>
									<div class="card-body">
										<!-- <a href="resident_info.php?state=non_voters" class="card-link text-light">Total Non Voters </a> -->
									</div>
								</div>
							</div>

							<div class="col-md-3">
								<div class="card card-stats card-danger card-round" style="height: 100px;">
									<div class="card-body">
										<div class="row">
											<div class="col-3">
												<div class="icon-big text-center">
													<i class="fas fa-user-secret"></i>
												</div>
											</div>
											<div class="col-3 col-stats">
												</div>
												<div class="col-6 col-stats">
													<div class="numbers mt-1">
														<h4 class="fw-bold text-uppercase">Users</h4>
														<h1 class="fw-bold text-uppercase"><?= number_format($users) ?></h1>
													</div>
												</div>
											</div>
										</div>
										<div class="card-body">
											<!-- <a href="resident_info.php?state=non_voters" class="card-link text-light">Total Non Voters </a> -->
										</div>
									</div>
								</div>
							<!-- ==================================================== -->
							<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-annotation"></script>
<div class="chart-container" style="float: right; margin-left: 7%;">
    <canvas id="genderDoughnutChart1" width="400" height="400"></canvas>
	<div class="chart-glow" id="glowChart1"></div>
</div>
<div class="chart-container" style="float: right; margin-left: 10%;">
    <canvas id="customDoughnutChart" width="403" height="403"></canvas>
	<div class="chart-glow" id="glowChart2"></div>
</div>

<script>
     // Get the canvas element for the first doughnut chart
	 var ctx1 = document.getElementById('genderDoughnutChart1').getContext('2d');

// Define the data for the first doughnut chart
var data1 = {
	labels: ['Total', 'Male', 'Female'],
	datasets: [{
		label: 'Total Distribution',
		data: [<?php echo $total; ?>, <?php echo $male; ?>, <?php echo $female; ?>],
		backgroundColor: [
			'rgba(75, 192, 192, 0.8)', // Green color for total
			'rgba(54, 162, 235, 0.8)', // Blue color for male
			'rgba(255, 159, 64, 0.8)' // Orange color for female
		]
	}]
};

// Create the first doughnut chart with the same design as the custom doughnut chart
var genderDoughnutChart1 = new Chart(ctx1, {
	type: 'doughnut',
	data: data1,
	options: {
		responsive: false,
		cutoutPercentage: 60,
		animation: {
			animateRotate: false // Disable rotation animation
		},
		elements: {
			arc: {
				borderWidth: 2, // Set border width
				borderColor: '#fff' // Set border color
			}
		},
		legend: {
			position: 'bottom'
		}
	}
});

    // Get the canvas element
var ctx = document.getElementById('customDoughnutChart').getContext('2d');
// Define the data for the doughnut chart
var data = {
    labels: ['Fit', 'On Leave', 'On Official Time', 'On Official Business', 'Unfit'],
    datasets: [{
        data: [<?php echo $Normal; ?>, <?php echo $Leave; ?>, <?php echo $OfficialTime; ?>, <?php echo $OfficialBusiness; ?>, <?php echo $Pwd + $Fever + $Asthma + $Allergies + $HeartDisease + $CardiovascularDisease + $Cancer + $Diabetes + $Hypertension + $Injuries + $Stroke + $Pregnant; ?>],
        label: 'Total Distribution',
		backgroundColor: [
            'rgba(75, 192, 192, 0.8)', // Green color for Fit
            'rgba(255, 99, 132, 0.8)', // Red color for On Leave
            'rgba(54, 162, 235, 0.8)', // Blue color for On Official Time
            'rgba(153, 102, 255, 0.8)', // Purple color for On Official Business
            'rgba(255, 206, 86, 0.8)', // Yellow color for Unfit
        ]
    }]
};

// Create the doughnut chart
var customDoughnutChart = new Chart(ctx, {
    type: 'doughnut',
    data: data,
    options: {
        responsive: false,
        cutoutPercentage: 60,
        animation: {
            animateRotate: false // Disable rotation animation
        },
        elements: {
            arc: {
                borderWidth: 2, // Set border width
                borderColor: '#fff' // Set border color
            }
        },
        legend: {
            position: 'bottom'
        }
    }
});
</script>



					<?php endif ?>
					
				</div>
			</div>
			
			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<?php include 'templates/modals.php' ?>

		</div>

	</div>
	<?php include 'templates/footer.php' ?>

</body>

</html>
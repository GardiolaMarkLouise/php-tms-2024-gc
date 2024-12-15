<?php
include 'server/server.php';

if (!isset($_SESSION['username']) && $_SESSION['role'] != 'administrator') {
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
        exit;
    }
}

$query = "SELECT * FROM tbl_users WHERE user_type='team leader'";
$result = $conn->query($query);

$team_leader = array();
while ($row = $result->fetch_assoc()) {
    $team_leader[] = $row;
}

$query2 = "SELECT tbl_employee.id,
                tbl_employee.fname,
                tbl_employee.mname,
                tbl_employee.lname,
                tbl_employee.emp_id_no,
                tbl_employee.dept,
                tbl_employee.contact,
                tbl_employee.age,
                tbl_employee.gender,
                tbl_employee.stat,
                tbl_employee.status,
                GROUP_CONCAT(DISTINCT CASE WHEN tbl_sports.status = 2 THEN tbl_sports.name END) as sports,
                tbl_employee.team,
				tbl_employee.team_leader
                FROM tbl_employee 
                LEFT JOIN tbl_sports ON tbl_sports.emp_id = tbl_employee.id
                WHERE tbl_employee.team IS NOT NULL AND tbl_employee.status != 3
                GROUP BY tbl_employee.emp_id_no";
$result2 = $conn->query($query2);

$employee = array();
while ($row = $result2->fetch_assoc()) {
    $employee[] = $row;
}

// Count total employees
$query_total = "SELECT COUNT(*) as total_count FROM tbl_employee WHERE team IS NOT NULL AND status != 3";
$result_total = $conn->query($query_total);
$row_total = $result_total->fetch_assoc();
$total_count = $row_total['total_count'];

// Count female employees
$query_female = "SELECT COUNT(*) as female_count FROM tbl_employee WHERE gender='Female' AND team IS NOT NULL AND status != 3";
$result_female = $conn->query($query_female);
$row_female = $result_female->fetch_assoc();
$female_count = $row_female['female_count'];

// Count male employees
$query_male = "SELECT COUNT(*) as male_count FROM tbl_employee WHERE gender='Male' AND team IS NOT NULL AND status != 3";
$result_male = $conn->query($query_male);
$row_male = $result_male->fetch_assoc();
$male_count = $row_male['male_count'];

$query5 = "SELECT * FROM tbl_sports WHERE `type` IS NULL ORDER BY `name`";
$result5 = $conn->query($query5);
$sports = array();
while ($row = $result5->fetch_assoc()) {
    $sports[] = $row;
}

$query6 = "SELECT * FROM tbl_dept";
$result6 = $conn->query($query6);
$dept = array();
while ($row = $result6->fetch_assoc()) {
    $dept[] = $row;
}

$query7 = "SELECT * FROM tbl_teams";
$result7 = $conn->query($query7);
$teams = array();
while ($row = $result7->fetch_assoc()) {
    $teams[] = $row;
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Team Statistics</title>
     <!-- Include DataTables CSS and JS files -->
     <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<!-- Include DataTables Buttons extension CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<!-- Include jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Include DataTables library -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Include DataTables Buttons extension -->
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>

    <style>
        /* Adjust column widths */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        /* Add ellipsis for overflowed text */
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
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
								<h2 class="text-white fw-bold">Team Statistics</h2>
							</div>
						</div>
					</div>
				</div>	
				<br>
				<div class="row">
				<div class="col-md-3 offset-md-2">
        <div class="card card-stats card-success card-round" style="width: 100%; min-height: 100px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="icon-big text-center">
                            <a href="javascript:void(0)" id="employees" class="card-link text-light">
                            <i class="bi bi-people-fill"></i><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
  <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
</svg></a>
                        </div>
                    </div>
                    <div class="col-3 col-stats">
                        <!-- Empty column for spacing -->
                    </div>
                    <div class="col-6 col-stats">
                        <div class="numbers mt-1">
                            <h4 class="fw-bold text-uppercase">List</h4>
                            <h2 class="fw-bold text-uppercase"><span id="total"><?php echo number_format($total_count); ?></span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <div class="col-md-3 offset-md--1">
        <div class="card card-stats card-primary card-round" style="width: 100%; min-height: 100px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="icon-big text-center">
                            <a href="javascript:void(0)" id="male" class="card-link text-light">
                            <i class="bi bi-person-standing"></i>
                            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-standing" viewBox="0 0 16 16">
  <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M6 6.75v8.5a.75.75 0 0 0 1.5 0V10.5a.5.5 0 0 1 1 0v4.75a.75.75 0 0 0 1.5 0v-8.5a.25.25 0 1 1 .5 0v2.5a.75.75 0 0 0 1.5 0V6.5a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v2.75a.75.75 0 0 0 1.5 0v-2.5a.25.25 0 0 1 .5 0"/>
</svg>
                        </div>
                    </div>
                    <div class="col-3 col-stats">
                        <!-- Empty column for spacing -->
                    </div>
                    <div class="col-6 col-stats">
                        <div class="numbers">
                            <h4 class="fw-bold text-uppercase">Male</h4>
                            <h2 class="fw-bold text-uppercase"><span id="maleCount"><?php echo number_format($male_count); ?></span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 offset-md--1">
        <div class="card card-stats card-warning card-round" style="width: 100%; min-height: 100px;">
            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <div class="icon-big text-center">
                            <a href="javascript:void(0)" id="female" class="card-link text-light">
                            <i class="bi bi-person-standing-dress"></i><svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-standing-dress" viewBox="0 0 16 16">
  <path d="M8 3a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3m-.5 12.25V12h1v3.25a.75.75 0 0 0 1.5 0V12h1l-1-5v-.215a.285.285 0 0 1 .56-.078l.793 2.777a.711.711 0 1 0 1.364-.405l-1.065-3.461A3 3 0 0 0 8.784 3.5H7.216a3 3 0 0 0-2.868 2.118L3.283 9.079a.711.711 0 1 0 1.365.405l.793-2.777a.285.285 0 0 1 .56.078V7l-1 5h1v3.25a.75.75 0 0 0 1.5 0Z"/>
</svg>
                        </a>
                        </div>
                    </div>
                    <div class="col-3 col-stats">
                        <!-- Empty column for spacing -->
                    </div>
                    <div class="col-6 col-stats">
                        <div class="numbers">
                            <h4 class="fw-bold text-uppercase">Female</h4>
                            <h2 class="fw-bold text-uppercase"><span id="femaleCount"><?php echo number_format($female_count); ?></span></h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


   
<div class="page-inner">
					<div class="row mt--2">
						<div class="col-md-12">

							<?php if (isset($_SESSION['message'])) : ?>
								<div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success'] == 'danger' ? 'bg-danger text-light' : null ?>" role="alert">
									<?php echo $_SESSION['message']; ?>
								</div>
								<?php unset($_SESSION['message']); ?>
							<?php endif ?>

							<form action="model/resetAll.php" method="POST">
								<?php if (isset($_SESSION['message'])) : ?>
									<div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success'] == 'danger' ? 'bg-danger text-light' : null ?>" role="alert">
										<?php echo $_SESSION['message']; ?>
									</div>
									<?php unset($_SESSION['message']); ?>
								<?php endif ?>
								<div class="card">
									

									<!-- Reset-->
									<div class="modal fade" id="reset" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<?php if (isset($_SESSION['username'])) : ?>
													<form method="POST" action="teams.php">
														<div class="modal-header">
															<h5 class="modal-title" id="exampleModalLabel">Warning!</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
															<div class="form-group form-floating-label">
																<label>Are you sure you want to reset all the selected data?</label>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
															<button type="submit" class="btn btn-primary" name="emp_delete_multiple_btn_player">Reset</button>
														</div>
													</form>
												<?php endif ?>
											</div>
										</div>
									</div>
							</form>

							<div id="filterContainer">
								<!-- Filter dropdowns will be added here -->
							</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="residenttable" class="display table table-hover">
                                        <thead>
                                                        <tr>
                                                        <?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
													<th scope="" class="no-print"><label for="select-all"> <input type="hidden" id="select-all"></th>
												<?php else : ?>
													<th scope="" class="no-print"><label for="select-all"> <input type="hidden" id="select-all" style="visibility: hidden;"></th>
												<?php endif ?>
												<th scope="col">Member Status</th>
                                                <th scope="col">Full Name</th>
												<th scope="col">Department and Office's</th>
												<th scope="col">Age</th>
												<th scope="col">Sex</th>
												<th scope="col">Sports</th>
												<th scope="col">Team</th> 
                                                        </tr>
                                                    </thead>
											<tbody>
												<?php if(!empty($employee)): ?>
													<?php foreach($employee as $row): ?>
                                                        <tr>
                                                        <?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
															<td><input type="hidden" name="emp_delete_id[]" value="<?= $row['emp_id_no']; ?>"></td>
														<?php else : ?>
															<td><input type="hidden" name="emp_delete_id[]" value="<?= $row['emp_id_no']; ?>" style="visibility: hidden;"></td>
														<?php endif ?>
														<td>
															<?php if ($row['team_leader'] == 'Yes'): ?>
																<span class="badge badge-pill badge-success">Team Leader</span>
															<?php endif; ?>
														</td>
														<td><?= ucwords($row['lname'] . ', ' . $row['fname'] . ' ' . $row['mname']) ?></td>
														<td><?= $row['dept'] ?></td>
														<td><?= $row['age'] ?></td>
														<td><?= $row['gender'] ?></td>
														<td><?= $row['sports'] ?></td>
														<td><?= $row['team'] ?></td>

															<!-- <div class="form-button-action hidden">

																<a type="hidden" href="#edit" data-toggle="modal" class="btn btn-link btn-primary" title="Edit Employee" onclick="editEmployee(this)" data-id="<?= $row['id'] ?>" data-fname="<?= $row['fname'] ?>" data-mname="<?= $row['mname'] ?>" data-lname="<?= $row['lname'] ?>" data-employee-id="<?= $row['emp_id_no'] ?>" data-department="<?= $row['dept'] ?>" data-contact="<?= $row['contact'] ?>" data-statedit="<?= $row['stat'] ?>" data-age="<?= $row['age'] ?>" data-gender="<?= $row['gender'] ?>" data-sports="<?= $row['sports'] ?>" data-team="<?= $row['team'] ?>">

																	<i class="fa fa-edit"></i>

																</a>

																<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
																	<a href="#" class="btn btn-link btn-danger" data-toggle="modal" data-target="#remove<?= $row['id'] ?>">
																		<i class="fa fa-times"></i>
																	</a>
																<?php endif ?>


															</div> -->
														</td>
<!-- Modal -->
<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-xl" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit/View Employee Information</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="model/edit_team_employee.php" enctype="multipart/form-data">
						<input type="hidden" name="size" value="1000000">
						<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>

							<div class="row">
								<div class="col-md-4">


									<div class="form-group">
										<label>First Name</label>
										<input type="text" class="form-control" name="fname" id="fname" placeholder="Enter First Name" required>
									</div>
									<div class="form-group">
										<label>Middle Name</label>
										<input type="text" class="form-control" name="mname" id="mname" placeholder="Enter Middle Name" required>
									</div>
									<div class="form-group">
										<label>Last Name</label>
										<input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Last Name" required>
									</div>
									<div class="form-group">
										<label>Employee ID No.</label>
										<input type="text" class="form-control" name="emp_id_no" id="emp_id_no" placeholder="Enter Employee ID" required>
									</div>
								</div>
								<div class="col-md-8">
									<div class="row">
										<div class="col">
											<div class="form-group">
												<label>Department</label>
												<select class="form-control" name="dept" id="dept" required>
													<option disabled selected>Select Department</option>
													<?php foreach ($dept as $row) : ?>
														<option value="<?= ucwords($row['name']) ?>"><?= $row['name'] ?></option>
													<?php endforeach ?>
												</select>
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label>Age</label>
												<input type="number" class="form-control" placeholder="Enter Age" name="age" id="age" min="21" max="65" required>
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label>Sex</label>
												<select class="form-control" name="gender" id="gender" required>
													<option disabled selected value="">Select Sex</option>
													<option value="Male">Male</option>
													<option value="Female">Female</option>
												</select>
											</div>
										</div>
									</div>


									<div class="form-group">
										<label>Sports</label>
										<select class="form-control" name="sports" id="sports">
											<option disabled selected>Select Sports</option>
											<option value="None">None</option>
											<?php foreach ($sports as $row) : ?>
												<option value="<?= ucwords($row['name']) ?>"><?= $row['name'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="form-group">
										<label>Team</label>
										<select class="form-control" name="team" id="team">
											<option disabled selected>Select Team</option>
											<?php foreach ($teams as $row) : ?>
												<option value="<?= ucwords($row['team_name']) ?>"><?= $row['team_name'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							</div>
						<?php endif ?>


						<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'team leader') : ?>

							<div class="row">
								<div class="col-md-4">


									<div class="form-group">
										<label>First Name</label>
										<input type="text" class="form-control" name="fname" id="fname" placeholder="Enter First Name" readonly required>
									</div>
									<div class="form-group">
										<label>Middle Name</label>
										<input type="text" class="form-control" name="mname" id="mname" placeholder="Enter Middle Name" readonly required>
									</div>
									<div class="form-group">
										<label>Last Name</label>
										<input type="text" class="form-control" name="lname" id="lname" placeholder="Enter Last Name" readonly required>
									</div>
									<div class="form-group">
										<label>Employee ID No.</label>
										<input type="text" class="form-control" name="emp_id_no" id="emp_id_no" placeholder="Enter Employee ID" readonly required>
									</div>
								</div>
								<div class="col-md-8">
									<div class="row">
										<div class="col">
											<div class="form-group">
												<label>Department</label>
												<select class="form-control" name="dept" id="dept" readonly required>
													<option disabled selected>Select Department</option>
													<?php foreach ($dept as $row) : ?>
														<option value="<?= ucwords($row['name']) ?>"><?= $row['name'] ?></option>
													<?php endforeach ?>
												</select>
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label>Age</label>
												<input type="number" class="form-control" placeholder="Enter Age" name="age" id="age" readonly required>
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label>Sex</label>
												<select class="form-control" name="gender" id="gender" readonly required>
													<option disabled selected value="">Select Sex</option>
													<option value="Male">Male</option>
													<option value="Female">Female</option>
												</select>
											</div>
										</div>
									</div>


									<div class="form-group">
										<label>Sports</label>
										<select class="form-control" name="sports" id="sports">
											<option disabled selected>Select Sports</option>
											<option value="None" id="none">None</option>
											<?php foreach ($sports as $row) : ?>
												<option value="<?= ucwords($row['name']) ?>"><?= $row['name'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<div class="form-group">
										<label>Team</label>
										<select class="form-control" name="team" id="team" readonly>
											<option disabled selected>Select Team</option>
											<?php foreach ($teams as $row) : ?>
												<option value="<?= ucwords($row['team_name']) ?>"><?= $row['team_name'] ?></option>
											<?php endforeach ?>
										</select>
									</div>
								</div>
							</div>
						<?php endif ?>


				</div>
				<div class="modal-footer">
					<input type="hidden" name="id" id="emp_id">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<?php if (isset($_SESSION['username'])) : ?>
						<button type="submit" class="btn btn-primary">Update</button>
					<?php endif ?>
				</div>
				</form>
			</div>
		</div>
	</div>




	<div class="modal fade" id="shuffle" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Shuffle Employees</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form method="POST" action="model/shuffle.php" onsubmit="return validateForm()">
						<div class="form-group">
							<label for="age_start">Age Range:</label>
							<select class="form-control" required name="age_start" id="age_start" required>
								<option disabled selected>Select Age Range</option>
								<option value="All">All Age Ranges</option>
								<option value="21">21 to 30</option>
								<option value="31">31 to 40</option>
								<option value="41">41 to 50</option>
								<option value="51">51 to 60</option>
								<option value="61">61 to 65</option>
							</select>
						</div>


						<div class="form-group">
							<label for="genders">Sex</label>
							<select class="form-control" name="genders" id="genders" required>
								<option disabled selected>Select Sex Type</option>
								<option value="All">All Sex</option>
								<option value="Male">Male</option>
								<option value="Female">Female</option>
							</select>
						</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary" name="submitShuffle">Shuffle</button>
				</div>
				</form>
			</div>
		</div>
	</div>

														<!-- Remove Player -->
														<div class="modal fade" id="remove<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<?php if (isset($_SESSION['username'])) : ?>
																		<form method="POST" action="model/remove_team_player.php?id=<?= $row['id'] ?>">
																			<div class="modal-header">
																				<h5 class="modal-title" id="exampleModalLabel">Warning!</h5>
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																					<span aria-hidden="true">&times;</span>
																				</button>
																			</div>
																			<div class="modal-body">
																				<div class="form-group form-floating-label">
																					<label>Are you sure you want to remove the player's team?</label>
																				</div>
																			</div>
																			<div class="modal-footer">
																				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
																				<button type="submit" class="btn btn-danger" name="emp_delete_multiple_btn_player">Remove</button>
																			</div>
																		</form>
																	<?php endif ?>
																</div>
															</div>
														</div>


													</tr>
												<?php endforeach ?>
											<?php endif ?>
										</tbody>
										<tfoot>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php include 'templates/footer.php' ?>
<!-- Include DataTables and related scripts -->
<script src="assets/js/plugin/datatables/datatables.min.js"></script>
<script src="assets/js/plugin/datatables/Buttons-1.6.1/js/dataTables.buttons.min.js"></script>
<script src="assets/js/plugin/datatables/Buttons-1.6.1/js/buttons.print.min.js"></script>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> -->
<!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

<script>
  $(document).ready(function() {
    var table = $('#residenttable').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        paging: true,
        info: true,
        dom: '<"row"<"col-md-6"l><"col-md-6"fB>>rtip',
        buttons: [
            {
                extend: 'copy',
                text: 'Copy',
                className: 'btn btn-secondary btn-sm'
            },
            {
                extend: 'csv',
                text: 'CSV',
                className: 'btn btn-secondary btn-sm',
                title: function () {
                    var filename = prompt('Enter the file name for CSV export:');
                    return filename ? filename : null;
                },
                action: function (e, dt, button, config) {
                    var filename = config.title();
                    if (filename) {
                        $.fn.dataTable.ext.buttons.csvHtml5.action.call(this, e, dt, button, $.extend({}, config, { title: filename }));
                    }
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                className: 'btn btn-secondary btn-sm',
                title: function () {
                    var filename = prompt('Enter the file name for Excel export:');
                    return filename ? filename : null;
                },
                action: function (e, dt, button, config) {
                    var filename = config.title();
                    if (filename) {
                        $.fn.dataTable.ext.buttons.excelHtml5.action.call(this, e, dt, button, $.extend({}, config, { title: filename }));
                    }
                }
            },
            {
                extend: 'pdf',
                text: 'PDF',
                className: 'btn btn-secondary btn-sm',
                title: function () {
                    var filename = prompt('Enter the file name for PDF export:');
                    return filename ? filename : null;
                },
                action: function (e, dt, button, config) {
                    var filename = config.title();
                    if (filename) {
                        $.fn.dataTable.ext.buttons.pdfHtml5.action.call(this, e, dt, button, $.extend({}, config, { title: filename }));
                    }
                }
            },
            {
                extend: 'print',
                text: 'Print',
                className: 'btn btn-secondary btn-sm'
            }
        ]
    });

    function updateCounts() {
        var filteredData = table.rows({ search: 'applied' }).data().toArray();
        var maleCount = 0;
        var femaleCount = 0;

        filteredData.forEach(function(row) {
            if (row[5].toLowerCase() === 'male') {
                maleCount++;
            } else if (row[5].toLowerCase() === 'female') {
                femaleCount++;
            }
        });

        $('#maleCount').text(maleCount);
        $('#femaleCount').text(femaleCount);
        $('#total').text(filteredData.length);
        console.log("Update counts - Total: " + filteredData.length + ", Male: " + maleCount + ", Female: " + femaleCount);
    }

    console.log("Table initialized: ", table);

    $('#filterContainer').append('<p class="mx-4 mt-4">Team Name: <select id="teamFilter"></select></p>');
    $('#teamFilter').on('change', function() {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        table.column(7).search(val ? '^' + val + '$' : '', true, false).draw();
        updateCounts();
    });

    <?php if (isset($_SESSION['username']) && $_SESSION['role'] === 'team leader') { ?>
        var teamName = "<?php echo $teamName; ?>";
        $('#teamFilter').append('<option value="' + teamName + '">' + teamName + '</option>');
        $('#teamFilter').val(teamName).change();
    <?php } else { ?>
        $('#teamFilter').append('<option value="">All Teams</option>');
        table.column(7).data().unique().sort().each(function(d, j) {
            $('#teamFilter').append('<option value="' + d + '">' + d + '</option>');
        });
    <?php } ?>

    $("#countButton").on('click', function() {
        var filteredData = table.rows({ search: 'applied' }).data();
        var rowCount = filteredData.count();
        $("#dataCount").text("Total Data Count: " + rowCount);
        $('#countModal').modal('show');
    });

    $('#generateReportBtn').click(function() {
        var filteredData = table.rows({ search: 'applied' }).data().toArray();
        var csvData = "Employee ID,Full Name,Department,Contact,Age,Gender,Status,Team\n";
        filteredData.forEach(function(row) {
            csvData += row.join(',') + '\n';
        });
        initiateDownload(csvData);
    });

    function initiateDownload(data) {
        var filename = prompt('Enter the file name for the CSV report:');
        if (filename) {
            filename += '.csv';
            var downloadLink = document.createElement('a');
            downloadLink.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(data);
            downloadLink.download = filename;
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    }

    $('#employees').click(function() {
        $('#employees, #male, #female').removeClass('active');
        $(this).addClass('active');
        table.column(5).search('').draw();
        updateCounts();
    });

    $('#male').click(function() {
        $('#employees, #male, #female').removeClass('active');
        $(this).addClass('active');
        table.column(5).search('^Male$', true, false).draw();
        updateCounts();
    });

    $('#female').click(function() {
        $('#employees, #male, #female').removeClass('active');
        $(this).addClass('active');
        table.column(5).search('^Female$', true, false).draw();
        updateCounts();
    });

    updateCounts();
});


</script>



<script>
    // Define the updateCounts function outside of the document ready block
    function updateCounts() {
        var table = window.residentTable;
        var filteredData = table.rows({ search: 'applied' }).data().toArray();
        var maleCount = 0;
        var femaleCount = 0;

        filteredData.forEach(function(row) {
            if (row[5].toLowerCase() === 'male') {
                maleCount++;
            } else if (row[5].toLowerCase() === 'female') {
                femaleCount++;
            }
        });

        $('#maleCount').text(maleCount);
        $('#femaleCount').text(femaleCount);
        $('#total').text(filteredData.length);
        console.log("Update counts - Total: " + filteredData.length + ", Male: " + maleCount + ", Female: " + femaleCount);
    }
</script>

</body>
</html>
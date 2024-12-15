<?php
include 'server/server.php';

if (!isset($_SESSION['username']) && $_SESSION['role'] != 'administrator') {
	if (isset($_SERVER["HTTP_REFERER"])) {
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
}
?>

<?php
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
				tbl_employee.stat,
				tbl_employee.status,
				GROUP_CONCAT(DISTINCT CASE WHEN tbl_sports.status = 2 THEN tbl_sports.name END) as sports,
				tbl_employee.team,
				tbl_employee.team_leader
				FROM tbl_employee 
				LEFT JOIN tbl_sports ON  tbl_sports.emp_id = tbl_employee.id
				WHERE tbl_employee.team IS NOT NULL AND 'type' IS  NOT NULL  AND tbl_employee.status != 3
				GROUP BY tbl_employee.emp_id_no
				";
$result2 = $conn->query($query2);

$employee = array();
while ($row = $result2->fetch_assoc()) {
	$employee[] = $row;
}

$query3 = "SELECT * FROM tbl_employee WHERE gender='Male' AND team IS NOT NULL  AND status != 3";
$result3 = $conn->query($query3);
$males = $result3->num_rows;

$query4 = "SELECT * FROM tbl_employee WHERE gender='Female' AND team IS NOT NULL AND status != 3";
$result4 = $conn->query($query4);
$females = $result4->num_rows;

$query5 = "SELECT * FROM tbl_sports WHERE `type` IS NULL  ORDER BY `name` ";
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
	<title>Teams - Team Management System</title>

	<style>
		.printBtn {
			margin-top: 10px;
		}
	</style>

	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
								<h2 class="text-white fw-bold">Teams</h2>
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
									<div class="card-header">
										<div class="card-head-row">

											<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
												<div class="card-title">All Teams</div>
											<?php else : ?>
												<div class="card-title">Your Team</div>
											<?php endif ?>


											<?php if (isset($_SESSION['username'])) : ?>


												<div class="card-tools">


													<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>

														<a href="#reset" data-toggle="modal" name="emp_delete_multiple_btn_player" class="btn btn-outline-danger btn-round btn-sm">
															<i class="fa fa-undo"></i>
															Reset
														</a>
															<!-- <a onclick="exportCSV()" class="btn btn-outline-primary btn-round btn-sm">
																<i class="fa fa-file"></i>
																Export CSV
															</a> -->
															<a href="#shuffle" data-toggle="modal" class="btn btn-outline-success btn-round btn-sm">
																<i class="fa fa-random"></i>
																Shuffle
															</a>

														<?php endif ?>

												</div>
											<?php endif ?>
										</div>
									</div>

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
												<th scope="col" class="no-print"><label for="select-all"> <input type="checkbox" id="select-all"></th>
												<th scope="col">Member Status</th>
												<th scope="col">Full Name</th>
												<th scope="col">Department</th>
												<th scope="col">Age</th>
												<th scope="col">Sex</th>
												<th scope="col">Sports</th>
												<th scope="col">Status</th>
												<th scope="col">Team</th>
												<th scope="col">Action<class="no-print" input type="hidden" style="visibility: hidden;"></th>
											</tr>
										</thead>
										<tbody>
											<?php if (!empty($employee)) : ?>
												<?php foreach ($employee as $row) : ?>
													<tr>
														<td><input type="checkbox" name="emp_delete_id[]" value="<?= $row['emp_id_no']; ?>"></td>
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
														<td><?= $row['stat'] ?></td>
														<td><?= $row['team'] ?></td>

														<td>
															<div class="form-button-action">

																<a type="button" href="#edit" data-toggle="modal" class="btn btn-link btn-primary" title="Edit Employee" onclick="editEmployee(this)" data-id="<?= $row['id'] ?>" data-fname="<?= $row['fname'] ?>" data-mname="<?= $row['mname'] ?>" data-lname="<?= $row['lname'] ?>" data-employee-id="<?= $row['emp_id_no'] ?>" data-department="<?= $row['dept'] ?>" data-contact="<?= $row['contact'] ?>" data-statedit="<?= $row['stat'] ?>" data-age="<?= $row['age'] ?>" data-gender="<?= $row['gender'] ?>" data-sports="<?= $row['sports'] ?>" data-team="<?= $row['team'] ?>" data-team-leader="<?= $row['team_leader'] ?>">

																	<i class="fa fa-edit"></i>

																</a>

																<?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
																<?php endif ?>


															</div>
														</td>

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

		<!-- Main Footer -->
		<?php include 'templates/main-footer.php' ?>
		<?php include 'templates/modals.php' ?>
		<!-- End Main Footer -->



	</div>
	</div>

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
										<input type="number" class="form-control" name="emp_id_no" id="emp_id_no" placeholder="Enter Employee ID" min="1" required>
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

	<?php include 'templates/footer.php' ?>
	
	<!-- Include jQuery -->
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
    // Initialize DataTables
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

    // Create filter dropdown for team_name in the separate container
    var columnIndex = 8; // Column index of team_name (0-based)

    $('#filterContainer').append('<p class="mx-4 mt-4">Team Name: <select id="teamFilter"></select></p>');
    
    // Apply the filter on change for team_name
    $('#teamFilter').on('change', function() {
        var val = $.fn.dataTable.util.escapeRegex($(this).val());
        selectedFilter = val;
        table
            .column(columnIndex)
            .search(val ? '^' + val + '$' : '', true, false)
            .draw();
    });

    // Populate the filter dropdown for team_name with unique values
    <?php
    if (isset($_SESSION['username']) && $_SESSION['role'] === 'team leader') {
        // Get the team name for the team leader from the session or database
        $teamName = strval($_SESSION['team_assigned']); // Replace with your code to get the team name
    ?>
        var teamName = "<?php echo $teamName; ?>";
        $('#teamFilter').append('<option value="' + teamName + '">' + teamName + '</option>');
        $('#teamFilter').val(teamName).change(); // Set the default value
    <?php
    } else {
    ?>
        $('#teamFilter').append('<option value="">All Teams</option>');
        table.column(columnIndex).data().unique().sort().each(function(d, j) {
            $('#teamFilter').append('<option value="' + d + '">' + d + '</option>');
        });
    <?php
    }
    ?>
});
</script>

	<script>
		$(document).ready(function() {
			// Function to check if all checkboxes are selected
			function areAllCheckboxesChecked() {
				var totalCheckboxes = $('input[type="checkbox"]').length;
				var checkedCheckboxes = $('input[type="checkbox"]:checked').length;
				return totalCheckboxes === checkedCheckboxes;
			}

			// "Select All" checkbox change event
			$('#select-all').change(function() {
				$('input[type="checkbox"]').prop('checked', this.checked);
			});

			// Other checkboxes change event
			$('input[type="checkbox"]').not('#select-all').change(function() {
				if (areAllCheckboxesChecked()) {
					$('#select-all').prop('checked', true);
				} else {
					$('#select-all').prop('checked', false);
				}
			});
		});
	</script>
	<script>
		function validateForm() {
			// Get the selected values from the dropdowns
			var ageStart = document.getElementById("age_start").value;
			var genders = document.getElementById("genders").value;

			// Check if both dropdowns have been selected
			if (ageStart === "Select Age Range" || genders === "Select Sex Type") {
				alert("Please select both Age Range and Sex Type.");
				return false; // Prevent the form from submitting
			}
			return true; // Allow the form to submit
		}
	</script>
	<!-- Export SCV -->
	<script>
    function exportCSV() {
        // Make an AJAX request to fetch the CSV data
        $.ajax({
            url: 'model/export_team_csv.php',
            method: 'POST',
            data: {
                item: selectedFilter,
            },
            success: function(response) {
                // Create a Blob from the CSV data
                var blob = new Blob([response], { type: 'data:text/csv;charset=utf-8;' });

                // Generate a filename based on the current date and time
                var currentDate = new Date();
                var formattedDate = currentDate.getFullYear() + '-' + padNumber(currentDate.getMonth() + 1) + '-' + padNumber(currentDate.getDate());
                var formattedTime = padNumber(currentDate.getHours()) + padNumber(currentDate.getMinutes()) + padNumber(currentDate.getSeconds());
                var filename = 'Teams_' + formattedDate + '-' + formattedTime + '.csv';

                // Create a temporary link and trigger the download
                var link = document.createElement('a');
                link.href = window.URL.createObjectURL(blob);
                link.download = filename;
                link.click();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                alert("Failed to export CSV. Please try again later."); // Notify user of error
            }
        });
    }

    // Function to pad single-digit numbers with a leading zero
    function padNumber(num) {
        return num < 10 ? '0' + num : num;
    }
</script>

	  <script >
        function editEmployee(element) {

            var dataid = element.dataset.id;

            var id = document.getElementById("id");
            id.value =  dataid;

			var emp_id_no = document.getElementById("emp_id_no");
			var fname = document.getElementById("fname");
			var mname = document.getElementById("mname");
			var lname = document.getElementById("lname");
			var dept = document.getElementById("department");
			var contact = document.getElementById("contact");
			var age = document.getElementById("age");
			var stat = document.getElementById("statedit");
			var gender = document.getElementById("gender");
			var sports = document.getElementById("sports");
			var sports = document.getElementById("stat");
			var team = document.getElementById("team");
			var team_leader = document.getElementById("team_leader");
			// team.value = null;

			var page = document.getElementById("page");
			page.value = "teams";

				// Get all options
				var sportsOptions = sports.options;
				var deptOptions = dept.options;
				var genderOptions = gender.options;
				var teamOptions = team.options;
				var leaderOptions = team_leader.options;

				// Make an AJAX request to a PHP script
				$.ajax({
						url: 'model/getEmployee.php',
						method: 'POST',
						data: {
							id: dataid,
						},
						success: function(response) {

							var jsonObject = JSON.parse(response);
							console.log(jsonObject);
							emp_id_no.value =  jsonObject.emp.emp_id_no;
							fname.value =  jsonObject.emp.fname;
							mname.value =  jsonObject.emp.mname;
							lname.value =  jsonObject.emp.lname;
							// dept.value =  jsonObject.emp.dept;
							contact.value =  jsonObject.emp.contact;
							stat.value =  jsonObject.emp.stat;
							age.value =  jsonObject.emp.age;
							// gender.value =  jsonObject.emp.gender;
							// team.value =  jsonObject.emp.team;

							// Dept
							var selectedDept = jsonObject.emp.dept;
							selectedDept = selectedDept.replace(/\s/g, '').toLowerCase();

							for (let index = 0; index < deptOptions.length; index++) {

								var optionValue = deptOptions[index].value;
								optionValue = optionValue.replace(/\s/g, '').toLowerCase();

								deptOptions[index].selected = (optionValue == selectedDept ?  deptOptions[index].value : null);
							}

							// Gender
							var selectedGender = jsonObject.emp.gender;
							selectedGender = selectedGender.replace(/\s/g, '').toLowerCase();

							for (let index = 0; index < genderOptions.length; index++) {

								var optionValue = genderOptions[index].value;
								optionValue = optionValue.replace(/\s/g, '').toLowerCase();

								genderOptions[index].selected = (optionValue == selectedGender ?  genderOptions[index].value : null);
							}

							// Teams
							var selectedTeams = jsonObject.emp.team;
							selectedTeams = selectedTeams.replace(/\s/g, '').toLowerCase();

							for (let index = 0; index < teamOptions.length; index++) {

								var optionValue = teamOptions[index].value;
								optionValue = optionValue.replace(/\s/g, '').toLowerCase();

								teamOptions[index].selected = (optionValue == selectedTeams ?  teamOptions[index].value : null);
							}

							console.log( jsonObject.emp.team_leader);
							// team leader
							var selectedLeader =  jsonObject.emp.team_leader;
							if (selectedLeader) {
								selectedLeader = selectedLeader.replace(/\s/g, '').toLowerCase();

								for (let index = 0; index < leaderOptions.length; index++) {

									var optionValue = leaderOptions[index].value;
									optionValue = optionValue.replace(/\s/g, '').toLowerCase();

									leaderOptions[index].selected = (optionValue == selectedLeader ?  leaderOptions[index].value : null);
								}
							}


							// sports
							// Loop through each option in the dropdown
							if (Array.isArray(jsonObject.sports)) {
								var selectedSports = jsonObject.sports;

								// Loop through each option in the dropdown
								for (var i = 0; i < sportsOptions.length; i++) {
									var option = sportsOptions[i];

									// Check if the current option's value is in the selectedSports array
									if (selectedSports.includes(option.value)) {
										// If yes, set the selected attribute
										option.selected = true;
									}else{
										option.selected = false;
									}
								}
							} else {
								console.error("Sports data is not an array.");
							}

						},
						error: function(xhr, status, error) {
							console.error(xhr.responseText);
						}
					});
			}
	</script>
	
</body>

</html>
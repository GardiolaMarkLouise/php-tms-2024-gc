<?php include 'server/server.php' ?>

<?php

// Check if the user is logged in and has the "administrator" role
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'administrator') {
	// Redirect to a different page or display an error message
	echo '<script>alert("You do not have access to this page.")</script>';
	exit;
}
?>

<?php
$query = "SELECT * FROM tbl_teams";
$result = $conn->query($query);

$teams = array();
while ($row = $result->fetch_assoc()) {
	$teams[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'templates/header.php' ?>
	<title>Manage Teams - Team Management System</title>
</head>

<body>
	<?php include 'templates/loading_screen.php' ?>

	<div class="wrapper">
		<!-- Main Header -->
		<?php include 'templates/main-header.php' ?>
		

		<!-- Sidebar -->
		<?php include 'templates/sidebar.php' ?>
		

		<div class="main-panel">
			<div class="content">
				<div class="panel-header bg-primary-gradient">
					<div class="page-inner">
						<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
							<div>
								<h2 class="text-white fw-bold">Manage Teams</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner">
					<?php if (isset($_SESSION['message'])) : ?>
						<div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success'] == 'danger' ? 'bg-danger text-light' : null ?>" role="alert">
							<?php echo $_SESSION['message']; ?>
						</div>
						<?php unset($_SESSION['message']); ?>
					<?php endif ?>
					<div class="row mt--2">

						<div class="col-md-12">

							<div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">All Teams</div>
										<?php if (isset($_SESSION['username'])) : ?>
											<div class="card-tools">
												<a href="#add" data-toggle="modal" class="btn btn-outline-primary btn-round btn-sm">
													<i class="fa fa-plus"></i>
													Team
												</a>
											</div>
										<?php endif ?>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table class="table table-striped">
											<thead>
												<tr>
													<th scope="col">#</th>
													<th scope="col">Team Name</th>
													<th scope="col">Team Color</th>
													<?php if (isset($_SESSION['username'])) : ?>
														<?php if ($_SESSION['role'] == 'administrator') : ?>
															<th>Action</th>
														<?php endif ?>
													<?php endif ?>
												</tr>
											</thead>
											<tbody>
												<?php if (!empty($teams)) : ?>
													<?php foreach ($teams as $index => $row) : ?>
														<tr>
															<td class="text-uppercase"><?= $index + 1 ?></td>
															<td><?= $row['team_name'] ?></td>
															<td><?= $row['team_color'] ?></td>
															<?php if (isset($_SESSION['username'])) : ?>

																<td>
																	<a type="button" href="#modalTeam" data-toggle="modal" class="btn btn-link btn-primary" title="Edit Team" onclick="editTeam(this)" data-team-id="<?= $row['id'] ?>" data-team-name="<?= $row['team_name'] ?>" data-team-color="<?= $row['team_color'] ?>">
																		<i class="fa fa-edit"></i>
																	</a>

																	<a href="#" class="btn btn-link btn-danger" data-toggle="modal" data-target="#removeTeam<?= $row['id'] ?>">
																		<i class="fa fa-times"></i>
																	</a>
																</td>

																<!-- Remove Team -->
																<div class="modal fade" id="removeTeam<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<?php if (isset($_SESSION['username'])) : ?>
																				<form method="POST" action="model/remove_teams.php?id=<?= $row['id'] ?>">
																					<div class="modal-header">
																						<h5 class="modal-title" id="exampleModalLabel">Warning!</h5>
																						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																							<span aria-hidden="true">&times;</span>
																						</button>
																					</div>
																					<div class="modal-body">
																						<div class="form-group form-floating-label">
																							<label>Are you sure you want to delete this team?</label>
																						</div>
																					</div>
																					<div class="modal-footer">
																						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
																						<button type="submit" class="btn btn-danger">Remove</button>
																					</div>
																				</form>
																			<?php endif ?>
																		</div>
																	</div>
																</div>
															<?php endif ?>
														</tr>
													<?php endforeach ?>
												<?php else : ?>
													<tr>
														<td colspan="3" class="text-center">No Available Data</td>
													</tr>
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

			<!-- Modal -->
			<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Create a Team</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form method="POST" action="model/save_teams.php">
								<div class="form-group">
									<label>Team Name</label>
									<input type="text" class="form-control" placeholder="Enter team name" name="team_name" required>

									<label>Team Color</label>
									<select class="form-control" name="team_color" id="team_color">
										<option disabled selected value="">Select Team Color</option>
										<option value="White">White</option>
										<option value="Green">Green</option>
										<option value="Blue">Blue</option>
										<option value="Yellow">Yellow</option>
										<option value="Red">Red</option>
										<option value="Purple">Purple</option>
									</select>
								</div>




						</div>
						<div class="modal-footer">
							<input type="hidden" id="pos_id" name="id">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Create</button>
						</div>
						</form>
					</div>
				</div>
			</div>

			<!-- Modal -->
			<div class="modal fade" id="modalTeam" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<form method="POST" action="model/edit_team.php">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Edit Team</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<div class="form-group">
								<label>Team Name</label>
								<input type="text" class="form-control" name="team_name" id="team_name" placeholder="Enter team name">

								<label>Team Color</label>
								<select class="form-control" name="team_color" id="team_color">
									<option disabled selected value="">Select Team Color</option>
									<option value="White">White</option>
									<option value="Green">Green</option>
									<option value="Blue">Blue</option>
									<option value="Yellow">Yellow</option>
									<option value="Red">Red</option>
									<option value="Purple">Purple</option>
								</select>
							</div>
						</div>
						<div class="modal-footer">
							<input type="hidden" id="team_id" name="id">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Update</button>
						</div>
						</form>
					</div>
				</div>
			</div>



			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<?php include 'templates/modals.php' ?>
			<!-- End Main Footer -->

		</div>

	</div>
	<?php include 'templates/footer.php' ?>
</body>

</html>
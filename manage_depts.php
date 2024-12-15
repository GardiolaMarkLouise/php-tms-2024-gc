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
$query = "SELECT * FROM tbl_dept";
$result = $conn->query($query);

$depts = array();
while ($row = $result->fetch_assoc()) {
	$depts[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<?php include 'templates/header.php' ?>
	<title>Manage Departments - Team Management System</title>
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
								<h2 class="text-white fw-bold">Manage Departments</h2>
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
										<div class="card-title">All Departments</div>
										<?php if (isset($_SESSION['username'])) : ?>
											<div class="card-tools">
												<a href="#add" data-toggle="modal" class="btn btn-outline-primary btn-round btn-sm">
													<i class="fa fa-plus"></i>
													Department
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
													<th scope="col">Name</th>
													<?php if (isset($_SESSION['username'])) : ?>
														<?php if ($_SESSION['role'] == 'administrator') : ?>
															<th>Action</th>
														<?php endif ?>
													<?php endif ?>
												</tr>
											</thead>
											<tbody>
												<?php if (!empty($depts)) : ?>
													<?php foreach ($depts as $index => $row) : ?>
														<tr>
															<td class="text-uppercase"><?= $index + 1 ?></td>
															<td><?= $row['name'] ?></td>
															<?php if (isset($_SESSION['username'])) : ?>

																<td>
																	<?php if ($_SESSION['role'] == 'administrator') : ?>
																		<a href="#" class="btn btn-link btn-danger" data-toggle="modal" data-target="#removeDept<?= $row['id'] ?>">
																			<i class="fa fa-times"></i>
																		</a>
																	<?php endif ?>
																</td>

																<!-- Remove Dept -->
																<div class="modal fade" id="removeDept<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<?php if (isset($_SESSION['username'])) : ?>
																				<form method="POST" action="model/remove_depts.php?id=<?= $row['id'] ?>">
																					<div class="modal-header">
																						<h5 class="modal-title" id="exampleModalLabel">Warning!</h5>
																						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																							<span aria-hidden="true">&times;</span>
																						</button>
																					</div>
																					<div class="modal-body">
																						<div class="form-group form-floating-label">
																							<label>Are you sure you want to delete this department?</label>
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
							<h5 class="modal-title" id="exampleModalLabel">Create Department</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<form method="POST" action="model/save_depts.php">
								<div class="form-group">
									<label>Name</label>
									<input type="text" class="form-control" placeholder="Set a name of department" name="name" required>
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



			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<?php include 'templates/modals.php' ?>
			<!-- End Main Footer -->

		</div>

	</div>
	<?php include 'templates/footer.php' ?>
</body>

</html>
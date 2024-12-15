<?php include 'server/server.php' ?>
<?php
    // session_start();

    // Check if the user is logged in and has the "administrator" role
    if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'administrator') {
        // Redirect to a different page or display an error message
        echo '<script>alert("You do not have access to this page.")</script>';
        
        exit;
    }
?>

<?php 
	$query = "SELECT * FROM tbl_employee";
    $result = $conn->query($query);

    $employee = array();
	while($row = $result->fetch_assoc()){
		$employee[] = $row; 
	}

    $query1 = "SELECT * FROM tbl_dept ORDER BY `name`";
    $result1 = $conn->query($query1);
    $dept = array();
	while($row = $result1->fetch_assoc()){
		$dept[] = $row; 
	}

    $query2 = "SELECT * FROM tbl_sports ORDER BY `name`";
    $result2 = $conn->query($query2);
    $sports = array();
	while($row = $result2->fetch_assoc()){
		$sports[] = $row; 
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'templates/header.php' ?>
	<title>Employees -  Team Management System</title>
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
								<h2 class="text-white fw-bold">Employees</h2>
							</div>
						</div>
					</div>
				</div>
				<div class="page-inner">
					<div class="row mt--2">
						<div class="col-md-12">

                            <?php if(isset($_SESSION['message'])): ?>
                                <div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success']=='danger' ? 'bg-danger text-light' : null ?>" role="alert">
                                    <?php echo $_SESSION['message']; ?>
                                </div>
                            <?php unset($_SESSION['message']); ?>
                            <?php endif ?>

                            <div class="card">
								<div class="card-header">
									<div class="card-head-row">
										<div class="card-title">Employee Information</div>
                                        <?php if(isset($_SESSION['username'])):?>
										<div class="card-tools">
                                            <?php if(isset($_SESSION['username']) && $_SESSION['role']=='administrator'): ?>
											<button type="button" href="#add" data-toggle="modal" class="btn btn-outline-primary btn-round btn-sm">
                                            <i class="fa fa-plus"></i>
												Employee
                                            </button>
                                            
                                            <a href="model/export_employee_csv.php" class="btn btn-outline-success btn-round btn-sm">
                                            <i class="fa fa-file"></i>
												Export CSV
											</a>
                                            <!-- <a href="#" class="btn btn-outline-warning btn-round btn-sm">
												<i class="fa fa-random"></i>
												Shuffle
											</a> -->
                                            <a href="#" class="btn btn-outline-danger btn-round btn-sm">
												<i class="fa fa-trash"></i>
												Delete All
											</a>
                                            <a href="#importModal" data-toggle="modal" class="btn btn-outline-primary btn-round btn-sm">
												<i class="fa fa-file"></i>
												Import CSV
											</a>

                                            
                                            <?php endif ?>
										</div>
                                        <?php endif ?>
									</div>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="residenttable" class="display table table-striped">
											<thead>
												<tr>
                                                    <th scope="col"></th>
													<th scope="col">Full Name</th>
                                                    <th scope="col">Employee ID</th>
													<th scope="col">Department</th>
													
													<th scope="col">Age</th>
													
                                                    <th scope="col">Sex</th>
													
                                                    <?php if(isset($_SESSION['username']) && $_SESSION['role']=='administrator'): ?>
													    <th scope="col">Action</th>
                                                    <?php endif ?>

												</tr>
											</thead>
											<tbody>
												<?php if(!empty($employee)): ?>
													<?php $no=1; foreach($employee as $row): ?>
													<tr>
                                                        <td></td>
														<td>
                                                            <?= ucwords($row['lname'].', '.$row['fname'].' '.$row['mname']) ?>
                                                        </td>
                                                        <td><?= $row['emp_id_no'] ?></td>
														<td><?= $row['dept'] ?></td>
														<td><?= $row['age'] ?></td>
                                                        <td><?= $row['gender'] ?></td>
                                                        

                                                        <?php if(isset($_SESSION['username'])):?>
                                                            <?php if($_SESSION['role']=='administrator'):?>
                                                        <?php endif ?>

														<td>
															<div class="form-button-action">
                                                                <a type="button" href="#edit" data-toggle="modal" class="btn btn-link btn-primary" title="Edit Employee" onclick="editEmployee(this)" 
                                                                    data-id="<?= $row['id'] ?>" data-employee-id="<?= $row['emp_id_no'] ?>" data-fname="<?= $row['fname'] ?>" data-mname="<?= $row['mname'] ?>" data-lname="<?= $row['lname'] ?>"
                                                                    data-age="<?= $row['age'] ?>" data-gender="<?= $row['gender'] ?>" data-department="<?= $row['dept'] ?>" data-sports="<?= $row['sports'] ?>" >
                                                                    <?php if(isset($_SESSION['username']) && $_SESSION['role']=='administrator'): ?>
                                                                        <i class="fa fa-edit"></i>
                                                                    <?php endif ?>
                                                                </a>
                                                                <?php if(isset($_SESSION['username']) && $_SESSION['role']=='administrator'):?>
                                                                    <a type="button" data-toggle="tooltip" href="model/remove_employee.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this employee?');" class="btn btn-link btn-danger" data-original-title="Remove">
                                                                        <i class="fa fa-times"></i>
                                                                    </a>
                                                                <?php endif ?>
															</div>
														</td>
                                                        <?php endif ?>
														
													</tr>
													<?php $no++; endforeach ?>
												<?php endif ?>
											</tbody>
											<tfoot>
												<!-- <tr>
                                                    <th scope="col">Full Name</th>
                                                    <th scope="col">Employee ID</th>
													<th scope="col">Alias</th>
													<th scope="col">Age</th>
                                                    <th scope="col">Gender</th>
                                                    <?php if(isset($_SESSION['username'])):?>
                                                        <?php if($_SESSION['role']=='administrator'):?>
                                                    <?php endif ?>
													<th scope="col">Action</th>
                                                    <?php endif ?>
												</tr> -->
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
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">New Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="model/save_employee.php" enctype="multipart/form-data">
                            <input type="hidden" name="size" value="1000000">
                            <div class="row">
                                <!-- <div class="col-md-4">
                                    <div style="width: 370px; height: 250;" class="text-center" id="my_camera">
                                        <img src="assets/img/person.png" alt="..." class="img img-fluid" width="250" >
                                    </div>
                                    
                                    <div id="profileImage">
                                        <input type="hidden" name="profileimg">
                                    </div>
                                   
                                
                                    
                                </div> -->
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>First Name</label>
                                                <input type="text" class="form-control" placeholder="Enter First Name" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Middle Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Middle Name" name="mname" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Last Name</label>
                                                <input type="text" class="form-control" placeholder="Enter Last Name" name="lname" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <select class="form-control" required name="dept">
                                                    <option disabled selected>Select Department</option>
                                                    <?php foreach($dept as $row):?>
                                                        <option value="<?= ucwords($row['name']) ?>"><?= $row['name'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Sex</label>
                                                <select class="form-control" required name="gender">
                                                    <option disabled selected value="">Select Sex</option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="number" class="form-control" placeholder="Enter Age" min="1" name="age" required>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group">
                                                <label>Employee ID</label>
                                                <input type="number" class="form-control" placeholder="Enter Employee ID" min="1" max="500" name="emp_id_no" required>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="row">

                                        <!-- <div class="col">
                                            <div class="form-group">
                                                <label>Sports</label>
                                                <select class="form-control" required name="sports">
                                                    <option disabled selected>Select Sports</option>
                                                    <?php foreach($sports as $row):?>
                                                        <option value="<?= ucwords($row['name']) ?>"><?= $row['name'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div> -->
                                        
                                        <!-- <div class="col">
                                            <div class="form-group">
                                                <label>Team</label>
                                                <select class="form-control" name="team">
                                                    <option disabled selected>Unavailable</option>
                                                    <?php foreach($teams as $row):?>
                                                        <option value="<?= ucwords($row['name']) ?>" disabled><?= $row['name'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        </div> -->
                                        
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal -->
			<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="POST" action="model/edit_employee.php">
                            <input type="hidden" name="size" value="1000000">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>First Name</label>
                                        <input type="text" class="form-control" placeholder="Enter First name" name="fname" id="fname" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Middle Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Middle Name" name="mname" id="mname" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Last Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Last Name" name="lname" id="lname" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Employee ID No.</label>
                                        <input type="text" class="form-control" placeholder="Enter Employee ID No." name="emp_id_no" id="emp_id_no" required>
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Department</label>
                                                <input type="text" class="form-control" placeholder="Select Department" name="dept" id="dept" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Age</label>
                                                <input type="text" class="form-control" placeholder="Enter Age" name="age" id="age" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Sex</label>
                                                <input type="text" class="form-control" placeholder="Select Sex" name="gender" id="gender" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Sports</label>
                                                <input type="text" class="form-control" placeholder="Select Sports" name="sports" id="sports" required>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group">
                                                <label>Team</label>
                                                <input type="text" class="form-control" placeholder="Select Team" name="team" id="team" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                
                                
								
                            
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" id="emp_id" name="id">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>

			<!-- Main Footer -->
			<?php include 'templates/main-footer.php' ?>
			<!-- End Main Footer -->
			
		</div>
		
	</div>
	<?php include 'templates/footer.php' ?>
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#residenttable').DataTable();
        });
    </script>

    <script>
        // Display an Editor form that allows the user to pick the CSV data to apply to each column
        function selectColumns(editor, csv, header) {
            var selectEditor = new DataTable.Editor();
            var fields = editor.order();
        
            for (var i = 0; i < fields.length; i++) {
                var field = editor.field(fields[i]);
        
                selectEditor.add({
                    label: field.label(),
                    name: field.name(),
                    type: 'select',
                    options: header,
                    def: header[i]
                });
            }
        
            selectEditor.create({
                title: 'Map CSV fields',
                buttons: 'Import ' + csv.length + ' records',
                message: 'Select the CSV column you want to use the data from for each field.',
                onComplete: 'none'
            });
        
            selectEditor.on('submitComplete', function (e, json, data, action) {
                // Use the host Editor instance to show a multi-row create form allowing the user to submit the data.
                editor.create(csv.length, {
                    title: 'Confirm import',
                    buttons: 'Submit',
                    message:
                        'Click the <i>Submit</i> button to confirm the import of ' +
                        csv.length +
                        ' rows of data. Optionally, override the value for a field to set a common value by clicking on the field below.'
                });
        
                for (var i = 0; i < fields.length; i++) {
                    var field = editor.field(fields[i]);
                    var mapped = data[field.name()];
        
                    for (var j = 0; j < csv.length; j++) {
                        field.multiSet(j, csv[j][mapped]);
                    }
                }
            });
        }
        
        // Regular editor for the table
        var editor = new DataTable.Editor({
            ajax: '../php/staff.php',
            table: '#residenttable',
            fields: [
                {
                    label: 'First Name:',
                    name: 'fname'
                },
                {
                    label: 'Middle Name:',
                    name: 'mname'
                },
                {
                    label: 'Last Name:',
                    name: 'lname'
                },
                {
                    label: 'Employee ID:',
                    name: 'emp_id_no'
                },
                {
                    label: 'Department:',
                    name: 'dept'
                },
                {
                    label: 'Age:',
                    name: 'age'
                },
                {
                    label: 'Sex:',
                    name: 'gender'
                }
            ]
        });
        
        // Upload Editor - triggered from the import button. Used only for uploading a file to the browser
        var uploadEditor = new DataTable.Editor({
            fields: [
                {
                    label: 'CSV file:',
                    name: 'csv',
                    type: 'upload',
                    ajax: function (files, done) {
                        // Ajax override of the upload so we can handle the file locally. Here we use Papa
                        // to parse the CSV.
                        Papa.parse(files[0], {
                            header: true,
                            skipEmptyLines: true,
                            complete: function (results) {
                                if (results.errors.length) {
                                    console.log(results);
                                    uploadEditor
                                        .field('csv')
                                        .error('CSV parsing error: ' + results.errors[0].message);
                                }
                                else {
                                    selectColumns(editor, results.data, results.meta.fields);
                                }
        
                                // Tell Editor the upload is complete - the array is a list of file
                                // id's, which the value of doesn't matter in this case.
                                done([0]);
                            }
                        });
                    }
                }
            ]
        });
        
        $('#residenttable').DataTable({
            ajax: '../php/staff.php',
            buttons: [
                { extend: 'create', editor: editor },
                { extend: 'edit', editor: editor },
                { extend: 'remove', editor: editor },
                {
                    extend: 'csv',
                    text: 'Export CSV',
                    className: 'btn-space',
                    exportOptions: {
                        orthogonal: null
                    }
                },
                {
                    text: 'Import CSV',
                    action: function () {
                        uploadEditor.create({
                            title: 'CSV file import'
                        });
                    }
                },
                {
                    extend: 'selectAll',
                    className: 'btn-space'
                },
                'selectNone'
            ],
            columns: [
                { data: 'first_name' },
                { data: 'last_name' },
                { data: 'position' },
                { data: 'office' },
                { data: 'start_date' },
                { data: 'salary', render: DataTable.render.number(null, null, 0, '$') }
            ],
            dom: 'Bfrtip',
            select: true
        });
    </script>
</body>
</html>
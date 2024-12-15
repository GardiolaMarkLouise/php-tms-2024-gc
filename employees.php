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

$query = "SELECT * FROM tbl_employee WHERE status != 3";
$result = $conn->query($query);

$employee = array();
while ($row = $result->fetch_assoc()) {
    $employee[] = $row;
}

$query1 = "SELECT * FROM tbl_dept ORDER BY `name`";
$result1 = $conn->query($query1);
$dept = array();
while ($row = $result1->fetch_assoc()) {
    $dept[] = $row;
}

// $query2 = "SELECT * FROM tbl_dept ORDER BY `name`";
// $result2 = $conn->query($query2);
// $cont = array();
// while ($row = $result2->fetch_assoc()) {
//     $dept[] = $row;
// }
//  
$query2 = "SELECT * FROM tbl_sports WHERE `type` IS NULL  ORDER BY `name` ";
$result2 = $conn->query($query2);
$sports = array();

while ($row = $result2->fetch_assoc()) {
    $sports[] = $row;
}

$query3 = "SELECT * FROM tbl_teams";
$result3 = $conn->query($query3);
$teams = array();
while ($row = $result3->fetch_assoc()) {
    $teams[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'templates/header.php' ?>
    <title>Employee Information - Team Management System</title>
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
                                <h2 class="text-white fw-bold">Employees</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-inner">
                    <div class="row mt--2">
                        <div class="col-md-12">

                            <?php
                            if (isset($_SESSION['status_success'])) {
                            ?>
                                <div class="alert alert-success" role="alert">
                                    <?php echo $_SESSION['status_success']; ?>

                                </div>
                            <?php
                                unset($_SESSION['status_success']);
                            }
                            if (isset($_SESSION['status_failed'])) {
                            ?>
                                <div class="alert alert-danger" role="alert">
                                    <?php echo $_SESSION['status_failed']; ?>

                                </div>
                            <?php
                                unset($_SESSION['status_failed']);
                            }
                            ?><form action="model/archiveAll.php" method="POST">
                                <?php if (isset($_SESSION['message'])) : ?>
                                    <div class="alert alert-<?php echo $_SESSION['success']; ?> <?= $_SESSION['success'] == 'danger' ? 'bg-danger text-light' : null ?>" role="alert">
                                        <?php echo $_SESSION['message']; ?>
                                    </div>
                                    <?php unset($_SESSION['message']); ?>
                                <?php endif ?>

                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-head-row">
                                            <div class="card-title">Employee Information</div>
                                            <?php if (isset($_SESSION['username'])) : ?>
                                                <div class="card-tools">
                                                    <button type="button" href="#add" data-toggle="modal" class="btn btn-outline-primary btn-round btn-sm">
                                                        <i class="fa fa-plus"></i>
                                                        Employee
                                                    </button>

                                                    <a href="#importModal" data-toggle="modal" class="btn btn-outline-secondary btn-round btn-sm">
                                                        <i class="fa fa-file"></i>
                                                        Import CSV
                                                    </a>

                                                    <a href="model/export_employee_csv.php" class="btn btn-outline-success btn-round btn-sm">
                                                        <i class="fa fa-file"></i>
                                                        Export CSV
                                                    </a>

                                                

                                                    <a href="#archive" data-toggle="modal" name="emp_delete_multiple_btn" class="btn btn-outline-danger btn-round btn-sm">
                                                        <i class="fa fa-trash"></i>
                                                        Archive
                                                    </a>

                                                    <a href="#restore" data-toggle="modal" class="btn btn-outline-info btn-round btn-sm" name="restore_data_btn">
                                                        <i class="fa fa-check"></i>
                                                        Restore
                                                    </a>

                                                </div>

                                            <?php endif ?>
                                        </div>
                                    </div>

                                    <!-- Archive All -->
                                    <div class="modal fade" id="archive" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Warning!</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    </div>
                                                <div class="modal-body">
                                                        <div class="form-group form-floating-label">
                                                            <label>Are you sure you want to archive all the selected data?</label>
                                                            </div>
                                                        </div>
                                                    <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <input type="submit" class="btn btn-primary" name="emp_delete_multiple_btn" value="Confirm">
                                                    </div>
                                                </div>
                                            </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="residenttable" class="display table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">
                                                                <label for="select-all"> <input type="checkbox" id="select-all">
                                                            </th>
                                                            <th scope="col">Member Status</th>
                                                            <th scope="col">Employee ID</th>
                                                            <th scope="col">Full Name</th>
                                                            <th scope="col">Department</th>
                                                            <th scope="col">Contact</th>
                                                            <th scope="col">Age</th>
                                                            <th scope="col">Sex</th>
                                                            <th scope="col">Status</th>

                                                            <?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
                                                                <th scope="col">Action</th>
                                                            <?php endif ?>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($employee)) : ?>
                                                            <?php $no = 1;
                                                            foreach ($employee as $row) : ?>
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" name="emp_archive_id[]" value="<?= $row['emp_id_no']; ?>">
                                                                    </td>
                                                                    <td>
                                                                    <?php if ($row['team_leader'] == 'Yes'): ?>
                                                                    <span class="badge badge-pill badge-success">Team Leader</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td><?= $row['emp_id_no'] ?></td>
                                                                    <td>
                                                                        <?= ucwords($row['lname'] . ', ' . $row['fname'] . ' ' . $row['mname']) ?>
                                                                    </td>
                                                                    <td><?= $row['dept'] ?></td>
                                                                    <td><?= $row['contact'] ?></td>
                                                                    <td><?= $row['age'] ?></td>
                                                                    <td><?= $row['gender'] ?></td>
                                                                    <td><?= $row['stat'] ?></td>


                                                                    <?php if (isset($_SESSION['username'])) : ?>
                                                                        <?php if ($_SESSION['role'] == 'administrator') : ?>
                                                                        <?php endif ?>

                                                                        <td>
                                                                            <div class="form-button-action">
                                                                                <a type="button" href="#edit" data-toggle="modal" class="btn btn-link btn-primary" title="Edit Employee" onclick="editEmployee(this)" data-id="<?= $row['id'] ?>" data-fname="<?= $row['fname'] ?>" data-mname="<?= $row['mname'] ?>" data-lname="<?= $row['lname'] ?>" data-employee-id="<?= $row['emp_id_no'] ?>" data-department="<?= $row['dept'] ?>" data-contact="<?= $row['contact'] ?>" data-statedit="<?= $row['stat'] ?>" data-age="<?= $row['age'] ?>" data-gender="<?= $row['gender'] ?>" data-sports="<?= $row['sports'] ?>" data-team="<?= $row['team'] ?>" data-team-leader="<?= $row['team_leader'] ?>">
                                                                                    <?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
                                                                                        <i class="fa fa-edit"></i>
                                                                                    <?php endif ?>
                                                                                </a>
                                                                                <?php if (isset($_SESSION['username']) && $_SESSION['role'] == 'administrator') : ?>
                                                                                    <!-- <a type="button" data-toggle="tooltip" href="model/remove_employee.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to archive this employee?');" class="btn btn-link btn-danger" data-original-title="Remove">
                                                                                        <i class="fa fa-times"></i>
                                                                                    </a> -->
                                                                                    <!-- <a href="#" class="btn btn-link btn-danger" data-toggle="modal" data-target="#archiveEmployee<?= $row['id'] ?>">
                                                                                        <i class="fa fa-times"></i>
                                                                                    </a> -->
                                                                                <?php endif ?>
                                                                            </div>
                                                                        </td>


                                                                        <!-- Archive Employee -->
                                                                        <div class="modal fade" id="archiveEmployee<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <?php if (isset($_SESSION['username'])) : ?>
                                                                                        <form method="POST" action="model/remove_employee.php?id=<?= $row['id'] ?>">
                                                                                            <div class="modal-header">
                                                                                                <h5 class="modal-title" id="exampleModalLabel">Warning!</h5>
                                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                                    <span aria-hidden="true">&times;</span>
                                                                                                </button>
                                                                                            </div>
                                                                                            <div class="modal-body">
                                                                                                <div class="form-group form-floating-label">
                                                                                                    <label>Are you sure you want to archive this employee?</label>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="modal-footer">
                                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                                                                <button type="submit" class="btn btn-danger" name="emp_delete_multiple_btn">Archive</button>
                                                                                            </div>
                                                                                        </form>
                                                                                    <?php endif ?>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endif ?>

                                                                </tr>
                                                            <?php $no++;
                                                            endforeach ?>
                                                        <?php endif ?>
                                                    </tbody>
                                                    <tfoot>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Main Footer -->
        <?php include 'templates/main-footer.php' ?>
        <?php include 'templates/modals.php' ?>

    </div>

    </div>



    <?php include 'templates/footer.php' ?>
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#residenttable').DataTable();
        });

        $('#residenttable').dataTable( {
        "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]
        } );
    </script>


    <!-- import CSV -->
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

            selectEditor.on('submitComplete', function(e, json, data, action) {
                // Use the host Editor instance to show a multi-row create form allowing the user to submit the data.
                editor.create(csv.length, {
                    title: 'Confirm import',
                    buttons: 'Submit',
                    message: 'Click the <i>Submit</i> button to confirm the import of ' +
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
            fields: [{
                    label: 'First Name',
                    name: 'fname'
                },
                {
                    label: 'Middle Name',
                    name: 'mname'
                },
                {
                    label: 'Last Name',
                    name: 'lname'
                },
                {
                    label: 'Employee ID',
                    name: 'emp_id_no'
                },
                {
                    label: 'Department',
                    name: 'dept'
                },
                {
                    label: 'Contact',
                    name: 'contact'
                },
                {
                    label: 'Age',
                    name: 'age'
                },
                {
                    label: 'Gender',
                    name: 'gender'
                },
                {
                    label: 'Status',
                    name: 'stat'
                },
                {
                    label: 'Sports',
                    name: 'sports'
                }
            ]
        });

        // Upload Editor - triggered from the import button. Used only for uploading a file to the browser
        var uploadEditor = new DataTable.Editor({
            fields: [{
                label: 'CSV file:',
                name: 'csv',
                type: 'upload',
                ajax: function(files, done) {
                    // Ajax override of the upload so we can handle the file locally. Here we use Papa
                    // to parse the CSV.
                    Papa.parse(files[0], {
                        header: true,
                        skipEmptyLines: true,
                        complete: function(results) {
                            if (results.errors.length) {
                                console.log(results);
                                uploadEditor
                                    .field('csv')
                                    .error('CSV parsing error: ' + results.errors[0].message);
                            } else {
                                selectColumns(editor, results.data, results.meta.fields);
                            }

                            // Tell Editor the upload is complete - the array is a list of file
                            // id's, which the value of doesn't matter in this case.
                            done([0]);
                        }
                    });
                }
            }]
        });

        $('#residenttable').DataTable({
            ajax: '../php/staff.php',
            buttons: [{
                    extend: 'create',
                    editor: editor
                },
                {
                    extend: 'edit',
                    editor: editor
                },
                {
                    extend: 'remove',
                    editor: editor
                },
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
                    action: function() {
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
            columns: [{
                    data: 'fname'
                },
                {
                    data: 'mname'
                },
                {
                    data: 'lname'
                },
                {
                    data: 'emp_id_no'
                },
                {
                    data: 'dept'
                },
                {
                    data: 'contact'
                },
                {
                    data: 'age'
                },
                {
                    data: 'gender'
                },
                {
                    data: 'stat'
                },
                {
                    data: 'sports'
                }

                // { data: 'salary', render: DataTable.render.number(null, null, 0, '$') }
            ],
            dom: 'Bfrtip',
            select: true
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
			var team = document.getElementById("team");
            var team_leader = document.getElementById("team_leader");
       
            gender.value = null;
            sports.value = null;
            team.value = null;
            team_leader.value = null;


			var page = document.getElementById("page");
			page.value = "employees";

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
                        contact.value =  jsonObject.emp.contact;
                        stat.value =  jsonObject.emp.stat;
                        age.value =  jsonObject.emp.age;


                     
                        // Dept
                        var selectedDept = jsonObject.emp.dept;
                        if (selectedDept) {
                            
                            selectedDept = selectedDept.replace(/\s/g, '').toLowerCase();

                            for (let index = 0; index < deptOptions.length; index++) {

                                var optionValue = deptOptions[index].value;
                                optionValue = optionValue.replace(/\s/g, '').toLowerCase();

                                deptOptions[index].selected = (optionValue == selectedDept ?  deptOptions[index].value : null);
                            }
                        }

                        // Gender
                        var selectedGender = jsonObject.emp.gender;
                        if (selectedGender!=null) {
                            
                            selectedGender = selectedGender.replace(/\s/g, '').toLowerCase();
                                
                            for (let index = 0; index < genderOptions.length; index++) {

                                var optionValue = genderOptions[index].value;
                                optionValue = optionValue.replace(/\s/g, '').toLowerCase();
                                
                                genderOptions[index].selected = (optionValue == selectedGender ?  genderOptions[index].value : null);
                            }
                        }

                        // Teams
                        var selectedTeams = jsonObject.emp.team;

                        if (selectedTeams!=null) {
                            selectedTeams = selectedTeams.replace(/\s/g, '').toLowerCase();
    
                            for (let index = 0; index < teamOptions.length; index++) {
    
                                var optionValue = teamOptions[index].value;
                                optionValue = optionValue.replace(/\s/g, '').toLowerCase();
                                
                                teamOptions[index].selected = (optionValue == selectedTeams ?  teamOptions[index].value : null);
                            }
                            
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
                                    console.log("A");
                                    option.selected = true;
                                }else{
                                    console.log("B");
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
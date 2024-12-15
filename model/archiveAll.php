<?php
include '../server/server.php';

if (isset($_POST['emp_delete_multiple_btn'])) {

	if (!$_POST['emp_archive_id']) {
		header("Location: ../employees.php");
		
	}
	$all_id = $_POST['emp_archive_id'];
	
	$extract_id = implode(',', $all_id);
	
	if (!$all_id) {
		$_SESSION['message'] = "Please select at least one employee.";
		$_SESSION['success'] = "danger";
		header("Location: ../employees.php");
	}

	foreach ($all_id as $id) {
		
			$query 		= "UPDATE tbl_employee SET `status` = 3 WHERE emp_id_no=$id;";	
			$result 	= $conn->query($query);

			if($result === true){
				$_SESSION['message'] = 'Archived success!';
				$_SESSION['success'] = 'success';
			}else{
				$_SESSION['message'] = 'Achive failed!';
				$_SESSION['success'] = 'failed';
			}
		
	}

	// Move the data to tbl_archive before deleting from tbl_employee
	// $query = "
	// 		INSERT INTO tbl_archive (id, fname, mname, lname, emp_id_no, dept, age, gender, sports, team)
	// 		SELECT id, fname, mname, lname, emp_id_no, dept, age, gender, sports, team
	// 		FROM tbl_employee
	// 		WHERE emp_id_no IN ($extract_id)
	// 	";

	// Execute the query to insert into tbl_archive
	// $query_run = mysqli_query($conn, $query);

	// if ($query_run) {
	// 	// Now, delete the data from tbl_employee
	// 	$delete_query = "DELETE FROM tbl_employee WHERE emp_id_no IN ($extract_id)";
	// 	$delete_query_run = mysqli_query($conn, $delete_query);

	// 	if ($delete_query_run) {
	// 		$_SESSION['message'] = "The selected employees have been archived.";
	// 		$_SESSION['success'] = "success";
	// 	} else {
	// 		$_SESSION['message'] = "Failed to delete employee.";
	// 		$_SESSION['success'] = "danger";
	// 	}
	// } else {
	// 	$_SESSION['message'] = "Failed to archive employee. (Duplicated entries)";
	// 	$_SESSION['success'] = "danger";
	// }

	header("Location: ../employees.php");
}

?>
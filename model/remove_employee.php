<?php
include '../server/server.php';

if (!isset($_SESSION['username']) && $_SESSION['role'] != 'administrator') {
	if (isset($_SERVER["HTTP_REFERER"])) {
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
}

$id = $conn->real_escape_string($_GET['id']);

$query_select = "SELECT * FROM tbl_employee WHERE id = $id";
$result = mysqli_query($conn, $query_select);
echo $id;

// status 1:active, 2: restore , 3: deleted/archive

if ($result && mysqli_num_rows($result) > 0) {
	$row = mysqli_fetch_assoc($result);


	$query 		= "UPDATE tbl_employee SET `status` = 3 WHERE id=$id;";	
	$result 	= $conn->query($query);
	echo $id;
	if($result === true	){
		$_SESSION['message'] = 'Employee has been updated!';
		$_SESSION['success'] = 'success';
	}else{
		$_SESSION['message'] = 'Achive failed!';
		$_SESSION['success'] = 'failed';
	}

// 	// // Assuming the column names in tbl_archive are the same as tbl_employee.
// 	// $id = $row['id'];
// 	// $fname = $row['fname'];
// 	// $mname = $row['mname'];
// 	// $lname = $row['lname'];
// 	// $emp_id_no = $row['emp_id_no'];
// 	// $dept = $row['dept'];
// 	// $age = $row['age'];
// 	// $gender = $row['gender'];
// 	// $sports = $row['sports'];
// 	// $team = $row['team'];

// 	// // Add more columns as needed.

// 	// // Build the INSERT INTO query.
// 	// $query_insert = "INSERT INTO tbl_archive (id, fname, mname, lname, emp_id_no, dept, age, gender, sports, team) VALUES ('$id', '$fname', '$mname', '$lname', '$emp_id_no', '$dept', '$age', '$gender', '$sports', '$team')";
// 	// // Add more columns as needed.

// 	// // Execute the INSERT INTO query.
// 	// $insert_result = mysqli_query($conn, $query_insert);

// 	// // Check if the insertion was successful before proceeding to delete from tbl_employee.
// 	// if ($insert_result) {
// 	// 	// Step 3: Delete the row from tbl_employee.
// 	// 	$query_delete = "DELETE FROM tbl_employee WHERE id = '$id'";
// 	// 	$delete_result = mysqli_query($conn, $query_delete);

// 	// 	if ($delete_result) {
// 	// 		$_SESSION['message'] = 'Employee has been archived.';
// 	// 		$_SESSION['success'] = 'success';
// 	// 	} else {
// 	// 		$_SESSION['message'] = 'Error archiving from employee table.';
// 	// 		$_SESSION['success'] = 'danger';
// 	// 	}
// 	// } else {
// 	// 	$_SESSION['message'] = 'Error inserting into archive table.';
// 	// 	$_SESSION['success'] = 'danger';
// 	// }
}

header("Location: ../employees.php");
$conn->close();
	
	
	
	
	
	
	
	// $id 	= $conn->real_escape_string($_GET['id']);

	// if($id != ''){
	// 	$query 		= "DELETE FROM tbl_employee WHERE id = '$id'";
		
	// 	$result 	= $conn->query($query);
		
	// 	if($result === true){
    //         $_SESSION['message'] = 'Employee has been removed.';
    //         $_SESSION['success'] = 'danger';
            
    //     }else{
    //         $_SESSION['message'] = 'Something went wrong.';
    //         $_SESSION['success'] = 'danger';
    //     }
	// }else{

	// 	$_SESSION['message'] = 'Missing ID.';
	// 	$_SESSION['success'] = 'danger';
	// }

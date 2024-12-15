<?php
include '../server/server.php';

if (!isset($_SESSION['username'])) {
	if (isset($_SERVER["HTTP_REFERER"])) {
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
}

$fname 		= $conn->real_escape_string($_POST['fname']);
$mname 		= $conn->real_escape_string($_POST['mname']);
$lname 		= $conn->real_escape_string($_POST['lname']);
$employee_id 		= $conn->real_escape_string($_POST['emp_id_no']);
$age 		= $conn->real_escape_string($_POST['age']);
$gender 	= $conn->real_escape_string($_POST['gender']);
$contact 	= $conn->real_escape_string($_POST['contact']);
$stat 	= $conn->real_escape_string($_POST['stat']);
$dept 		= $conn->real_escape_string($_POST['dept']);


$sports = array();
if (isset($_POST["sportsAdd"])) {
	$sports = $_POST["sportsAdd"];
}

// change profile2 name
// $newName = date('dmYHis').str_replace(" ", "", $profile2);


$check = "SELECT id FROM tbl_employee WHERE emp_id_no='$employee_id' AND `status`!=3";
$nat = $conn->query($check)->num_rows;

if ($nat == 0) {
	if (!empty($fname)) {

		$query = "INSERT INTO tbl_employee (`fname`, `contact`,`stat`,`mname`, `lname`, `emp_id_no`, `age`, `gender`, `dept`,`status`) 
						VALUES ('$fname','$contact','$stat','$mname','$lname','$employee_id','$age','$gender','$dept',2)";

		$employeeStored = $conn->query($query);

		// Check if the query was successful
		if ($employeeStored) {
			// Get the last inserted ID
			$lastInsertedID = $conn->insert_id;

			foreach ($sports as $sport) {
				// create new if not found

				// find the sports id in sports table
				$checkSport2 = "SELECT * FROM tbl_sports WHERE `name` = '$sport' AND type IS NULL";
				$found3 = $conn->query($checkSport2)->fetch_assoc();
				
				$newName = $found3["name"];
			
				$query = "INSERT INTO tbl_sports (`emp_id`, `type`, `name`,`status`) VALUES ($lastInsertedID,2,'$newName',2)";
				$conn->query($query);

			}

			$_SESSION['message'] = 'Employee Information has been added.';
			$_SESSION['success'] = 'success';
		}
	} else {

		$_SESSION['message'] = 'Please complete all fields.';
		$_SESSION['success'] = 'danger';
	}
} else {
	$_SESSION['message'] = 'Employee ID is already taken. Please enter a unique employee ID.';
	$_SESSION['success'] = 'danger';
}
header("Location: ../employees.php");

$conn->close();

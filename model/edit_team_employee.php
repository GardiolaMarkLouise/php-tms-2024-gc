<?php 
	include '../server/server.php';

	if(!isset($_SESSION['username'])){
		if (isset($_SERVER["HTTP_REFERER"])) {
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
	}
	
    $id 	= $conn->real_escape_string($_POST['id']);
	$employee_id 		= $conn->real_escape_string($_POST['emp_id_no']);
	$fname 		= $conn->real_escape_string($_POST['fname']);
	$mname 		= $conn->real_escape_string($_POST['mname']);
    $lname 		= $conn->real_escape_string($_POST['lname']);
    $age 		= $conn->real_escape_string($_POST['age']);
	$gender 	= $conn->real_escape_string($_POST['gender']);
    $dept 		= $conn->real_escape_string($_POST['dept']);
	$sports 		= $conn->real_escape_string($_POST['sports']);
	$team 		= $conn->real_escape_string($_POST['team']);

	// change profile2 name
	// $newName = date('dmYHis').str_replace(" ", "", $profile2);

	
	$check = "SELECT id FROM tbl_employee WHERE emp_id_no='$employee_id'";
	$nat = $conn->query($check)->fetch_assoc();	


	if($nat['id'] == $id || count($nat) <= 0){
		if(!empty($id)){

			$query = "UPDATE tbl_employee SET `fname`='$fname', `mname`='$mname', `lname`='$lname', `emp_id_no`='$employee_id',
						`dept`='$dept', `age`='$age', `gender`='$gender', `sports`='$sports', `team`='$team' WHERE id=$id;";

			if($conn->query($query) === true){

				$_SESSION['message'] = 'Team member has been updated.';
				$_SESSION['success'] = 'success';

			}

		}else{

			$_SESSION['message'] = 'Please complete all fields.';
			$_SESSION['success'] = 'danger';
		}
	}else{
		$_SESSION['message'] = 'Employee ID is already taken. Please enter a unique employee ID.';
		$_SESSION['success'] = 'danger';
	}
    header("Location: ../teams.php");

	$conn->close();


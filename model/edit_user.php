<?php 
	include '../server/server.php';

	if(!isset($_SESSION['username'])){
		if (isset($_SERVER["HTTP_REFERER"])) {
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
	}
	
    $id 	= $conn->real_escape_string($_POST['id']);
	$username 	= $conn->real_escape_string($_POST['username']);
	$user_type 	= $conn->real_escape_string($_POST['user_type']);
	$acc_name 	= $conn->real_escape_string($_POST['acc_name']);
	$team_assigned 	= $conn->real_escape_string($_POST['team_assigned']);
	

	if(!empty($id)){

		$query 		= "UPDATE tbl_users SET `username`='$username', `acc_name`='$acc_name', `team_assigned`='$team_assigned' WHERE id=$id;";	
		$result 	= $conn->query($query);

		if($result === true){
            
			$_SESSION['message'] = 'Account has been updated.';
			$_SESSION['success'] = 'success';

		}else{

			$_SESSION['message'] = 'Something went wrong.';
			$_SESSION['success'] = 'danger';
		}

	}else{
		$_SESSION['message'] = 'No ID found.';
		$_SESSION['success'] = 'danger';
	}

    header("Location: ../manage_users.php");

	$conn->close();
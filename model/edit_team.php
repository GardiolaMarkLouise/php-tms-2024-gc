<?php 
	include '../server/server.php';

	if(!isset($_SESSION['username'])){
		if (isset($_SERVER["HTTP_REFERER"])) {
			header("Location: " . $_SERVER["HTTP_REFERER"]);
		}
	}
	
    $id 	= $conn->real_escape_string($_POST['id']);
	$team_name 	= $conn->real_escape_string($_POST['team_name']);
	$team_color 	= $conn->real_escape_string($_POST['team_color']);
	

	

	if(!empty($id)){

		
		$check = "SELECT * FROM tbl_teams WHERE id=$id";
		$result = $conn->query($check);
		$row = $result->fetch_array();

		$oldTeamName = $row["team_name"];
		
		$query 		= "UPDATE tbl_teams SET `team_name`='$team_name', `team_color`='$team_color' WHERE id=$id;";	
		$result 	= $conn->query($query);


		if($result === true){
            
			$query = "UPDATE tbl_employee SET `team`='$team_name' WHERE `team`='$oldTeamName' ";
			$conn->query($query);

			$_SESSION['message'] = 'Team has been updated.';
			$_SESSION['success'] = 'success';

		}else{

			$_SESSION['message'] = 'Something went wrong.';
			$_SESSION['success'] = 'danger';
		}

	}else{
		$_SESSION['message'] = 'No team found.';
		$_SESSION['success'] = 'danger';
	}

    header("Location: ../manage_teams.php");

	$conn->close();
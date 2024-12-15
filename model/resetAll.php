<?php
include '../server/server.php';

if (isset($_POST['emp_delete_multiple_btn_player'])) {

	if ($_POST['emp_delete_id'] != null) {
		$delete_id = $_POST['emp_delete_id'];
		$extract_id = implode(',', $delete_id);
		
		if (!$delete_id) {
			$_SESSION['message'] = "Please select at least one player.";
			$_SESSION['success'] = "danger";
			header("Location: ../teams.php");
		}
	
		$query = "UPDATE tbl_employee SET team = NULL WHERE emp_id_no IN($extract_id) AND status != 3";
		$query_run = mysqli_query($conn, $query);
	
		if($query_run)
		{
			$_SESSION['message'] = "The player's team has been removed.";
			$_SESSION['success'] = "success";
			header("Location: ../teams.php");
		}
		else
		{
			$_SESSION['message'] = "Please select the right information at the checkbox.";
			$_SESSION['success'] = "danger";
		}
	}else{
		$_SESSION['message'] = "Please select the right information at the checkbox.";
		$_SESSION['success'] = "danger";
	}
}
header("Location: ../teams.php");

?>
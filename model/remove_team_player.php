<?php
include '../server/server.php';

if (!isset($_SESSION['username']) && $_SESSION['role'] != 'administrator') {
	if (isset($_SERVER["HTTP_REFERER"])) {
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
}

$id 	= $conn->real_escape_string($_GET['id']);

if ($id != '') {
	$query 		= "UPDATE tbl_employee SET team = NULL WHERE id = '$id'";

	$result 	= $conn->query($query);

	if ($result === true) {
		$_SESSION['message'] = "The player's team has been removed.";
		$_SESSION['success'] = 'success';
	} else {
		$_SESSION['message'] = 'Something went wrong!';
		$_SESSION['success'] = 'danger';
	}
} else {

	$_SESSION['message'] = 'Missing User ID!';
	$_SESSION['success'] = 'danger';
}

header("Location: ../teams.php");
$conn->close();

?>
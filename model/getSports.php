<?php

include '../server/server.php';

if (!isset($_SESSION['username'])) {
	if (isset($_SERVER["HTTP_REFERER"])) {
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
}

$id = $conn->real_escape_string($_POST['id']);

$check = "SELECT * FROM tbl_sports WHERE emp_id=$id AND 'status'=2";
$result = $conn->query($check);


if ($result) {
    $sportsData = $result->fetch_assoc();
    // Assuming you want to return the sports data as JSON
    echo json_encode($sportsData);
} else {
    // Handle the case where the query fails
    echo json_encode(['error' => 'Query failed']);
}

$conn->close();

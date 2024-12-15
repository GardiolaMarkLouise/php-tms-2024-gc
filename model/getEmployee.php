<?php

include '../server/server.php';

if (!isset($_SESSION['username'])) {
	if (isset($_SERVER["HTTP_REFERER"])) {
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
}

$id = $conn->real_escape_string($_POST['id']);

$employee = "SELECT * FROM tbl_employee WHERE id=$id  AND status != 3";
$result_emp = $conn->query($employee);


if ($result_emp) {
    $employeeData = $result_emp->fetch_assoc();

    $sports = "SELECT * FROM tbl_sports WHERE emp_id=$id AND status=2 ";
    $result_sports = $conn->query($sports);

    $sportsData = array();
    
    if ($result_sports->num_rows > 0) {
        while ($row = $result_sports->fetch_array()) {
            $sportsData[] = $row["name"];
        }
    } 

    $responseData = array(
        'emp' => $employeeData,
        'sports' => $sportsData
    );
    
    echo json_encode($responseData);
    
} else {
    // Handle the case where the query fails
    echo json_encode(['error' => 'Query failed']);
}

$conn->close();

<?php

require("../server/server.php");

$item = $_POST["item"] ; 

// get Users
$query = "SELECT tbl_employee.fname,
                tbl_employee.mname,
                tbl_employee.lname,
                tbl_employee.emp_id_no,
                tbl_employee.dept,
                tbl_employee.contact,
                tbl_employee.age,
                tbl_employee.gender,
                tbl_employee.stat,
              				GROUP_CONCAT(DISTINCT CASE WHEN tbl_sports.status = 2 THEN tbl_sports.name END) as sports,
                tbl_employee.team 
                FROM tbl_employee 
                LEFT JOIN tbl_sports ON  tbl_sports.emp_id = tbl_employee.id 
                WHERE tbl_employee.team IS NOT NULL AND tbl_employee.status != 3
                ";
if ($_POST["item"] != "All Teams") {
    $query.="AND tbl_employee.team = '$item' GROUP BY tbl_employee.emp_id_no";
}else{
    $query.=" GROUP BY tbl_employee.emp_id_no";
}

if (!$result = $conn->query($query)) {
    exit($conn->error);
}

$users = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Set headers for CSV file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=teams.csv');

// Create and open the CSV file
$output = fopen('php://output', 'w');

// Write headers to the CSV file
fputcsv($output, array('First Name', 'Middle Name', 'Last Name', 'Employee ID', 'Department','Contact', 'Age', 'Sex', 'Status','Sports', 'Team'));

// Write data to the CSV file
if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}

// Close the CSV file
fclose($output);

// Close the database connection
$conn->close();

?>
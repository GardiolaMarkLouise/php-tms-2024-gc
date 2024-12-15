<?php

require("../server/server.php");

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
                WHERE tbl_employee.status != 3
                GROUP BY tbl_employee.emp_id_no
                ";
if (!$result = $conn->query($query)) {
    exit($conn->error);
}

$users = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Generate a filename based on the current date and time
$filename = 'employees_' . date('Ymd_His') . '.csv';

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);
$output = fopen('php://output', 'w');
fputcsv($output, array('First Name','Middle Name', 'Last Name', 'Employee ID', 'Department','Contact', 'Age', 'Sex', 'Status','Sports', 'Team'));

if (count($users) > 0) {
    foreach ($users as $row) {
        fputcsv($output, $row);
    }
}

?>
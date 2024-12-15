<?php

require("../server/server.php");


// Set headers for CSV file
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=teams.csv');

// Create and open the CSV file
$output = fopen('php://output', 'w');

// Write headers to the CSV file
fputcsv($output, array('First Name', 'Middle Name', 'Last Name', 'Employee ID', 'Department','Contact', 'Age', 'Sex', 'Status','Sports'));

// Close the CSV file
fclose($output);

// Close the database connection
$conn->close();

?>
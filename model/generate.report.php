<?php
include '../server/server.php';

// Retrieve the filter criteria from the POST request
$statusFilter = $_POST['statusFilter'];

// Modify the SQL query to fetch filtered data based on the status filter
$query = "SELECT emp_id_no, lname, fname, mname, dept, contact, age, gender, stat, team FROM tbl_employee WHERE `status` != 3 AND stat = '$statusFilter'";
$result = $conn->query($query);

// Set headers to force download
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=report.csv');

// Open a file handle in write mode to write CSV data
$output = fopen('php://output', 'w');

// Write the CSV header row
fputcsv($output, ['Employee ID', 'Full Name', 'Department', 'Contact', 'Age', 'Sex', 'Status', 'Team']);

// Loop through the database query result and write each row to the CSV file
while ($row = $result->fetch_assoc()) {
    // Extract contact number if it's not null
    $contact = !empty($row['contact']) ? $row['contact'] : '';
    
    // Format the row data as an array
    $rowData = [
        $row['emp_id_no'],
        $row['lname'] . ', ' . $row['fname'] . ' ' . $row['mname'],
        $row['dept'],
        $contact,
        $row['age'],
        $row['gender'],
        $row['stat'],
        $row['team']
    ];

    // Write the formatted row data to the CSV file
    fputcsv($output, $rowData);
}

// Close the file handle
fclose($output);

// Close database connection
$conn->close();
?>

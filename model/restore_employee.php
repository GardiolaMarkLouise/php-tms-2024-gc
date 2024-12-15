<?php
include '../server/server.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'administrator') {
    // Redirect unauthorized users to the login page or any other page you want.
    header("Location: ../login");
}

        if ($result->num_rows > 0) {

// $check = "SELECT * FROM tbl_employee WHERE `status` = 3 ";
$check = "SELECT tbl_employee.*
          FROM tbl_employee
          WHERE `status` = 3
            AND (`emp_id_no`, `created_at`) IN (
              SELECT `emp_id_no`, MAX(`created_at`) as latest_timestamp
              FROM tbl_employee
              WHERE `status` = 3
              GROUP BY `emp_id_no`
            )";

$nat = $conn->query($check);
while ($row = $nat->fetch_assoc()) {
    $id = $row["id"];
 
    $query 		= "UPDATE tbl_employee SET `status` = 2 WHERE id=$id;";	
    $result 	= $conn->query($query);

    if($result === true	){
        $_SESSION['message'] = 'Employee is restored!';
        $_SESSION['success'] = 'success';
        header("Location: ../employees.php");   
    }else{
        $_SESSION['message'] = 'Restore failed!';
        $_SESSION['success'] = 'failed';
        header("Location: ../employees.php");

        }
    
    }
} else {
    $_SESSION['message'] = "No data found in the archive table.";
    $_SESSION['success'] = "danger";
    header("Location: ../employees.php");
}

// Query to select data from tbl_archive
// $archiveQuery = "SELECT * FROM tbl_archive";

// // Execute the query
// $result = $conn->query($archiveQuery);

// Check if there are any rows in the archive table
// if ($result->num_rows > 0) {
//     // Prepare the insert query for tbl_employee
//     $insertQuery = "INSERT INTO tbl_employee (id, fname, mname, lname, emp_id_no, dept, age, gender, sports, team) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

//     // Prepare a statement to avoid SQL injection
//     $stmt = $conn->prepare($insertQuery);

//     // Bind variables to the prepared statement
//     $stmt->bind_param("isssisisss", $id, $fname, $mname, $lname, $emp_id_no, $dept, $age, $gender, $sports, $team);

//     // Loop through the archive data and insert into tbl_employee
//     while ($row = $result->fetch_assoc()) {
//         // Replace 'column1', 'column2', and 'column3' with actual column names from tbl_employee
//         $id = $row['id'];
//         $fname = $row['fname'];
//         $mname = $row['mname'];
//         $lname = $row['lname'];
//         $emp_id_no = $row['emp_id_no'];
//         $dept = $row['dept'];
//         $age = $row['age'];
//         $gender = $row['gender'];
//         $sports = $row['sports'];
//         $team = $row['team'];

//         // Execute the insert statement
//         $stmt->execute();
//     }

//     // Close the prepared statement
//     $stmt->close();

//     // Delete all data from tbl_archive
//     $deleteQuery = "DELETE FROM tbl_archive";
//     if ($conn->query($deleteQuery) === TRUE) {
//         $_SESSION['message'] = "All archived employees have been restored.";
//         $_SESSION['success'] = "success";
//         header("Location: ../employees.php");
//     } else {
//         $_SESSION['message'] = "Error deleting data from the archive table.";
//         $_SESSION['success'] = "danger";
//         header("Location: ../employees.php");
//     }
// } else {
//     $_SESSION['message'] = "No data found in the archive table.";
//     $_SESSION['success'] = "danger";
//     header("Location: ../employees.php");
// }

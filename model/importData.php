<?php
// Load the database configuration file
include '../server/server.php';

if (!isset($_SESSION['username'])) {
    if (isset($_SERVER["HTTP_REFERER"])) {
        header("Location: " . $_SERVER["HTTP_REFERER"]);
    }
}

if (isset($_POST['importSubmit'])) {

    // Allowed mime types
    $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

    // Validate whether selected file is a CSV file

    if (!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'], $csvMimes)) {

        // If the file is uploaded
        if (is_uploaded_file($_FILES['file']['tmp_name'])) {

            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['file']['tmp_name'], 'r');

            // Skip the first lines
            fgetcsv($csvFile);

            // Parse data from CSV file line by line
        
            while (($line = fgetcsv($csvFile)) !== FALSE) {
          
                $emp_id = $line[3];
                $queryCheck = "SELECT * FROM tbl_employee WHERE emp_id_no = $emp_id AND `status` != 3";
                $result2 = $conn->query($queryCheck);
            
    
                if ($result2->num_rows > 0) {
                
            
                    $row = $result2->fetch_assoc();
    
                    $_SESSION['message'] =  'ID: '.$row['emp_id_no'].' is already exist.';
                    $_SESSION['success'] = 'danger';
                    $qstring = '?status=err';
    
                    header("Location: ../employees.php");
                    exit();
                }

                // Check whether member already exists in the database with the same email
                // $prevQuery = "SELECT id FROM tbl_employee WHERE  `status` != 3 AND emp_id_no = '" . $line[4] . "' ";
                // $prevResult = $conn->query($prevQuery);

                // Prepare the SQL statement
                $stmt = $conn->prepare("INSERT INTO tbl_employee (fname, mname, lname, emp_id_no, dept,contact, age, gender,stat,status) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?,2)");

                // Bind parameters
                $stmt->bind_param("sssssssss",$fname, $mname, $lname, $emp_id_no, $dept,$contact, $age, $gender,$stat);

                // Set parameter values
                $fname =    $line[0];
                $mname =    $line[1];
                $lname =    $line[2];
                $emp_id_no =$line[3];
                $dept =     $line[4];
                $contact =     $line[5];
                $age =      $line[6];
                $gender =   $line[7];
                $stat =   $line[8];
                $sports =   $line[9];

                // Execute the statement
                 $stmt->execute();

                 $lastInsertedID = $conn->insert_id;

                $sportsArray = explode(',', $sports);

                foreach ($sportsArray as $sport) {

                    // Remove spaces
                    $modifySport = strtolower(str_replace(' ', '', $sport));

                    $checkSport = "SELECT * FROM tbl_sports WHERE REPLACE(LOWER(name), ' ', '') = '$modifySport' AND type IS NULL";
                    $found = $conn->query($checkSport)->fetch_assoc();
                    
                    if ($found) {
                        $newName = $found["name"];
                    
                        $query = "INSERT INTO tbl_sports (`emp_id`, `type`, `name`,`status`) VALUES ($lastInsertedID,2,'$newName',2)";
                        $conn->query($query);
        
                    }
                }
                
                

            }
        

            // Close opened CSV file
            fclose($csvFile);

            $qstring = '?status=succ';

            $_SESSION['message'] = 'CSV has been imported.';
            $_SESSION['success'] = 'success';
        } else {
            

            $qstring = '?status=err';

            $_SESSION['message'] = 'Error: Something went wrong.';
            $_SESSION['success'] = 'danger';
        }
    } else {
        $qstring = '?status=invalid_file';

    }
}

// Redirect to the listing page
// header("Location: index.php".$qstring);
header("Location: ../employees.php");

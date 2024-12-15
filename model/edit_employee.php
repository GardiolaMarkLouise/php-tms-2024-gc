<?php
include '../server/server.php';

if (!isset($_SESSION['username'])) {
	if (isset($_SERVER["HTTP_REFERER"])) {
		header("Location: " . $_SERVER["HTTP_REFERER"]);
	}
}

$id 		= $conn->real_escape_string($_POST['real_id']);
$employee_id= $conn->real_escape_string($_POST['emp_id_no']);
$fname 		= $conn->real_escape_string($_POST['fname']);
$mname 		= $conn->real_escape_string($_POST['mname']);
$lname 		= $conn->real_escape_string($_POST['lname']);
$age 		= $conn->real_escape_string($_POST['age']);
$gender 	= $conn->real_escape_string($_POST['gender']);
$dept 		= $conn->real_escape_string($_POST['department']);
$contact 	= $conn->real_escape_string($_POST['contact']);
$stat 		= $conn->real_escape_string($_POST['stat']);
$team 		= $conn->real_escape_string($_POST['team']);
$team_leader 		= $conn->real_escape_string($_POST['team_leader']);

$page 		= $_POST['page'];

$sports = null;

if(isset($_POST['sports']))
{
	$sports = $_POST['sports'];
}

// change profile2 name
// $newName = date('dmYHis').str_replace(" ", "", $profile2);

$checkID = null;
$duplicateEmp = null;

$check = "SELECT id,emp_id_no FROM tbl_employee WHERE `id`=$id";
$nat = $conn->query($check);
while ($row = $nat->fetch_assoc()) {
	$checkID =  $row["id"] ;
	$duplicateEmp = $row["emp_id_no"] ;
}

$checkEmp = null;

$duplicatecheck = "SELECT emp_id_no FROM tbl_employee WHERE `emp_id_no`=$employee_id";
$duplicate = $conn->query($duplicatecheck);
while ($row = $duplicate->fetch_assoc()) {
	$checkEmp =  $row["emp_id_no"] ;
}


$is_duplicate = null;

if ($checkEmp != null) {
	if($duplicateEmp != $employee_id){
		$is_duplicate = true;
	}
}

if ($is_duplicate != true) {

	if (!empty($id)) {

		$query = "UPDATE tbl_employee SET `fname`='$fname', `mname`='$mname', `lname`='$lname', `emp_id_no`='$employee_id',
						`contact`='$contact',`stat`='$stat',`dept`='$dept', `age`='$age', `gender`='$gender', `team_leader`='$team_leader'
						 ";

		// Add a condition to check if status is "On-Leave" and team has a value
        if (($stat == "On-Leave" && !empty($team)) || 
            ($stat == "On Official Business" && !empty($team)) || 
            ($stat == "On Official Time" && !empty($team))) {
            $_SESSION['message'] = 'OL / OT / OB status cannot have a Team.';
            $_SESSION['success'] = 'danger';
        } else {
            $query = "UPDATE tbl_employee SET `fname`='$fname', `mname`='$mname', `lname`='$lname', `emp_id_no`='$employee_id',
                        `contact`='$contact',`stat`='$stat',`dept`='$dept', `age`='$age', `gender`='$gender', `team_leader`='$team_leader'
                             ";
            if ($team != null && $team != "") {
                $query .= ",`team`='$team'";
            }


			if ($team != null && $team != "") {
				$query.= ",`team`='$team'";
			}	  
			$query.= " WHERE id=$id ";

			// saving multiple data sport
			if ($conn->query($query) === true) {

					// deactivate all the sports user has and activate all the selected one
					$query = "UPDATE tbl_sports SET `status`= 3 WHERE emp_id=$id ";
					$conn->query($query);

					if($sports != null){
						foreach ($sports as $sport) {
							echo $sport."-".$id;
							// check sport of employee if already exist
							$checkSport = "SELECT id FROM tbl_sports WHERE emp_id=$id AND `name` = '$sport' AND `type`=2";
							$found = $conn->query($checkSport)->fetch_assoc();
							
							// update the sport if found 
							if ($found) {
								
								foreach ($found as $sport_id) {
									$query = "UPDATE tbl_sports SET `status`= 2 WHERE id=$sport_id ";
									$conn->query($query);
								}
							}else{
								// create new if not found

								// find the sports id in sports table
								$checkSport2 = "SELECT * FROM tbl_sports WHERE `name` = '$sport' AND type IS NULL";
								$found3 = $conn->query($checkSport2)->fetch_assoc();
								
								$newName = $found3["name"];
								echo $found3["name"];
								$query = "INSERT INTO tbl_sports (`emp_id`, `type`, `name`,`status`) VALUES ($id,2,'$newName',2)";
								$conn->query($query);


							}
						}
					}
				$_SESSION['message'] = 'Employee Information has been updated.';
				$_SESSION['success'] = 'success';
			}
		}
	} else {

		$_SESSION['message'] = 'Please complete all fields.';
		$_SESSION['success'] = 'danger';
	}
} else {
	$_SESSION['message'] = 'Employee ID is already taken. Please enter a unique employee ID.';
	$_SESSION['success'] = 'danger';
}

header("Location: ../".$page.".php");

$conn->close();



<!-- shuffle -->
<?php

include '../server/server.php';


// Function to shuffle an array while preserving keys
function shuffle_assoc(&$array)
{
    $keys = array_keys($array);
    shuffle($keys);
    $shuffledArray = array();
    foreach ($keys as $key) {
        $shuffledArray[$key] = $array[$key];
    }
    $array = $shuffledArray;
}

// Function to group employees into random teams with fairness
function groupEmployeesIntoRandomTeams($employees, $numTeams)
{
    // Shuffle employees randomly
    shuffle($employees);

    $teams = array();

    // Create empty teams
    for ($i = 0; $i < $numTeams; $i++) {
        $teams[$i] = array();
    }

    // Distribute employees to teams evenly
    $teamIndex = 0;
    foreach ($employees as $employee) {
        $teams[$teamIndex][] = $employee;
        $teamIndex = ($teamIndex + 1) % $numTeams;
    }

    // Remove duplicates from teams
    foreach ($teams as &$team) {
        $team = array_unique($team, SORT_REGULAR);
    }

    return $teams;
}

if (isset($_POST["submitShuffle"])) {

    $ageStart = $_POST['age_start'];
    // $ageEnd = $_POST['age_end'];

    $sql = "SELECT * FROM tbl_employee WHERE stat = 'Fit' AND `status`!=3 ";
    $teamSizeSQL = "SELECT COUNT(*) as teamCount FROM tbl_teams ";
    $result = $conn->query($teamSizeSQL);

    $row = $result->fetch_assoc();


    $teamSize = $row["teamCount"]; // ! team length

    // Assuming the form is submitted and you are processing the data
    if (isset($_POST['age_start'])) {
        $selectedValue = $_POST['age_start'];

        // Determine the age range based on the selected value
        if ($selectedValue == "All") {
            $ageStart = 21;
            $ageEnd = 65;
        }
        if ($selectedValue == "21") {
            $ageStart = 21;
            $ageEnd = 30;
        }
        if ($selectedValue == "31") {
            $ageStart = 31;
            $ageEnd = 40;
        }
        if ($selectedValue == "41") {
            $ageStart = 41;
            $ageEnd = 50;
        }
        if ($selectedValue == "51") {
            $ageStart = 51;
            $ageEnd = 60;
        }
        if ($selectedValue == "61") {
            $ageStart = 61;
            $ageEnd = 65;
        } else {
            // Handle other age options here if needed
        }
    }

    if (isset($_POST['genders'])) {
        $selectedGender = $_POST['genders'];
        if ($selectedGender === "All") {
            $genderCondition = "";
        } else {
            $genderCondition = " AND gender = '$selectedGender' ";
        }
    } else {
        // Handle other gender options here if needed
        $genderCondition = "";
    }

    if ($ageStart != null && $ageEnd != null) {

        $sql .= " AND age >= $ageStart AND age <= $ageEnd  $genderCondition";
    }
    if ($ageStart != null && $ageEnd == null) {
        $sql .= " AND age >= $ageStart AND $genderCondition";
    }
    echo $sql;
    $result = $conn->query($sql);
    $employees = array();

    while ($row = $result->fetch_array()) {
       
        $data = array(
            "id" => $row["id"],
            "fname" => $row["fname"],
            "mname" => $row["mname"],
            "lname" => $row["lname"],
            "emp_id_no" => $row["emp_id_no"],
            "dept" => $row["dept"],
            "age" => $row["age"],
            "gender" => $row["gender"],
            "sports" => $row["sports"],
            "team" => $row["team"],
        );
        array_push($employees, $data);
    }

    // Define the number of employees per team, lets say 3

    $teams = groupEmployeesIntoRandomTeams($employees, $teamSize);

    // Convert teams into a simple indexed array for easier access
    $resultingTeams = array_values($teams);

    $ids = array();
    $teamsData = array();

    // Display the teams
    // echo "Random Teams with Fairness:<br>";
    foreach ($resultingTeams as $teamIndex => $team) {
        // echo "Team " . ($teamIndex + 1) . ":<br>";
        foreach ($team as $employee) {
            $ids = array(
                "id" => $employee["id"],
                "gender" => $employee["gender"],
                "team" => $teamIndex,
            );
            array_push($teamsData, $ids);
        }
    }

    $teamNames = "SELECT team_name FROM tbl_teams ";
    $teams = $conn->query($teamNames);

    $DBTeamName = array();
    while ($row = $teams->fetch_array()) {
        array_push($DBTeamName,$row[0]);
    }


    $caseQuery = '';
    foreach ($teamsData as $i => $key) {
        $id = $key['id'];
        $teamNumber = $key['team'];
        $name = $DBTeamName[$teamNumber];
        $caseQuery .= "WHEN $id THEN '$name' ";
    }

    $sql = "UPDATE tbl_employee SET team = CASE id $caseQuery END WHERE id IN (" . implode(',', array_column($teamsData, 'id')) . ")";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "All selected employees have been shuffled.";
        $_SESSION['success'] = "success";
    } else {
        $_SESSION['message'] = "Error updating records: " . $conn->error;
        $_SESSION['success'] = "danger";
    }

    header("Location: ../teams.php");
    exit();
   
}

?>
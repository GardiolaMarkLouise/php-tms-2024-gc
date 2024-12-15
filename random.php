<?php
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

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tms_db_new";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if(isset($_POST["submitShuffle"])) {

    $ageStart = $_POST['age_start'];
    // $ageEnd = $_POST['age_end'];
    $teamSize = 6; // fixed size
   
    $sql = "SELECT * FROM tbl_employee ";

    // Assuming the form is submitted and you are processing the data
    if (isset($_POST['age_start'])) {
        $selectedValue = $_POST['age_start'];
    
        // Determine the age range based on the selected value
        if ($selectedValue == "All") {
            $ageStart = 21;
            $ageEnd = 90;
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
            $ageEnd = 70;
        } 
        if ($selectedValue == "71") {
            $ageStart = 71;
            $ageEnd = 80;
        }
        if ($selectedValue == "81") {
            $ageStart = 81;
            $ageEnd = 90;
        }    
        else {
        // Handle other age options here if needed
        }
    
        // Now you have $ageStart and $ageEnd representing the selected age range (21 to 30 in this case)
        // You can use them for further processing or database queries
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

        $sql.= " WHERE age >= $ageStart AND age <= $ageEnd $genderCondition";
    }
    if ($ageStart != null && $ageEnd == null){
        $sql.= " WHERE age >= $ageStart $genderCondition";
    }

    $result = $conn->query($sql);
    $employees = array();
   
    while($row = $result->fetch_assoc()) {
    
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
    echo "Random Teams with Fairness:<br>";
    foreach ($resultingTeams as $teamIndex => $team) {
        echo "Team " . ($teamIndex + 1) . ":<br>";
        foreach ($team as $employee) {
            
            echo $employee["id"]."- " . $employee["fname"]." ". $employee["mname"]." ". $employee["lname"]." ". "(".$employee["gender"].")"."<br>";
            
            $ids = array(
                "id" => $employee["id"],
                "gender" => $employee["gender"],
                "team" => $teamIndex,
            );
            array_push($teamsData, $ids);
        }
    }

    foreach($teamsData as $key ) {

        $id = $key['id'] ;
        $teamNumber = $key['team'] + 1;

        $sql = "UPDATE tbl_employee SET team = CONCAT('Team ', $teamNumber) WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            // echo $key['id']. "=". ($key['team'] + 1)."<br>";
            
        } else {
            echo "Error updating record: " . $conn->error;
        }

    }

}



?>

<html>

<head>

</head>

<body>
    <form method="POST">
        <label for="age_start">Age Start:</label>
        <select name="age_start" id="age_start">
            <option value="All">All Ages</option>
            <option value="21">21 to 30</option>
            <option value="31">31 to 40</option>
            <option value="41">41 to 50</option>
            <option value="51">51 to 60</option>
            <option value="61">61 to 65</option>
        </select>

        <label for="genders">Gender:</label>
        <select name="genders" id="genders">
            <option value="All">All Genders</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
        
        <button type="submit" name="submitShuffle">Shuffle</button>
    </form>

</body>
</html>
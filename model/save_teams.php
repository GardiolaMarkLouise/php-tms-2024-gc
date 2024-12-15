<?php 
	include('../server/server.php');

    if(!isset($_SESSION['username'])){
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

	$team 	= $conn->real_escape_string($_POST['team_name']);
    $team_color 	= $conn->real_escape_string($_POST['team_color']);
    
    

    if(!empty($team)){

        $query = "SELECT * FROM tbl_teams WHERE name='$team'";
        $res = $conn->query($query);

        if($res->num_rows){
            $_SESSION['message'] = 'Please enter a unique team!';
            $_SESSION['success'] = 'danger';
        }else{
            
                $insert  = "INSERT INTO tbl_teams (`team_name`, `team_color`) VALUES ('$team', '$team_color')";
                $result  = $conn->query($insert);
                
                if($result === true){
                    $_SESSION['message'] = 'Team has been added.';
                    $_SESSION['success'] = 'success';
    
                }else{
                    $_SESSION['message'] = 'Something went wrong!';
                    $_SESSION['success'] = 'danger';
                }
            
        }
        
    }else{

        $_SESSION['message'] = 'Please fill up the form completely!';
        $_SESSION['success'] = 'danger';
    }

    header("Location: ../manage_teams.php");

	$conn->close();

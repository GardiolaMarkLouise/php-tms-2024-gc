<?php 
	include('../server/server.php');

    if(!isset($_SESSION['username'])){
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

	$depts 	= $conn->real_escape_string($_POST['name']);
    
    

    if(!empty($depts)){

        $query = "SELECT * FROM tbl_dept WHERE name='$depts'";
        $res = $conn->query($query);

        if($res->num_rows){
            $_SESSION['message'] = 'Please enter a unique department.';
            $_SESSION['success'] = 'danger';
        }else{
            
                $insert  = "INSERT INTO tbl_dept (`name`) VALUES ('$depts')";
                $result  = $conn->query($insert);
                
                if($result === true){
                    $_SESSION['message'] = 'Department has been created.';
                    $_SESSION['success'] = 'success';
    
                }else{
                    $_SESSION['message'] = 'Something went wrong!';
                    $_SESSION['success'] = 'danger';
                }
            
        }
        
    }else{

        $_SESSION['message'] = 'Please fill up the form completely.';
        $_SESSION['success'] = 'danger';
    }

    header("Location: ../manage_depts.php");

	$conn->close();

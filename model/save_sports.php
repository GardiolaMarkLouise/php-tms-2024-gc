<?php 
	include('../server/server.php');

    if(!isset($_SESSION['username'])){
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

	$sport 	= $conn->real_escape_string($_POST['name']);
    
    

    if(!empty($sport)){

        $query = "SELECT * FROM tbl_sports WHERE name='$sport' AND type IS NULL";
        $res = $conn->query($query);

        if($res->num_rows){
            $_SESSION['message'] = 'Please enter a unique sport!';
            $_SESSION['success'] = 'danger';
        }else{
            
                $insert  = "INSERT INTO tbl_sports (`name`) VALUES ('$sport')";
                $result  = $conn->query($insert);
                
                if($result === true){
                    $_SESSION['message'] = 'Sport has been added.';
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

    header("Location: ../manage_sports.php");

	$conn->close();

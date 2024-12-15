<?php 
	include '../server/server.php';

	$username 	= $conn->real_escape_string($_POST['username']);
	$password	= sha1($conn->real_escape_string($_POST['password']));


	if($username != '' AND $password != ''){
		$query 		= "SELECT * FROM tbl_users WHERE username = '$username' AND password = '$password'";
		
		$result 	= $conn->query($query);
		
		if($result->num_rows){
			while ($row = $result->fetch_assoc()) {
				$_SESSION['id'] = $row['id'];
				$_SESSION['username'] = $row['username'];
				$_SESSION['role'] = $row['user_type'];
				// $_SESSION['avatar'] = $row['avatar'];
				$_SESSION['acc_name'] = $row['acc_name'];
				$_SESSION['team_assigned'] = $row['team_assigned'];
			}

			$_SESSION['message'] = 'You have successfully logged in!';
			$_SESSION['success'] = 'success';

            header('location: ../dashboard');

		}else{
			$_SESSION['message'] = 'Username or password is incorrect!';
			$_SESSION['success'] = 'danger';
            header('location: ../login');
		}
	}else{
		$_SESSION['message'] = 'Username or password is empty!';
		$_SESSION['success'] = 'danger';
        header('location: ../login');
	}

    

	$conn->close();


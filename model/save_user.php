<?php 
    include('../server/server.php');

    if (!isset($_SESSION['username'])) {
        if (isset($_SERVER["HTTP_REFERER"])) {
            header("Location: " . $_SERVER["HTTP_REFERER"]);
        }
    }

    $user  = $conn->real_escape_string($_POST['username']);
    $pass  = sha1($conn->real_escape_string($_POST['password']));
    $acc_name  = $conn->real_escape_string($_POST['acc_name']);

    if (!empty($user) && !empty($pass) && !empty($acc_name)) {
        $query = "SELECT * FROM tbl_users WHERE username='$user'";
        $res = $conn->query($query);

        if ($res->num_rows) {
            $_SESSION['message'] = 'Please enter a unique username!';
            $_SESSION['success'] = 'danger';
        } else {
            $insert  = "INSERT INTO tbl_users (`username`, `password`, `user_type`, `acc_name` ) VALUES ('$user' ,'$pass','administrator','$acc_name')";
            $result  = $conn->query($insert);

            if ($result === true) {
                $_SESSION['message'] = 'Account added.';
                $_SESSION['success'] = 'success';
            } else {
                $_SESSION['message'] = 'Something went wrong!';
                $_SESSION['success'] = 'danger';
            }
        }
    } else {
        $_SESSION['message'] = 'Please fill up the form completely!';
        $_SESSION['success'] = 'danger';
    }

    header("Location: ../manage_users.php");
    $conn->close();
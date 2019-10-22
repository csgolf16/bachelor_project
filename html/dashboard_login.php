<?php

    require './dbcon.php';

    $dbcon = mysqli_connect($servername, $username, $password, $database) or die('Failed to connect to MySQL: '.mysqli_connect_error()); 
    mysqli_set_charset($dbcon, 'utf8');
    
    $login_username = mysqli_real_escape_string($dbcon, $_POST['username_input']);
    $login_password = mysqli_real_escape_string($dbcon, $_POST['password_input']);
    $query          = "SELECT * FROM user WHERE user_username=? AND user_password=?";
    $stmt           = mysqli_prepare($dbcon, $query);
    mysqli_stmt_bind_param($stmt, "ss", $login_username, $login_password);
    mysqli_execute($stmt);
    
    $result = mysqli_stmt_get_result($stmt);
    if ($result->num_rows == 1) {
        session_start();
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $_SESSION['login_username'] = $row['user_username'];
        header("Location: ./dashboard.php");
    } else {
        echo ("<script type='text/javascript'> window.alert('username or password is invalid.'); window.location.href='index.php'; </script>");
    }
?>
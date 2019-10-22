<?php
    session_start(); 
    if (isset($_SESSION['login_username'])) {
        header("Location: ./dashboard.php");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | ESP8266Cloud</title>
    <link rel="stylesheet" href="./public/css/bootstrap.min.css">
    <script src="./public/js/jquery.min.js"></script>
    <script src="./public/js/bootstrap.min.js"></script>
</head>

<body style="background-color: gray;">
    <div class="container">
        <div class="col-lg-4"></div>
        <div class="col-lg-4">
            <div class="jumbotron" style="background-color: white; margin-top: 80px;">
                <div align="center">
                    <h3>Please Login</h3>
                    <br>
                    <figure>
                        <img src="./public/images/kmutnb.png" height="150px" width="150px">
                    </figure>
                    <br>
                </div>
                <form action="./dashboard_login.php" method="POST">
                    <div class="form-group">
                        <input class="form-control" autofocus="" type="text" name="username_input" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <input class="form-control" type="password" name="password_input" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <input class="btn btn-info form-control" type="submit" value="Login">
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-4"></div>
    </div>
</body>

</html>
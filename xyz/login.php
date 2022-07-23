<?php

require_once('../include/config.php');
if ($user->is_logged_in()) {
    header('location:index.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="asset/login.css">
</head>

<body>
    <?php
    if (isset($_POST['submit'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        if ($user->login($username, $password)) {
            header('location:index.php');
            exit;
        } else {
            $message = '<p>Inavlid username or password</p>';
        }
    }
    if (isset($message)) {
        echo $message;
    }

    ?>

    <div class="container">
        <h1>Sign In</h1>
        <form action="" method="POST">
            <div class="box">
                <i class="fa fa-envelope"></i>
                <input type="text" name="username" id="username" placeholder="Username">

            </div>
            <div class="box">

                <i class="fa fa-key"></i>
                <input type="password" name="password" id="password" placeholder="Enter your password">
            </div>
            <button class="btn" type="submit" name="submit">Sign in </button>
        </form>
    </div>
</body>

</html>
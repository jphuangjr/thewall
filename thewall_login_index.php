<?php session_start();
?>

<!DOCTYPE html>
    <html lang="en">
        <head>
            <title>The Wall Login</title>
            <meta charset="utf-8">
            <meta name="description" content="The WALL">
            <meta name="author" content="The WALL">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="normalize.css">
            <link rel="stylesheet" href="skeleton.css">
            <style>
                h3{
                    text-align: center;
                    text-decoration: underline;
                }
                form{
                    text-align: center;
                }
                h4{
                    text-align: center;
                }
                .error{
                    color:red;
                    text-align:center;
                }
                .success{
                    color:green;
                    text-align:center;
                }
            </style>
        </head>

        <body>
        <div class="container">
            <div class="row">
                <div class="twelve columns" style="margin-top: 2%">
                    <h3>The WALL</h3>

                    <?php

                    if(isset($_SESSION['errors'])) {
                        foreach ($_SESSION['errors'] as $error) {
                            echo "<p class='error'>{$error}</p><br>";
                        }
                        unset($_SESSION['errors']);
                    }

                    if(isset($_SESSION['register_success'])){
                        echo "<p class='success'>{$_SESSION['register_success']}</p>";
                        unset($_SESSION['register_success']);
                    }
                    ?>

                </div>
            </div>
            <div class="row">
                <div class="twelve columns" style="margin-top: 3%">
                    <h4>Login</h4>
                </div>
            </div>
            <div class="row">
                <div class="twelve columns">
                    <form action="thewall_process.php" method="post">

                        Email: <input type="email" name="login_email"> &nbsp
                        Password: <input type="Password" name="login_password"> &nbsp
                        <input class="button-primary" type="submit" name="login_button" value="submit">
                        <input type="hidden" name="action" value="login">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="twelve columns">
                    <h4>Or Register</h4>
                </div>
            </div>
            <div class="row">
                <div class="twelve columns">
                    <form action="thewall_process.php" method="post">
                        First Name: <input type="text" name="first_name">
                        Last Name: <input type="text" name="last_name">
                        Email: <input type="email" name="register_email"><br>
                        Password: <input type="Password" name="register_password">
                        Confirm Password: <input type="Password" name="register_password_confirm"> &nbsp
                        <input class="button-primary" type="submit" name="register_button">
                        <input type="hidden" name="action" value="register">
                    </form>
                </div>
            </div>

        </div>
        </body>

    </html>


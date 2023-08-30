<script type="text/javascript" src="scripts/login-script.js"></script>

<?php
include('php/db-connect.php');

$page = 'login';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $email = $_REQUEST['email'];
    $password = $_REQUEST['password'];

    $validLogin = mysqli_query($con, "SELECT guestID FROM guest WHERE email = '$email' AND password = '$password'");
    $uname = mysqli_fetch_array(mysqli_query($con, "SELECT firstName FROM guest WHERE email = '$email' AND password = '$password'"), MYSQLI_ASSOC);
    $id = mysqli_fetch_array($validLogin, MYSQLI_ASSOC);
    $count = mysqli_num_rows($validLogin);

    if(empty($email) || empty($password)) {
        echo '
        <script>
            emptyForm();
        </script>';
        die;
    }else if ($count == 1) {
        session_start();
        $_SESSION['sessionID'] = $id['guestID'];
        $_SESSION['username'] = $uname['firstName'];

        echo '
        <script type="text/javascript">
            loginSuccess();
        </script>';
        die;
    }
    else {
       echo '
       <script type="text/javascript">
           loginFailed();
       </script>';
        die;
    }
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>JRSK Booking | Sign In</title>
        <meta name="charset" content="UTF-8">
		<meta name="author" content="Jeremee Cayde, Kurt Colonia, Rotsen David, Sean Ysagun">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <link rel="stylesheet" href="styles/dev-style.css">
    <!-- DEVELOPER CSS, USED FOR WEBSITE DEVELOPMENT PHASE -->
    
    <link rel="stylesheet" href="styles/mainComponents-style.css">
    <link rel="stylesheet" href="styles/login-style.css">
	<link rel="icon" href="images/logo.png">

    <body>
        <div>
            <div class="bodySection">
                <div class="info">
                    <div class="content">
                        <span class="loginTitle"><h2>Sign In</h2></span>
                        <form id="loginForm" class="loginForm" method="post">
                            <fieldset class="loginFieldset">
                                <div class="emailCont">
                                    <div class="container">
                                        <label for="email">E-mail</label><br>
                                        <input type="email" placeholder="E-mail Address" name="email" autocomplete="off">
                                    </div>
                                </div>
                                
                                <div class="passwordCont">
                                    <div class="container">
                                        <label for="password">Password</label><br>
                                    <input type="password" placeholder="Password" name="password" class="password" autocomplete="off"><br>
                                    </div>
                                </div>
                                
                                
                            </fieldset>
                        </form>

                        <button type="submit" name="submit" form="loginForm" class="loginButton" value="submit">Sign In</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include('header.php'); ?>
    </body>
</html>
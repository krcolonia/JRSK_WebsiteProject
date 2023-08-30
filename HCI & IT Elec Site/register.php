<?php

include('php/db-connect.php');
include('php/id-generator.php');

$page = 'register';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $guestID = random_num(5);
    $lastName = $_REQUEST['lastName'];
    $firstName = $_REQUEST['firstName'];
    $password = $_REQUEST['password'];
    $contactNo = $_REQUEST['contactNo'];
    $email = $_REQUEST['email'];
    $birthDate = $_REQUEST['birthDate'];
    $gender = $_REQUEST['gender'];
    
    $validEmail = mysqli_query($con, "SELECT email FROM guest WHERE email='$email'");
    $num = mysqli_fetch_array($validEmail);
    $emailCount = mysqli_num_rows($validEmail);

    $sql = "INSERT INTO guest VALUES ('$guestID', '$lastName', '$firstName', '$password', '$contactNo', '$email', '$birthDate', '$gender')";

    if ($emailCount > 0){
        echo '<script>
            alert("Registration Unsuccessful. Email already registered");
            window.location.href="register.php";
        </script>';
        die;
    }

    if (mysqli_query($con, $sql)) {
        echo '<script>
            alert("Successful");
            window.location.href="login.php";
        </script>';
        die;
    }

}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>JRSK Booking | Sign Up</title>
        <meta name="charset" content="UTF-8">
		<meta name="author" content="Jeremee Cayde, Kurt Colonia, Rotsen David, Sean Ysagun">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <link rel="stylesheet" href="styles/dev-style.css">
    <!-- DEVELOPER CSS, USED FOR WEBSITE DEVELOPMENT PHASE -->
    
    <link rel="stylesheet" href="styles/mainComponents-style.css">
    <link rel="stylesheet" href="styles/register-style.css">
	<link rel="icon" href="images/logo.png">
    <script src="scripts/register-script.js"></script>

    <body>        
        <div>
            <div class="bodySection">
                <div class="info">
                    <div class="content">
                        <span class="registerTitle"><h2>Sign Up</h2></span>
                        <form id="registerForm" class="registerForm" method="post">
                            <fieldset class="regFieldset">

                                <div class="nameCont">
                                    <div class="container">
                                        <label for="firstName" >First Name</label><br>
                                        <input type="text" placeholder="Juan" name="firstName" required="required" autocomplete="off">
                                    </div>

                                    <div class="container">
                                        <label for="lastName">Last Name</label><br>
                                        <input type="text" placeholder="Dela Cruz" name="lastName" required="required" autocomplete="off">
                                    </div>
                                </div>

                                <div class="genderBirthCont">
                                    <div class="container">
                                        <label for="birthDate" >Birthdate</label><br>
                                        <input type="date" name="birthDate"></input>
                                    </div>

                                    <div class="container">
                                        <label for="gender" >Gender</label><br>
                                        <select name="gender">
                                            <option value="" disabled selected>Select Gender</option>
                                            <option value="M">Male</option>
                                            <option value="F">Female</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="contactNoCont">
                                    <div class="container">
                                        <label for="contactNo">Contact Number</label><br>
                                        <input type="number" placeholder="Contact Number" name="contactNo" required="required" autocomplete="off">
                                    </div>
                                </div>

                                <div class="emailCont">
                                    <div class="container">
                                        <label for="email">E-mail</label><br>
                                        <input type="email" placeholder="E-mail Address" name="email" required="required" autocomplete="off">
                                    </div>
                                </div>
                                
                                <div class="passwordCont">
                                    <div class="container">
                                        <label for="password" >Password</label><br>
                                    <input type="password" placeholder="Password" name="password" class="password" required="required" autocomplete="off"><br>
                                    </div>
                                </div>
                                
                                <p class="privacypolicy"><input type="checkbox" required="required">By clicking "Sign Up", you agree to JRSK Booking's <button type="button" id="privacyPolicyButton" class="ppolicyButton" onclick="privacyPolicyMenu()">Privacy Policy</button></p>
                            </fieldset>
                        </form>

                        <button type="submit" name="submit" form="registerForm" class="registerButton" value="submit">Sign Up</button>
                    </div>
                </div>
            </div>
        </div>

        <?php include('header.php'); ?>

        <div class="privacypolicyWindow" id="privacyPolicyWindow">
            <span class="ppolicyTitle"><h2>Sign Up</h2></span>
            
            <button type="button" id="privacyPolicyButton" class="ppolicyCloseButton" onclick="privacyPolicyMenu()">Close Privacy Policy</button>
            <iframe src="privacypolicy.html">
        </div>
    </body>
</html>
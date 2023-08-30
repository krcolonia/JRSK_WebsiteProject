<?php
session_start();

include('php/db-connect.php');
$page = 'contactus';

$firstName = '';
$lastName = '';
$email = '';

if(!empty($_SESSION['sessionID'])) {
    $guestID = $_SESSION['sessionID'];
    $userInfo = mysqli_query($con, "SELECT * FROM guest WHERE guestID = '$guestID'");
    $fetchInfo = mysqli_fetch_array($userInfo, MYSQLI_ASSOC);

    $firstName = $fetchInfo['firstName'];
    $lastName = $fetchInfo['lastName'];
    $email = $fetchInfo['email'];
}


?>



<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>JRSK Booking | Contact Us</title>       
    </head>

    <link rel="stylesheet" href="styles/dev-style.css">
    <!-- DEVELOPER CSS, USED FOR WEBSITE DEVELOPMENT PHASE -->

    <link rel="stylesheet" href="styles/mainComponents-style.css">
    <link rel="stylesheet" href="styles/contact-us-style.css">
    <link rel="icon" href="images/logo.png">

    <script type="text/javascript" src="scripts/contact-us-script.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>
    <script type="text/javascript">
        (function(){
            emailjs.init("2dSOd6FZygE1Z5eQi");
        })();
    </script>
    
<body>        
    <div class="info">
        <div class="content">
        <span class="contactUsTitle"><h2>CONTACT US</h2></span>
        <p class="contactUsText">Need help with something? Fill out the form below with details about your inquiry so we can work on it!</p>
        
        <hr style="width:90%;text-align:left;margin:0 auto;">
        <br>

        <form id="contactUsForm" method="post">
            <fieldset class="contactFieldSet">
                <div class="nameCont">
                    <div>
                        <label for="firstName" class="firstName">First name</label>
                        <input type="text" id="firstName" name="firstName" placeholder="Juan" required="required" autocomplete="off" value = "<?php echo $firstName; ?>" />
                        <label for="lastName" class="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastName" placeholder="Dela Cruz" required="required" autocomplete="off" value = "<?php echo $lastName; ?>" />
                    </div>
                </div>

                <div class="contactusCont">
                    <div class="emailCont">
                        <label for="email" class="emailLabel">E-mail</label><br>
                        <input type="text" id="email" name="email" placeholder="sample.email@website.com" required="required" autocomplete="off" value = "<?php echo $email; ?>">
                    </div>
                    <div class="inquiryCont">
                        <label for="inquiry">Inquiry</label><br>
                        <textarea id="inquiry" name="inquiry" placeholder="Place your inquiry here..." required="required"></textarea>
                    </div>
                </div>
            </fieldset>
        </form>

        <button type="button" name="submit" id="submitButton" form="contactUsForm" class="submitButton" value="Submit" onclick="sendMail()">Submit Inquiry</button>

        <hr style="width:90%;text-align:left;margin:0 auto;">
        <br>
        
        </div>
    </div>

    <?php include("header.php"); ?>

    <div class="footer">
        <p title="Copyright">Copyright © 2022-2023 JRSK Booking. All rights reserved.</p>
    </div>
</body>
</html>
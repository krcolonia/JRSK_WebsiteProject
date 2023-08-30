<?php
session_start();

include('php/db-connect.php');
$page = 'payment';

$guestID = $_SESSION['sessionID'];
$bookStatus = $_SESSION['bookingStatusID'];

$retrieveUserInfo = "SELECT * FROM guest WHERE guestID = '$guestID'";
$retrieveQuery = mysqli_query($con, $retrieveUserInfo);

if($retrieveQuery) {
    $userData = mysqli_fetch_array($retrieveQuery);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $checkinUpdate = "UPDATE `booking` SET `bookingStatusID`='BS02' WHERE `bookingID` = '$_SESSION[bookingID]'";
    $checkoutUpdate = "DELETE FROM booking WHERE bookingID = '$_SESSION[bookingID]'";

    if($bookStatus=="BS01") {
        mysqli_query($con, $checkinUpdate);
        echo '
        <script>
            alert("Payment for Check-in Successful. Enjoy your stay!");
            window.location.href="home.php";
        </script>
        ';
    }
    else if($bookStatus=="BS02") {
        mysqli_query($con, $checkoutUpdate);
        echo '
        <script>
            alert("Payment for Check-out Successful. Thank you for using JRSK Booking!");
            window.location.href="home.php";
        </script>
        ';
    }
    
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>JRSK Booking | Payment
        <?php
        if($bookStatus=="BS01") {
            echo ' Check-in';
        }
        else if($bookStatus=="BS02") {
            echo ' Check-out';
        }
        ?></title>
        <meta name="charset" content="UTF-8">
		<meta name="author" content="Jeremee Cayde, Kurt Colonia, Rotsen David, Sean Ysagun">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <link rel="stylesheet" href="styles/dev-style.css">
    <!-- DEVELOPER CSS, USED FOR WEBSITE DEVELOPMENT PHASE -->
    
    <link rel="stylesheet" href="styles/mainComponents-style.css">
    <link rel="stylesheet" href="styles/payment-style.css">
	<link rel="icon" href="images/logo.png">

    <body>
        <div>
            <div class="bodySection">
                <div class="info">
                    <div class="content">
                        <span class="paymentTitle"><h2>Payment<?php
        if($bookStatus=="BS01") {
            echo ' Check-in';
        }
        else if($bookStatus=="BS02") {
            echo ' Check-out';
        }
        ?></h2></span>
                        <form id="paymentForm" class="paymentForm" method="post">
                            <fieldset class="payFieldset">

                                <div class="mainFormCont">
                                    <div class="formCont">
                                        <div class="nameCont">
                                            <div class="container">
                                                <label for="firstName" >First Name</label><br>
                                                <input type="text" placeholder="Juan" name="firstName" required="required" value="<?php echo $userData['firstName'] ?>" autocomplete="off">
                                            </div>
        
                                            <div class="container">
                                                <label for="lastName">Last Name</label><br>
                                                <input type="text" placeholder="Dela Cruz" name="lastName" required="required" value="<?php echo $userData['lastName'] ?>" autocomplete="off">
                                            </div>
                                        </div>
        
                                        <div class="emailCont">
                                            <div class="container">
                                                <label for="email">E-mail</label><br>
                                                <input type="email" placeholder="E-mail Address" name="email" required="required" value="<?php echo $userData['email'] ?>" autocomplete="off">
                                            </div>
                                        </div>
                                        
                                        <div class="passwordCont">
                                            <div class="container">
                                                <label for="password">Credit Card Number</label><br>
                                            <input type="text" placeholder="Credit Card Number" name="creditCardNumber" class="password" required="required" autocomplete="off"><br>
                                            </div>
                                        </div>
    
                                        <div class="creditCardInfoCont">
    
                                            <div class="container">
                                                <label for="text">CVC Number</label><br>
                                                <input type="number" placeholder="CVC Number" name="cvcNumber" required="required" autocomplete="off">
                                            </div>
    
                                            <div class="container expiry">
                                                <label for="expiryDate">Expiry Date</label><br>
                                                <input type="date" name="expiryDate"></input>
                                            </div>
    
                                        </div>
                                    </div>
                                </div>
                                
                            </fieldset>
                        </form>

                        <button type="submit" name="submit" form="paymentForm" class="paymentButton" value="submit">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
        <?php include("header.php"); ?>
    </body>
</html>
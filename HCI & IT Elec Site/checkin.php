<?php
session_start();
include('php/db-connect.php');

$page = 'checkin';

$guestID = $_SESSION['sessionID'];
$bookingID = $_SESSION['bookingID'];

$retrieveUserInfo = "SELECT * FROM guest WHERE guestID = '$guestID'";
$retrieveQuery = mysqli_query($con, $retrieveUserInfo);

if($retrieveQuery) {
    $userData = mysqli_fetch_array($retrieveQuery);
}


$retrieveBook = "SELECT * FROM booking WHERE bookingID = '$bookingID'";
$retrieveBookQuery = mysqli_query($con, $retrieveBook);

if($retrieveBookQuery) {
    $bookReserve = mysqli_fetch_array($retrieveBookQuery);
}

$retrieveBookDetails = "SELECT * FROM bookingDetail WHERE bookingID = '$bookingID'";
$retrieveBookDetailsQuery = mysqli_query($con, $retrieveBookDetails);

$retrieveRoomType = "SELECT * FROM roomType";
$retrieveRoomTypeQuery = mysqli_query($con, $retrieveRoomType);



if(!empty($_SESSION['sessionID'])) {
    $getBookStat = "SELECT bookingID, bookingStatusID FROM booking WHERE guestID = '$_SESSION[sessionID]'";
    $bookStatQuery = mysqli_query($con, $getBookStat);
    $userBookStat = mysqli_fetch_array($bookStatQuery);

    if($userBookStat) {
        $_SESSION['bookingStatusID'] = $userBookStat['bookingStatusID'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $bookUpdate = "UPDATE `booking` SET `bookingStatusID`='BS02' WHERE `bookingID` = '$_SESSION[bookingID]'";

        $paymentType = $_REQUEST['payType'];

        if($paymentType=="PT01") {
            if(mysqli_query($con, $bookUpdate)) {
                echo '
                <script>
                    alert("Check-In Successful. Please ready your cash upon arrival at the Hotel");
                    window.location.href="home.php";
                </script>
                ';
            }
        }
        else if($paymentType=="PT02") {
            echo '
            <script>
                alert("Check-In Successful. Proceeding to Payment");
                window.location.href="payment.php";
            </script>
            ';
        }
        
    }
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>JRSK Booking | Check In</title>
        <meta name="charset" content="UTF-8">
		<meta name="author" content="Jeremee Cayde, Kurt Colonia, Rotsen David, Sean Ysagun">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>


    <link rel="stylesheet" href="styles/dev-style.css">
    
    <link rel="stylesheet" href="styles/mainComponents-style.css">
    <link rel="stylesheet" href="styles/checkin-style.css">
	<link rel="icon" href="images/logo.png">

    <script src="scripts/checkin-script.js"></script>

    <body>
        <section>
            <div class="info">
                <div class="content">
                    <span class="checkinTitle"><h2>Check-In</h2></span>
                    <form id="checkinForm" method="post">

                        <div class="checkinDiv">
                            <div class="formDiv">
                                <div class="guestInfo1">
                                    <p class="guestTitle">Guest Information</p>
                                    <label for="name">Guest Name</label><br>
                                    <input type="text" id="name" name="name" placeholder="Juan Dela Cruz" value="<?php echo $userData['firstName'] . " " . $userData['lastName']; ?>"><br>
                                    <label for="email"></i>Email</label><br>
                                    <input type="text" id="email" name="email" placeholder="sample.email@email.com" value="<?php echo $userData['email'] ?>"><br>
                                </div>
        
                                <div class="guestInfo2">
                                    <label for="contactNum">Contact Number</label><br>
                                    <input type="text" id="contactNum" name="contactNum" placeholder="0123 456 7890" value="<?php echo $userData['contactNo'];?>"><br>
        
                                    <div class="birthday">
                                        <label for="birthDate">Birthday</label><br>
                                        <input type="date" name="birthDate" id="birthDate" class="birthDate" placeholder="Birthday" value="<?php echo $userData['birthDate'] ?>"></input><br>
                                    </div>
        
                                </div><br>
        
                                <div class="paymentInfo">
                                    <p class="paymentTitle">Payment Information</p>
                                    <label for="payType">Payment Type</label><br>
                                    <select name="payType" id="payType" class="payType">
                                        <option value="" disabled selected>Payment Type</option>
                                        <option value="PT01">Cash</option>
                                        <option value="PT02">Credit Card</option>
                                    </select><br>
                                </div><br>
        
                                <div class="additionalInfo">
                                    <p class="additionalTitle">Additional Services</p>
                                    <textarea class="addService" id="addService" onblur="additionalFee()" placeholder="Additional services..."></textarea>
                                </div>
                            </div>
    
                            <div class="checkinSummary">
                                <p class="summaryTitle">Summary</p>
                                <div class="summaryContent">
                                    <?php
                                        echo 'Booking ID: '.$bookReserve['bookingID'].'<br>';
                                        echo 'Guest Name: '.$userData['firstName'].' '.$userData['lastName'].'<br>';

                                        echo '<br>Check-in Date: '.$bookReserve['checkinDate'].'<br>';
                                        echo 'Check-out Date: '.$bookReserve['checkoutDate'].'<br>';
                                        echo 'No. of Nights : ' .$bookReserve['numNights']. '<br>';

                                        echo '<hr>';

                                        $bookingFee = 150;
                                        
                                        echo 'Booking Fee<div class="roomPrice">₱'.number_format($bookingFee,2).'</div><br>';

                                        $additionalFee = 350;
                                        $totalCheckin = 0;

                                        echo 'Additional Fee<div class="roomPrice">₱'.number_format($additionalFee,2).'</div><br><br>';

                                        echo '<hr>';

                                        echo 'Total<div class="roomPrice">₱' . number_format($bookingFee + $additionalFee, 2) . '</div><br>';
                                        
                                    ?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" form="checkinForm" class="checkinButton" value="Submit">Proceed to Payment</button>
                    </form>
                </div>
            </div>
        </section>

        <footer>
            <div class="footer">
                <p title="Copyright">Copyright © 2022-2023 JRSK Booking. All rights reserved.</p>
            </div>
        </footer>
        <?php include("header.php"); ?>
    </body>
</html>
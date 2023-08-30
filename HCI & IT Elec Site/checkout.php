<?php
session_start();

include('php/db-connect.php');
$page = 'checkout';

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
        $bookUpdate = "DELETE FROM booking WHERE bookingID = '$_SESSION[bookingID]'";

        $paymentType = $_REQUEST['payType'];
        
        $fetchBookDetail = "SELECT * FROM bookingDetail WHERE bookingID = '$_SESSION[bookingID]' ";
        $bookDetailQuery = mysqli_query($con, $fetchBookDetail);

        while($bookDetail = mysqli_fetch_assoc($bookDetailQuery)) {
            ${'room'.$bookDetail['roomID'].'ReOpen'} = "UPDATE `room` SET `roomStatusID` = 'RS01' WHERE roomID = '".$bookDetail['roomID']."' ";
            mysqli_query($con, ${'room' . $bookDetail['roomID'] . 'ReOpen'});

            ${'deleteDetail' . $bookDetail['roomID']} = "DELETE FROM `bookingdetail` WHERE roomID='".$bookDetail['roomID']."'";
            mysqli_query($con, ${'deleteDetail' . $bookDetail['roomID']});
        }

        if(mysqli_query($con, $bookUpdate)) {
            if($paymentType=="PT01") {
                echo '
                <script>
                    alert("Check-Out Successful. Please ready your cash upon departure from the Hotel");
                    window.location.href="home.php";
                </script>
                ';
                mysqli_query($con, $bookUpdate);
                $_SESSION['bookingID'] = '';
            }
            else if($paymentType=="PT02") {
                echo '
                <script>
                    alert("Check-Out Successful. Proceeding to Payment");
                    window.location.href="payment.php";
                </script>
                ';
            }
        }
        
    }
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>JRSK Booking | Check Out</title>
        <meta name="charset" content="UTF-8">
		<meta name="author" content="Jeremee Cayde, Kurt Colonia, Rotsen David, Sean Ysagun">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <link rel="stylesheet" href="styles/dev-style.css">
    <!-- DEVELOPER CSS, USED FOR WEBSITE DEVELOPMENT PHASE -->
    
    <link rel="stylesheet" href="styles/mainComponents-style.css">
    <link rel="stylesheet" href="styles/checkout-style.css">
	<link rel="icon" href="images/logo.png">

    <body>
        <section>
            <div class="info">
                <div class="content">
                    <span class="checkoutTitle"><h2>Check-Out</h2></span>
                    <form id="checkoutForm" method="post">

                        <div class="checkoutDiv">
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
                            </div>

                            <div class="checkoutSummary">
                                <p class="summaryTitle">Summary</p>
                                <div class="summaryContent">
                                <?php
                                        echo 'Booking ID: '.$bookReserve['bookingID'].'<br>';
                                        echo 'Guest Name: '.$userData['firstName'].' '.$userData['lastName'].'<br>';

                                        echo '<br>Check-in Date: '.$bookReserve['checkinDate'].'<br>';
                                        echo 'Check-out Date: '.$bookReserve['checkoutDate'].'<br>';
                                        echo 'No. of Nights : ' .$bookReserve['numNights']. '<br>';

                                        echo '<hr>';
                                        $subTotal = 0;
                                        while($fetchRoomType = mysqli_fetch_assoc($retrieveRoomTypeQuery)) {
                                            ${'num'.$fetchRoomType['roomTypeID'].'Rooms'} = 'SELECT * FROM bookingDetail WHERE roomTypeID = "'.$fetchRoomType['roomTypeID'].'" ';
                                            ${'num' . $fetchRoomType['roomTypeID'] . 'RoomsQuery'} = mysqli_query($con, ${'num'.$fetchRoomType['roomTypeID'].'Rooms'});

                                            ${'count' . $fetchRoomType['roomTypeID'] . 'Rooms'} = mysqli_num_rows(${'num' . $fetchRoomType['roomTypeID'] . 'RoomsQuery'});

                                            ${$fetchRoomType['roomType'].'Rate'} = number_format($fetchRoomType['roomRate'] * ${'count' . $fetchRoomType['roomTypeID'] . 'Rooms'} * $bookReserve['numNights'],2);

                                            if(${'count' . $fetchRoomType['roomTypeID'] . 'Rooms'} > 0) {
                                                echo $fetchRoomType['roomType'].' Room x '.${'count' . $fetchRoomType['roomTypeID'] . 'Rooms'}.'<div class="roomPrice">₱'.${$fetchRoomType['roomType'].'Rate'}.'</div><br>';
                                                $subTotal += ($fetchRoomType['roomRate'] * ${'count' . $fetchRoomType['roomTypeID'] . 'Rooms'} * $bookReserve['numNights']);
                                            }
                                        }

                                        echo '<br>Subtotal<div class="roomPrice">₱'.number_format($subTotal, 2).'</div><br>';

                                        $tax = $subTotal * 0.12;

                                        echo 'Value Added Tax (12%)<div class="roomPrice">₱'.number_format($tax,2).'</div><br>';
                                        echo '<hr>';

                                    echo 'Total<div class="roomPrice">₱' . number_format(($subTotal + $tax), 2).'</div><br>';

                                        //echo 'Booking Fee<div class="roomPrice">₱'.number_format(150,2).'</div><br>';
                                        //echo '<div id="addFeeCont">Additional Fee<div class="roomPrice">₱'.number_format(350,2).'</div><br></div>';
                                    ?>
                                </div>
                            </div>
                        </div>

                        
                        
                    </form>

                 <button type="submit" form="checkoutForm" class="checkoutButton" value="Submit">Proceed to Payment</button>
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
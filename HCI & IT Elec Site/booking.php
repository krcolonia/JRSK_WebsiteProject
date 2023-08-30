<?php
session_start();

$page = 'booking';

include('php/db-connect.php');
include('php/id-generator.php');
include('php/svg-files.php');

$roomTypeQuery = mysqli_query($con, "SELECT * FROM roomType");
$count = mysqli_num_rows($roomTypeQuery);

$roomTypeVarQuery = mysqli_query($con, "SELECT * FROM roomType");

if(empty($_SESSION['sessionID'])) {
    echo '
    <script>
        alert("Please sign in to book a reservation");
        window.location.href="home.php";
    </script>
    ';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_SESSION['sessionID']) && $_REQUEST['sumNights'] > 0) {

        echo $_REQUEST['sumNights'];

        $bookingID = 'BK' . random_num(5);

        $_SESSION['bookingID'] = $bookingID;

        $guestID = $_SESSION['sessionID'];
        $checkin = $_REQUEST['checkin'];
        $checkout = $_REQUEST['checkout'];
        $numNights = $_REQUEST['sumNights'];
        $bookDate = date('y-m-d');
        $numAdult = $_REQUEST['numAdults'];
        $numChild = $_REQUEST['numChild'];
        $bookingStatusID = 'BS01';

        $sql = "INSERT INTO booking (bookingID, guestID, checkinDate, checkoutDate, numAdult, numChild, numNights, bookingDate, bookingStatusID) VALUES ('$bookingID', '$_SESSION[sessionID]', '$checkin', '$checkout', '$numAdult', '$numChild', '$numNights', '$bookDate', '$bookingStatusID')";

        if (mysqli_query($con, $sql)) {
            echo '
            <script>
                alert("Booked Reservation Successfully.");
                window.location.href="home.php";
            </script>
            ';
        }

        while($fetchType = mysqli_fetch_array($roomTypeVarQuery)) {

            ${'num' . $fetchType['roomType']} = $_REQUEST['num' . $fetchType['roomType']];

            if(${'num' . $fetchType['roomType']} > 0) {

                for ($i = 1; $i <= ${'num' . $fetchType['roomType']}; $i++) {
                    $retrieveAvailableRooms = mysqli_query($con, "SELECT * FROM room WHERE roomStatusID=(SELECT min(roomStatusID) FROM room WHERE roomStatusID = 'RS01') AND roomTypeID='$fetchType[roomTypeID]' LIMIT 1");
                    $availRoom = mysqli_fetch_assoc($retrieveAvailableRooms);

                    echo $availRoom['roomID']."\n";

                    $updateRoomQuery = mysqli_query($con, "UPDATE `room` SET `roomStatusID`='RS02' WHERE `roomID` = '$availRoom[roomID]'");
                    $bookingDetailQuery = mysqli_query($con, "INSERT INTO `bookingdetail` VALUES ('$_SESSION[bookingID]','$availRoom[roomID]', '$availRoom[roomTypeID]')");
                }
                echo ${'num' . $fetchType['roomType']}."\n";
            }
        }
    }
    else if($_REQUEST['sumNights'] <= 0) {
        echo '
            <script>
                alert("Invalid Dates. Please input proper Check-in and Check-out Dates.");
            </script>
            ';
    }
}

?>

<!DOCTYPE HTML>
<html>
    <head>
        <title>JRSK Booking | Booking</title>
        <meta name="charset" content="UTF-8">
        <meta name="author" content="Jeremee Cayde, Kurt Colonia, Rotsen David, Sean Ysagun">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <link rel="stylesheet" href="styles/dev-style.css" />
    <!-- DEVELOPER CSS, USED FOR WEBSITE DEVELOPMENT PHASE -->

    <link rel="stylesheet" href="styles/mainComponents-style.css" />
    <link rel="stylesheet" href="styles/booking-style.css" />
    <link rel="icon" href="images/logo.png" />

    
    <script src="scripts/booking-script.js"></script>

    <body>
        <div class="info">
            <div class="content">
                <span class="bookingTitle"><h2>Booking</h2></span>
            </div>

            <form id="bookingForm" method="post">
            <div class="bookCont">
                
                <div class="roomCont">
                    <div class="search">
                    <label for="checkIn">Check-In</label>
                    <input type="date" id="checkin" name="checkin" class="checkDate" placeholder="Check-In" onblur="checkDateFuncs()" required="required"></input>
                    <label for="checkOut">Check-Out</label>
                    <input type="date" id="checkout" name="checkout" class="checkDate" placeholder="Check-Out" onblur="checkDateFuncs()" required="required"></input>
                    <div class="guestDropDown">
                        <button onclick="dropDownFunc()" class="guestDropButton" type="button">Guests</button><input type="text" name="guestTotal" id="guestTotal" readonly>
                        <div id="myDropDown" class="dropdown-content">
                            <p>Adults<input onblur="findTotal()" type="number" id="numAdults" class="numGuest" name="numAdults" min="0" max="10" value="0" required="required"></p>
                            <p>Children<input onblur="findTotal()" type="number" id="numChild" class="numGuest" name="numChild" min="0" max="10" value="0" required="required"></p>
                        </div>
                    </div>
                </div>
                    <?php
                        while($fetchType = mysqli_fetch_array($roomTypeQuery)) {

                            ${$fetchType['roomType']} = mysqli_query($con, "SELECT * FROM room WHERE roomTypeID = '".$fetchType['roomTypeID']."' AND roomStatusID = 'RS01' ");

                            ${$fetchType['roomType'].'Count'} = mysqli_num_rows(${$fetchType['roomType']});

                            ${'price' . $fetchType['roomType']} = $fetchType['roomRate'];

                            echo '
                            <div class="variableHolder">
                                <div id="test'.$fetchType['roomType'].'">
                                    '.${'price' . $fetchType['roomType']}.'
                                </div>
                            </div>
                            ';

                            if(${$fetchType['roomType'].'Count'} >= 1) {
                                echo '
                                <div class="roomType">
                                    <img class="roomImg" src="images/rooms/'.$fetchType['roomType'].'.jpg">

                                    <div class="roomDesc">
                                        <div class="roomName">
                                            <p>'.$fetchType['roomType'].' Room</p>
                                        </div>

                                        <div class="desc">
                                            <p>₱'.number_format($fetchType['roomRate']).'</p>
                                            <p>Capacity: '.$fetchType['roomCapacity'].'</p>
                                            <p>Amenities: <br>
                                               Air conditioning, Attached bathroom, <br>
                                               Flat-screen TV, Free WiFi
                                            </p>
                                        </div>

                                        <div class="roomNumCont">
                                            <p><input type="number" id="num'.$fetchType['roomType'].'" name="num'.$fetchType['roomType'].'" class="numRoomType" min="0" max="'.${$fetchType['roomType'].'Count'}.'" value="0" onclick="checkRooms()" required="required" />'.${$fetchType['roomType'].'Count'}.' rooms available</p>
                                        </div>
                                    </div>
                                    
                                </div>
                                ';
                        }
                        else {
                        }
                    }    

                    ?>
                </div>
                
                <div class="summary">
                    <div class="summaryBorder">
                    <span class="sumTitleDesign"><h2>Summary</h2></span>
                        <div class="sumDetailCont">
                            <div class="summaryCheckin">
                                <p class="sumCheckTitle">Check-in</p>
                                <input type="text" id="sumCin" class="sumCin" readonly/>
                            </div>

                            <div class="summaryCheckout">
                                <p class="sumCheckTitle">Check-out</p>
                                <input type="text" id="sumCout" class="sumCout" readonly/>
                            </div>

                            <div class="summaryNights">
                                <p class="sumNightsTitle">Nights</p>
                                <input type="number" id="sumNights" class="sumNights" name="sumNights" readonly/>
                            </div>
                            <hr>
                            <div class="summaryGuest">
                                <p class="sumGuestTitle">Guests</p>
                                <div class="sumAdultCont">
                                    <p class="sumAdultTitle">Adults</p>
                                    <input type="number" id="sumAdult" class="sumAdult" readonly/>
                                </div>
                                <div class="sumChildCont">
                                    <p class="sumChildTitle">Children</p>
                                    <input type="number" id="sumChild" class="sumChild" readonly/>
                                </div>
                            </div>
                            <hr>
                            <div class="summaryRooms">
                                <p class="sumRoomsTitle">Rooms</p>
                                <div>
                                    <p id="sumRoom1" class="sumRoom1"><div id="roomPrice1" class="sumPrice"></div></p>
                                    <p id="sumRoom2" class="sumRoom2"><div id="roomPrice2" class="sumPrice"></div></p>
                                    <p id="sumRoom3" class="sumRoom3"><div id="roomPrice3" class="sumPrice"></div></p>
                                    <p id="sumRoom4" class="sumRoom4"><div id="roomPrice4" class="sumPrice"></div></p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" form="bookingForm" class="bookingButton" value="Submit">Book Reservation</button>
            </form>
        </div>

        <div class="footerCont">
            <div class="footer">
                <p title="Copyright">Copyright © 2022-2023 JRSK Booking. All rights reserved.</p>
            </div>
        </div>

        <?php include('header.php'); ?>

    </body>
</html>
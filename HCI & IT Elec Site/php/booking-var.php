<?php
include('php/id-generator.php');

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(!empty($_SESSION['sessionID'])) {

        $bookingID = 'BK'.random_num(5);

        $_SESSION['bookingID'] = $bookingID;
        
        $guestID = $_SESSION['sessionID'];
        $checkin = $_REQUEST['checkin'];
        $checkout = $_REQUEST['checkout'];
        $bookDate = date('y-m-d');
        $numAdult = $_REQUEST['numAdults'];
        $numChild = $_REQUEST['numChild'];
    
        $sql = "INSERT INTO booking (bookingID, guestID, checkinDate, checkoutDate, adultGuest, childGuest, bookingDate) VALUES ('$bookingID', '$_SESSION[sessionID]', '$checkin', '$checkout', '$numAdult', '$numChild', '$bookDate')";
    
        if(mysqli_query($con, $sql)) {
            header('Location: booking.php');
        }
    }
    else {
        echo '
        <script>
            alert("Please sign in to book a reservation");
            window.location.href="login.php";
        </script>
        ';
    }
}
?>
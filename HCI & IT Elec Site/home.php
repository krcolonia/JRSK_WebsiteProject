<?php
session_start();

$page = 'home';

include('php/db-connect.php');

if(!empty($_SESSION['sessionID'])) {
    $getBookStat = "SELECT bookingID, bookingStatusID FROM booking WHERE guestID = '$_SESSION[sessionID]'";
    $bookStatQuery = mysqli_query($con, $getBookStat);
    $userBookStat = mysqli_fetch_array($bookStatQuery);

    if($userBookStat) {
        $_SESSION['bookingID'] = $userBookStat['bookingID'];
        $_SESSION['bookingStatusID'] = $userBookStat['bookingStatusID'];
    }
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    if(!empty($_SESSION['sessionID']) && $userBookStat && $_SESSION['bookingStatusID'] == "BS01") {
        header('Location: checkin.php');
    }
    else if(!empty($_SESSION['sessionID']) && $userBookStat && $_SESSION['bookingStatusID'] == "BS02") {
        header('Location: checkout.php');
    }
    else if(empty($_SESSION['sessionID'])) {
        echo '
        <script>
            alert("You are not yet logged in.");
            window.location.href="login.php";
        </script>   
        ';
    }
    else {
        header('Location: booking.php');
    }
    
    
    
}

?>

<!DOCTYPE html>

<html>
    <head>
        <title>JRSK Booking | Home</title>
        <meta name="charset" content="UTF-8">
		<meta name="author" content="Jeremee Cayde, Kurt Colonia, Rotsen David, Sean Ysagun">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>

    <link rel="stylesheet" href="styles/dev-style.css">
    <!-- DEVELOPER CSS, USED FOR WEBSITE DEVELOPMENT PHASE -->
    
    <link rel="stylesheet" href="styles/mainComponents-style.css">
    <link rel="stylesheet" href="styles/home-style.css">
	<link rel="icon" href="images/logo.png">

    <body>
        <a id="home"></a>
            <div class="splashScreen">
                <span class="subtitle">
                    <a href="#descriptionButton"><img src="images/Banner_v2.png" class="splashLogo"></a>
                    <p>A Hotel Booking System You Can Trust</p>
                </span>
            </div>

            <form id="bookingRedirect" method="post" >
                <?php
                    if (!empty($_SESSION['sessionID']) && $userBookStat && $userBookStat['bookingStatusID'] == "BS01") {
                        echo '<button form="bookingRedirect" class="bookNow">Check-in</button>';
                    }
                    else if (!empty($_SESSION['sessionID']) && $userBookStat && $userBookStat['bookingStatusID'] == "BS02") {
                        echo '<button form="bookingRedirect" class="bookNow">Check-out</button>';
                    }
                    else {
                        echo '<button form="bookingRedirect" class="bookNow">Book Now</button>';
                    }
                ?>
            </form>
            
            <a id="aboutUs"></a>
            <div class="webDesc">
                <div class="webDescTitleBG aboutUs"><p class="webDescTitle">About Us</p></div>

                <div class="devProfiles">
                    <div class="devs">
                        <a href="https://sites.google.com/neu.edu.ph/kurtrobincolonia/home" target="_blank"><img src="images/devs-icon/Colonia.png" alt="Kurt Colonia"></a>
                        <p class="name">Kurt Colonia</p>
                        <p class="role">Team Leader</p>
                    </div>
                    <div class="devs">
                        <a href="https://sites.google.com/neu.edu.ph/jeremee-cayde/home" target="_blank"><img src="images/devs-icon/Cayde.jpeg" alt="Jeremee Cayde"></a>
                        <p class="name">Jeremee Cayde</p>
                        <p class="role">Lead Designer</p>
                    </div>
                    <div class="devs">
                        <a href="https://sites.google.com/neu.edu.ph/davidrotsenr/home" target="_blank"><img src="images/devs-icon/David.png" alt="Rotsen David"></a>
                        <p class="name">Rotsen David</p>
                        <p class="role">Lead Researcher</p>
                    </div>
                    <div class="devs">
                        <a href="https://sites.google.com/neu.edu.ph/sean-ysagun/home" target="_blank"><img src="images/devs-icon/Ysagun.jpg" alt="Sean Ysagun"></a>
                        <p class="name">Sean Ysagun</p>
                        <p class="role">Lead Programmer</p>
                    </div>

                </div>

                <p class="webDescText">We're a group of web developers, dedicated to developing the best online
                    <br>web services. JRSK Booking is our take on an Online Hotel Booking Service, and
                    <br> it is our mission to make sure that you get a smooth, seamless experience with
                    <br>JRSK Booking.
                </p>

            <footer>
                <div class="homeFooter">
                    <a id="contactUs"></a>
                    <div class="contactMenu">
                        <div class="contactDescContainer">
                            <div>
                                <h1>Need our help?</h1>
                                <p>Feel free to contact us<br> through our Contact Page!</p>
                                
                            </div><br>
                        </div>
    
                        <div class="contactUsButtonContainer">
                            <a href="contact-us.php"><button>Contact Us</button></a>
                        </div>
                    </div>

                    <div class="copyright">
                        <p>© 2022 JRSK Booking. All rights reserved.</p>
                    </div>

                </div>
            </footer>

            <?php include("header.php"); ?>
        
</body>
</html>
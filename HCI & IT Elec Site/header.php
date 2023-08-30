
<div class="topNav">

<?php

if (empty($_SESSION['sessionID']) && $page == 'home') {

    echo '
    <div class="relativeDropdown" id="dropdown">
        <div class="navDropdown">
            <a class="navOptions" href="#home">Home</a>
            <a class="navOptions" href="#aboutUs">About Us</a>
            <a class="navOptions" href="#contactUs">Contact Us</a>
            <a class="navOptions" href="login.php">Sign In</a>
            <a class="navOptions" href="register.php">Sign Up</a>
        </div>
    </div>';

}
else if (!empty($_SESSION['sessionID']) && $page == 'home'){
    echo '
    <div class="relativeDropdown" id="dropdown">
        <div class="navDropdown">
            <a class="navOptions" href="#home">Home</a>
            <a class="navOptions" href="#aboutUs">About Us</a>
            <a class="navOptions" href="#contactUs">Contact Us</a>
            <a class="navOptions" title="Sign Out" href="logout.php">Sign Out</a>
        </div>
    </div>';
}
else if (empty($_SESSION['sessionID']) && $page != 'home') {

    echo '
    <div class="relativeDropdown" id="dropdown">
        <div class="navDropdown">
            <a class="navOptions" href="home.php">Home</a>
            <a class="navOptions" href="login.php">Sign In</a>
            <a class="navOptions" href="register.php">Sign Up</a>
        </div>
    </div>';

}
else if (!empty($_SESSION['sessionID']) && $page != 'home'){
    echo '
    <div class="relativeDropdown" id="dropdown">
        <div class="navDropdown"> 
            <a class="navOptions" href="home.php">Home</a>
            <a class="navOptions" title="Sign Out" href="logout.php">Sign Out</a>
        </div>
    </div>';
}

?> 

<script src="scripts/header-script.js"></script>

    <div class="navBar">
        <?php
        if($page == 'home') {
            echo '<a id="banner" href="#home"><img src="images/Banner_v2.png"></a>';
        }
        else {
            echo '<a id="banner" href="home.php"><img src="images/Banner_v2.png"></a>';
        }
        ?>
        <div class="buttonCont">
            <div class="userName">
                <p><?php
                if(!empty($_SESSION['sessionID'])) {
                   echo 'Hello, '.$_SESSION["username"].'</p></div>';
                }
                else if(empty($_SESSION['sessionID']) && $page !='login' && $page !='register'){
                    echo 'You\'re not logged in</p></div>';
                }
                else if($page == 'login') {
                    echo 'Don\'t have an account?</p></div><a class="signButton" href="register.php">Sign Up</a>';
                }
                else if($page == 'register') {
                    echo 'Already have an account?</p></div><a class="signButton" href="login.php">Sign In</a>';
                }
                ?>
            <?php
                if($page !='login' && $page !='register') {
                echo '<button class="navButton" class="navButton" onClick="navbarMenu()"><img class ="menuLogo" src="images/Hamburger_icon.png"></button>';
                }
            ?>     
        </div>       
    </div>   
</div>
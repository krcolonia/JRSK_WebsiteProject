<?php 

if(isset($_POST['submit'])){
    $to = "jrskbooking@gmail.com";
    $from = $_POST['email'];
    $subject = "Inquiry Submission";
    $message = $_POST['inquiry'];
    $headers = "From:" . $from;
    $result = mail($to,$subject,$message,$headers);

    if ($result) {
        echo "<script>
            alert('Sent Successfully. Thank you for contacting JRSK Booking!');
            
        </script>";
    }
    else {
        echo "aw di gumana ggwp";
    }
}

?>
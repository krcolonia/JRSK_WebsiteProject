<?php
session_start();
$_SESSION['sessionID'] = '';
session_destroy();
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
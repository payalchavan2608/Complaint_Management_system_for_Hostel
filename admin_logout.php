<?php
session_start();

session_unset();
session_destroy();

/* REDIRECT TO COMMON LOGIN PAGE */
header("Location: ../index.php");  // go to main page
exit();
?>
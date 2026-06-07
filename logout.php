<?php
session_start();

/* DESTROY SESSION */
session_unset();
session_destroy();

/* REDIRECT TO INDEX PAGE */
header("Location: index.php");
exit();
?>
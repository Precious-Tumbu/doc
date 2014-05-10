<?php
session_start();
unset($_SESSION['user']);
unset($_SESSION['isAdmin']);
header("Location: Login.php");
exit;

?>
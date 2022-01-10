<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>

<?php

session_destroy();
$_SESSION["userId"] = null;
$_SESSION["userName"] = null;
$_SESSION["adminName"] = null;
Redirect_to("Login.php");
?>
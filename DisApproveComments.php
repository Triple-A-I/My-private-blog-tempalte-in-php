<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>

<?php
if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $sql = "UPDATE comments SET status='OFF' WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Comment Reverted Successfully!";
        Redirect_to("Comments.php");
    }else {
        $_SESSION["ErrorMessage"] = "Something went wrong!";
        Redirect_to("Comments.php");
    }


}
?>
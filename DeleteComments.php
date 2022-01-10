<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>

<?php
if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $sql = "DELETE FROM comments WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);
    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Comment Deleted Successfully!";
        Redirect_to("Comments.php");
    }else {
        $_SESSION["ErrorMessage"] = "Something went wrong!";
        Redirect_to("Comments.php");
    }


}
?>
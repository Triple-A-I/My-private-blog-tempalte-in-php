<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>

<?php
if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $sqlToGetAdminName = "SELECT username FROM admins WHERE id='$SearchQueryParameter'";
    $ExecuteToGetAdminName = $ConnectingDB->query($sqlToGetAdminName);
    while ($DataRows = $ExecuteToGetAdminName->fetch()) {
        $AdminName          = $DataRows["username"];
    }

    $sql = "DELETE FROM admins WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Admin with the Username " . $AdminName . " Deleted Successfully!";
        Redirect_to("Admins.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong!";
        Redirect_to("Admins.php");
    }
}
?>
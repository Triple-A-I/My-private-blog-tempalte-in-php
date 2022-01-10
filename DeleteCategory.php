<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>

<?php
if (isset($_GET["id"])) {
    $SearchQueryParameter = $_GET["id"];
    global $ConnectingDB;
    $sqlToGetCatgoryName = "SELECT title FROM category WHERE id='$SearchQueryParameter'";
    $ExecuteToGetCategoryName = $ConnectingDB->query($sqlToGetCatgoryName);
    while ($DataRows = $ExecuteToGetCategoryName->fetch()) {
        $CategoryName          = $DataRows["title"];
    }

    $sql = "DELETE FROM category WHERE id='$SearchQueryParameter'";
    $Execute = $ConnectingDB->query($sql);

    if ($Execute) {
        $_SESSION["SuccessMessage"] = "Category with the name " . $CategoryName . " Deleted Successfully!";
        Redirect_to("Categories.php");
    } else {
        $_SESSION["ErrorMessage"] = "Something went wrong!";
        Redirect_to("Categories.php");
    }
}
?>
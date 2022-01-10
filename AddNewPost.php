<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Login_Confirm(); ?>
<?php


if (isset($_POST['Submit'])) {
    $PostTitle      = $_POST['PostTitle'];
    $Category       = $_POST["Category"];
    $Image          = $_FILES["Image"]["name"];
    $Target         = "Uploads/" . basename($Image);
    $PostText       = $_POST["PostDescription"];
    $Admin          = $_SESSION["userName"];
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M", $CurrentTime);
    if (empty($PostTitle)) {
        $_SESSION['ErrorMessage'] = "Title Can't be empty";
        Redirect_to("AddNewPost.php");
    } elseif (strlen($PostTitle) < 5) {
        $_SESSION['ErrorMessage'] = "Post Title should be greater than 5 characters";
        Redirect_to("AddNewPost.php");
    } else {
        ///Insert Post into DB when it is fine
        global $ConnectingDB;
        $sql  = "INSERT INTO posts(dateandtime,title,category,author,image,post)";
        $sql .= "VALUES(:dateTime,:postTitle,:categoryName,:adminName,:imageName,:postDescription)";
        $stmt = $ConnectingDB->prepare($sql);

        $stmt->bindValue(':dateTime', $DateTime);
        $stmt->bindValue(':postTitle', $PostTitle);
        $stmt->bindValue(':categoryName', $Category);
        $stmt->bindValue(':adminName', $Admin);
        $stmt->bindValue(':imageName', $Image);
        $stmt->bindValue(':postDescription', $PostText);
        $EXecute = $stmt->execute();

        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);

        if ($EXecute) {
            $_SESSION['SuccessMessage'] = "Post with id : " . $ConnectingDB->lastInsertId() . " Added Successfully";
            Redirect_to("AddNewPost.php");
        } else {
            $_SESSION['ErrorMessage'] = "Something went wrong";
            Redirect_to("AddNewPost.php");
        }
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Add New Post</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.3/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
    <link rel="stylesheet" href="Css/styles.css" />
</head>
<?php include("AdminNav.php"); ?>
<!-- HEADER -->
<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><i class="fas fa-edit"></i> Add New Post</h1>
            </div>
        </div>
    </div>
</header>
<br />
<!-- END HEADER -->

<!-- Main area  -->

<section class="container py-2 mb-4">
    <div class="row">
        <div class="offset-lg-1 col-lg-10">
            <?php echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form action="AddNewPost.php" method="post" enctype="multipart/form-data">
                <div class="card bg-secondary text-light mb-3">
                    <div class="card-body bg-dark">
                        <div class="form-group">
                            <label for="title" class="FieldInfo">Post Title:</label>
                            <input type="text" id="title" name="PostTitle" placeholder="Add title here" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="CategoryTitle" class="FieldInfo">Choose Category:</label>
                            <select name="Category" id="CategoryTitle" class="form-control">
                                <!-- Fetch All categories from category table -->
                                <?php
                                global $ConnectingDB;
                                $sql = "SELECT id,title FROM category";
                                $stmt = $ConnectingDB->query($sql);
                                while ($DataRows = $stmt->fetch()) {
                                    $Id           = $DataRows["id"];
                                    $CategoryName = $DataRows["title"];

                                ?>
                                    <option><?php echo $CategoryName; ?></option>

                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="File" class="custom-file-input" name="Image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="post">
                                <span class="FieldInfo">
                                    Post:
                                </span>
                            </label>
                            <textarea class="form-control" name="PostDescription" id="post" cols="80" rows="8"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 mb-2">
                                <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                            </div>
                            <div class="col-lg-6 mb-2">
                                <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Post</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- End Main area  -->

<!-- FOOTER -->
<footer class="bg-dark text-white">
    <div class="container">
        <div class="row">
            <div class="col">
                <p class="lead text-center">
                    Theme BY | Albraa Abdalla 2021 &copy;
                </p>
            </div>
        </div>
    </div>
</footer>
<div style="height: 10px; background: powderblue"></div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>

</html>
<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];  echo $_SESSION["TrackingURL"] ; ?>

<?php 
Login_Confirm(); ?>


<?php

$SearchQueryParameter = $_GET["id"];
global $ConnectingDB;

$sql = "SELECT * FROM posts WHERE id = '$SearchQueryParameter'";
$stmt = $ConnectingDB->query($sql);

while ($DataRows = $stmt->fetch()) {
    $TitleToBeDeleted = $DataRows["title"];
    $CategoryToBeDeleted = $DataRows["category"];
    $ImageToBeDeleted = $DataRows["image"];
    $PostToBeDeleted = $DataRows["post"];
}

// echo $ImageToBeUpdate;
if (isset($_POST['Submit'])) {

    ///Update Post into DB when it is fine
    global $ConnectingDB;

    $sql  = "DELETE FROM  posts WHERE id='$SearchQueryParameter'";
    $EXecute = $ConnectingDB->query($sql);

    // move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);


    if ($EXecute) {
        $Targrt_Path_To_DELETE_Image = "Uploads/$ImageToBeDeleted";
        unlink($Targrt_Path_To_DELETE_Image);
        $_SESSION['SuccessMessage'] = "Post with id : " . $SearchQueryParameter . " Deleted Successfully";
        Redirect_to("Posts.php");
    } else {
        $_SESSION['ErrorMessage'] = "Something went wrong";
        Redirect_to("Posts.php");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Delete Post</title>
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
                    <h1><i class="fas fa-edit"></i> Delete Post</h1>
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
                /// Fetching post content to be updated

                ?>
                <form action="DeletePost.php?id=<?php echo $SearchQueryParameter; ?>" method="POST" enctype="multipart/form-data">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title" class="FieldInfo">Post Title:</label>
                                <input type="text" id="title" name="PostTitle" placeholder="Add title here" class="form-control" disabled="true" value="<?php echo $TitleToBeDeleted; ?>">
                            </div>
                            <div>
                                <span class="form-control text-success">Existing Category: <?php echo $CategoryToBeDeleted; ?></span>
                            </div>
                            <br>

                            <div class="form-group">
                                <img src="Uploads/<?php echo $ImageToBeDeleted; ?>" alt="<?php echo $ImageToBeDeleted ?>" style="max-height: 300px;" class="img-thumbnail">
                            </div>
                            <div class="form-group">
                                <label for="post">
                                    <span class="FieldInfo">
                                        Post:
                                    </span>
                                </label>
                                <textarea class="form-control" name="PostDescription" id="post" cols="80" rows="8" disabled><?php echo $PostToBeDeleted;  ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-danger btn-block"><i class="fas fa-trash"></i> Delete</button>
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
                    <p class="lead text-center ">
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
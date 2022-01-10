<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Login_Confirm(); ?>
<?php
// Fetching Existing Admin Data Start
$AdminId = $_SESSION["userId"];
global $ConnectingDB;
$sql = "SELECT * FROM admins WHERE id='$AdminId'";
$stmt = $ConnectingDB->query($sql);
while ($DataRows = $stmt->fetch()) {
    $ExistingName = $DataRows["aname"];
    $ExistingUserName = $DataRows["username"];
    $ExistingHeadline = $DataRows["aheadline"];
    $ExistingBio = $DataRows["abio"];
    $ExistingImage = $DataRows["aimage"];
}
// Fetching Existing Admin Data End

if (isset($_POST['Submit'])) {
    $AName      = $_POST['Name'];
    $AHeadline       = $_POST["Headline"];
    $ABio  = $_POST["Bio"];
    $Image          = $_FILES["Image"]["name"];
    $Target         = "Images/" . basename($Image);

     if (strlen($AHeadline) > 30) {
        $_SESSION['ErrorMessage'] = "Headline should be less than 30 characters";
        Redirect_to("MyProfile.php");
    }elseif (strlen($ABio)>500) {
        $_SESSION['ErrorMessage'] = "Bio should be less than 500 characters";
        Redirect_to("MyProfile.php");
    } 
    else {
        ///Query to update admin data in DB when everything is fine
        global $ConnectingDB;
        if (!empty($_FILES["Image"]["name"])) {
            $sql  = "UPDATE  admins SET aname='$AName',aheadline='$AHeadline', abio='$ABio', aimage='$Image' WHERE id='$AdminId'";
        } else{
            $sql  = "UPDATE  admins SET aname='$AName', aheadline='$AHeadline', abio='$ABio' WHERE id='$AdminId'";
        }
        $Execute = $ConnectingDB->query($sql);

        move_uploaded_file($_FILES["Image"]["tmp_name"], $Target);


        if ($Execute) {
            $_SESSION['SuccessMessage'] = " Details of Admin with name : " . $AName . " Updated Successfully";
            Redirect_to("MyProfile.php");
        } else {
            $_SESSION['ErrorMessage'] = "Something went wrong";
            Redirect_to("MyProfile.php");
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
    <title>My Profile</title>
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
                <h1><i class="fas fa-user text-success"></i> @<?php echo $ExistingUserName; ?> </h1>
                <small ><?php echo $ExistingHeadline; ?></small>
            </div>
        </div>
    </div>
</header>
<br />
<!-- END HEADER -->

<!-- Main area  -->

<section class="container py-2 mb-4">
    <div class="row">
        <!-- Left Area  -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-dark text-light">
                    <h3><?php
                        echo $ExistingName;
                        ?> </h3>
                </div>
                <div class="card-body">
                    <img src="Images/<?php echo $ExistingImage; ?>" class="block img-fluid mb-3">
                    <div class="">
                        <?php echo $ExistingBio; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Area  -->
        <div class="col-md-9">
            <?php echo ErrorMessage();
            echo SuccessMessage();
            ?>
            <form action="MyProfile.php" method="post" enctype="multipart/form-data">
                <div class="card bg-dark text-light">
                    <div class="card-header bg-secondary text-light">
                        <h4>Edit Profile</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" id="title" name="Name" placeholder="Your Name" class="form-control">
                        </div>
                        <div class="form-group">
                            <input type="text" id="title" name="Headline" placeholder="Headline" class="form-control">
                            <small class="text-muted">Add a professional headline like, 'Engineer' at XYX or 'Architect'</small>
                            <span class="text-danger">Not more than 30 characters</span>
                        </div>
                        <div class="form-group">
                           
                            <textarea class="form-control" placeholder="Bio..." name="Bio" id="post" cols="80" rows="8"></textarea>
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="File" class="custom-file-input" name="Image" id="imageSelect" value="">
                                <label for="imageSelect" class="custom-file-label">Select Image</label>
                            </div>
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
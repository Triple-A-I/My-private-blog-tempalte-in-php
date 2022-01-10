<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<!-- Fetching Existing Data  -->
<?php
$SearchQueryParameter = $_GET["username"];
global $ConnectingDB;
$sql = "SELECT aname,aheadline,abio,aimage FROM admins WHERE username=:userName";
$stmt = $ConnectingDB->prepare($sql);
$stmt->bindValue(":userName", $SearchQueryParameter);
$stmt->execute();
$Result = $stmt->rowCount();
if ($Result == 1) {
    while ($DataRows = $stmt->fetch()) {
        $ExistingName       = $DataRows["aname"];
        $ExistingBio        = $DataRows["abio"];
        $ExistingImage      = $DataRows["aimage"];
        $ExistingHeadline   = $DataRows["aheadline"];
    }
}else {
    $_SESSION["ErrorMessage"] = "User Not Found";
    Redirect_to("Blog.php?page=1");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.3/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
    <link rel="stylesheet" href="Css/styles.css" />
</head>

<body>
    <div style="height: 10px; background: powderblue"></div>
    <!-- NAVBAR   -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="#" class="navbar-brand" style="font-size: 38px; color: powderblue;">BIGOh</a>
            <button class="navbar-toggler" id="#navbarCollapseCMS" data-toggle="collapse" data-target="#navbarCollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapseCMS">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a href="blog.php" class="nav-link"><i class="fas fa-home" style="color: powderblue;"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-comment" style="color: powderblue;"></i> Posts</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-question" style="color: powderblue;"></i> About Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php" class="nav-link"><i class="fas fa-blog" style="color: powderblue;"></i> Blog</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-phone" style="color: powderblue;"></i> Contact Us</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-tools" style="color: powderblue;"></i> Features</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form action="blog.php" method="get" class="form-group form-inline d-none d-sm-block">
                        <input type="text" class="form-control" name="Search" placeholder="Type here">
                        <button class="btn" name="SearchButton" style=" margin-left: -20px; background-color: powderblue; color:grey;">Go</button>
                    </form>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 10px; background: powderblue"></div>
    <!-- NAVBAR-END -->


    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1> <i class="fas fa-user text-success mr-2"></i> <?php echo $ExistingName; ?></h1>
                    <h3><?php echo $ExistingHeadline; ?></h3>
                </div>
            </div>
        </div>
    </header>
    <br />
    <!-- END HEADER -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-md-3">
                <img src="Images/<?php echo $ExistingImage; ?>" class="d-block img-fluid mb-3 " style="width:200px ;height:200px;border-radius: 100px; " alt="">
            </div>
            <div class="col-md-9" style="min-height: 279px;">
                <div class="card">
                    <div class="card-body">
                        <p class="lead">
                            <?php echo $ExistingBio; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
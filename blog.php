<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<?php include("config.php"); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.3/css/all.css">
    <link rel="stylesheet" href="Css/styles.css" />
    <?php if ($_SESSION["lang"]=="ar") {
      ?>
   <link 
  rel="stylesheet"
  href="https://cdn.rtlcss.com/bootstrap/v4.2.1/css/bootstrap.min.css"
  integrity="sha384-vus3nQHTD+5mpDiZ4rkEPlnkcyTP+49BhJ4wJeJunw06ZAp+wzzeBPUXr42fi8If"
  crossorigin="anonymous">
   <?php }else{ ?>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
<?php } ?>
</head>

<body>
    <div style="height: 10px; background: powderblue"></div>
    <!-- NAVBAR   -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="#" class="navbar-brand" style="font-size: 38px; color: powderblue;"><?php echo $lang["logo"]; ?></a>
            <button class="navbar-toggler" id="#navbarCollapseCMS" data-toggle="collapse" data-target="#navbarCollapseCMS">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapseCMS">
                <ul class="navbar-nav mr-auto">

                    <li class="nav-item">
                        <a href="blog.php" class="nav-link"><i class="fas fa-home" style="color: powderblue;"></i> <?php echo $lang["home"]; ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-comment" style="color: powderblue;"></i> <?php echo $lang["posts"]; ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-question" style="color: powderblue;"></i> <?php echo $lang["about_us"]; ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="blog.php" class="nav-link"><i class="fas fa-blog" style="color: powderblue;"></i> <?php echo $lang["blog"]; ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-phone" style="color: powderblue;"></i><?php echo $lang["contact_us"]; ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link"><i class="fas fa-tools" style="color: powderblue;"></i> <?php echo $lang["features"]; ?></a>
                    </li>
                    
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form action="blog.php" method="get" class="form-group form-inline d-none d-sm-block">
                        <input type="text" class="form-control" name="Search" placeholder="Type here">
                        <button class="btn" name="SearchButton" style=" margin-left: -20px; background-color: powderblue; color:grey;">Go</button>
                    </form>
                    <li class="nav-item ml-4 align-self-start">
                        <a href="blog.php?lang=ar" style="text-decoration: none;" >AR</a> | 
                        <a href="blog.php?lang=en" style="text-decoration: none;" >EN</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div style="height: 10px; background: powderblue"></div>
    <!-- NAVBAR-END -->

    <!-- HEADER -->
    <div class="container">
        <div class="row">

            <!-- Main Area -->
            <div class="col-sm-8 mt-4">
                <h1>The Complete Responsive CMS Blog</h1>
                <h1 class="lead">The Complete blog by using PHP by Albraa Abdalla</h1>
                <?php echo ErrorMessage();
                echo SuccessMessage();
                ?>
                <?php
                global $ConnectingDB;
                if (isset($_GET["SearchButton"])) {
                    $Search = $_GET["Search"];
                    $sql = "SELECT * From posts 
                    WHERE dateandtime LIKE :search 
                    OR title LIKE :search 
                    OR category LIKE :search 
                    OR post LIKE :search";

                    $stmt = $ConnectingDB->prepare($sql);
                    $stmt->bindValue(":search", "%" . $Search . "%");
                    $stmt->execute();
                }
                ///Query when pagination is active 
                elseif (isset($_GET["page"])) {
                    $Page = $_GET["page"];
                    if ($Page < 1) {
                        $ShowPostFrom = 0;
                    } else {
                        $ShowPostFrom = ($Page * 5) - 5;
                    }
                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT $ShowPostFrom,5";
                    $stmt = $ConnectingDB->query($sql);
                }
                /// Query when Category is active in URL
                elseif (isset($_GET["category"])) {
                    $FetchedCategory = $_GET["category"];
                    $sql = "SELECT * FROM posts WHERE category='$FetchedCategory'";
                    $stmt = $ConnectingDB->query($sql);
                } else {
                    $sql = "SELECT * From posts ORDER BY id DESC LIMIT 0,3";
                    $stmt = $ConnectingDB->query($sql);
                }
                while ($DataRows = $stmt->fetch()) {
                    $PostId          = $DataRows["id"];
                    $DateTime        = $DataRows["dateandtime"];
                    $PostTitle       = $DataRows["title"];
                    $Category        = $DataRows["category"];
                    $Admin           = $DataRows["author"];
                    $Image           = $DataRows["image"];
                    $PostDescription = $DataRows["post"];
                ?>
                    <div class="card my-2">
                        <img src="Uploads/<?php echo htmlentities($Image); ?>" alt="<?php echo  htmlentities($Image) ?>" class="img-thumbnail img-card-top" style="max-height: 350px;">
                        <div class="card-body">
                            <h4 class="card-title">
                                <?php echo $PostTitle; ?>
                            </h4>
                            <span class="badge badge-dark text-light mr-1" style="float: left;">
                                <a href="blog.php?category=<?php echo htmlentities($Category); ?>">
                                    <?php
                                    echo htmlentities($Category);
                                    ?>

                                </a>

                            </span>
                            <small class="text-muted ">Written By <a class='text-dark badge' href="Profile.php?username=<?php echo $Admin; ?>"><?php echo $Admin; ?></a> On <?php echo htmlentities($DateTime); ?></small>
                            <span class="badge badge-dark text-light" style="float: right;">
                                Comments
                                <?php $NumberOfComments = Fetch_Comments_Number_According_To_Status('ON', $PostId);
                                echo $NumberOfComments;    ?>
                            </span>
                            <hr>
                            <p class="card-text"> <?php
                                                    if (strlen($PostDescription) > 100) {
                                                        $PostDescription = substr($PostDescription, 0, 200) . " ... ";
                                                    }

                                                    echo htmlentities($PostDescription); ?></p>
                            <a href="FullPost.php?id=<?php echo $PostId; ?>" style="float: right;">
                                <span class="btn btn-secondary">Read More ... </span></a>
                        </div>
                    </div><?php } ?>

                <!-- Pagination Starts -->
                <?php if (isset($Page)) { ?>
                    <nav>
                        <ul class="pagination pagination-md">
                            <!-- Creating Backward Button  -->
                            <?php
                            if (isset($Page)) {
                                if ($Page > 1) {
                            ?>
                                    <li class="page-item ">
                                        <a class="page-link" href="Blog.php?page=<?php echo $Page - 1 ?>">&laquo;</a>
                                    </li>
                            <?php }
                            } ?>
                            <!-- Ending Backward Button -->

                            <?php
                            global $ConnectingDB;
                            $sql = "SELECT COUNT(*) FROM posts";
                            $stmt = $ConnectingDB->query($sql);
                            $RowsPagination = $stmt->fetch();
                            $TotalPosts = array_shift($RowsPagination);
                            $PostPagination = $TotalPosts / 5;
                            $PostPagination = ceil($PostPagination);


                            for ($i = 1; $i <= $PostPagination; $i++) { ?>


                                <?php if ($i == $Page) { ?>
                                    <li class="page-item active">
                                        <a class="page-link" href="Blog.php?page=<?php echo $i ?>"><?php echo $i ?></a>
                                    </li>
                                <?php  } else { ?>
                                    <li class="page-item ">
                                        <a class="page-link" href="Blog.php?page=<?php echo $i ?>"><?php echo $i ?></a>
                                    </li>
                        <?php }
                            }
                        }
                        ?>

                        <!-- Creating Forward Button  -->
                        <?php
                        if (isset($Page)) {
                            if ($Page + 1 <= $PostPagination) {
                        ?>
                                <li class="page-item ">
                                    <a class="page-link" href="Blog.php?page=<?php echo $Page + 1 ?>">&raquo;</a>
                                </li>
                        <?php }
                        } ?>
                        <!-- Ending Forward Button -->
                        </ul>
                    </nav>



                    <!-- Pagination Ends   -->
            </div>
            <!-- End Main Area -->



            <!-- Side Area -->
            <div class="col-sm-4">
                <div class="card mt-4">
                    <div class="card-body">
                        <img src="Images/_large_image_3.jpg" class="d-block img-fluid mb-3">
                        <div class="text-center">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Cum, assumenda? Officiis velit ad incidunt quisquam recusandae illo,
                            at nam ducimus nemo reprehenderit nobis magni ex repudiandae dolorem earum nulla. Adipisci?
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h2 class="lead">Sign Up !</h2>
                    </div>
                    <div class="card-body">
                        <button class="btn btn-block btn-success text-center mb-2">Join the Forum</button>
                        <button class="btn btn-block btn-danger text-center mb-3">Login</button>
                        <div class="input-group mb-3">
                            <input type="text" name="" class="form-control" placeholder="Enter your email here">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-sm text-center text-white" name="email">Subscribe!</button>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-secondary text-light">
                        <h2 class="lead"><i class="fas fa-folder text-light"></i> Categories</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        global $ConnectingDB;
                        $sql = "SELECT * FROM category ORDER BY id DESC";
                        $stmt = $ConnectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $CategoryId = $DataRows["id"];
                            $CategoryName = $DataRows["title"];
                        ?>

                            <a target="_target" href="blog.php?category=<?php echo $CategoryName; ?>" style="  text-decoration: none "> <span class="bg-secondary text-light d-block mb-2 p-2" style="border-radius: 10px;"><?php echo $CategoryName . "<br>"; ?></span></a>
                        <?php } ?>
                    </div>
                </div>
                <br>
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h2 class="lead"><i class="fas fa-clock text-light"></i> Recent Posts</h2>
                    </div>
                    <div class="card-body">
                        <?php
                        global $ConnectingDB;
                        $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0,5";
                        $stmt = $ConnectingDB->query($sql);
                        while ($DataRows = $stmt->fetch()) {
                            $PostId = $DataRows["id"];
                            $PostTitle = $DataRows["title"];
                            $DateTime = $DataRows["dateandtime"];
                            $Image = $DataRows["image"];
                        ?>
                            <div class="media">
                                <img src="Uploads/<?php echo $Image; ?>" class="d-block img-fluid align-self-start" width="90" height="94">
                                <div class="media-body ml-2">
                                    <a target="_blank" href="FullPost.php?id=<?php echo $PostId; ?>" class="text-dark">
                                        <h6 class="lead"><?php echo $PostTitle; ?></h6>
                                    </a>
                                    <p class="small"><?php echo $DateTime; ?></p>
                                </div>
                            </div>
                            <hr>
                        <?php } ?>

                    </div>
                </div>
            </div>
            <!-- End Side Area -->

        </div>
    </div>
    <!-- END HEADER -->

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
   
    <?php if ($_SESSION["lang"]=="ar") {
      ?>
      <script
  src="https://cdn.rtlcss.com/bootstrap/v4.2.1/js/bootstrap.min.js"
  integrity="sha384-a9xOd0rz8w0J8zqj1qJic7GPFfyMfoiuDjC9rqXlVOcGO/dmRqzMn34gZYDTel8k"
  crossorigin="anonymous"></script>
   
   <?php }else{ ?>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    
<?php } ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
</body>

</html>


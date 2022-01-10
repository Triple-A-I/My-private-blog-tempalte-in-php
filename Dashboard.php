<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"]; ?>

<?php
Login_Confirm(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.3/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
    <link rel="stylesheet" href="Css/styles.css" />
</head>
<?php include("AdminNav.php"); ?> 


    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <?php
            // echo $_SESSION["userName"]; 
            ?>
            <div class="row">
                <div class="col-md-12">
                    <h1><i class="fas fa-cog" style="color: powderblue;"></i> Dashboard </h1>
                </div>
                <div class="col-lg-3  col-md-6 mb-2">
                    <a href="AddNewPost.php" class="btn btn-primary btn-block">
                        <i class="fas fa-edit"></i> Add New Post
                    </a>
                </div>
                <div class="col-lg-3 col-md-6  mb-2">
                    <a href="Categories.php" class="btn btn-info btn-block">
                        <i class="fas fa-folder-plus"></i> Add New Category
                    </a>
                </div>
                <div class="col-lg-3 col-md-6  mb-2">
                    <a href="Admins.php" class="btn btn-warning btn-block">
                        <i class="fas fa-user-plus"></i> Add New Admin
                    </a>
                </div>
                <div class="col-lg-3 col-md-6  mb-2">
                    <a href="Comments.php" class="btn btn-success btn-block">
                        <i class="fas fa-check"></i> Approve Comments
                    </a>
                </div>
            </div>
        </div>
    </header>
    <br />
    <!-- END HEADER -->


    <!-- Main Area -->
    <?php
    echo ErrorMessage();
    echo SuccessMessage();
    ?>
    <section class="container py-2 mb-4">
        <div class="row">

            <!-- Left Side area starts -->

            <div class="col-lg-2 d-none d-md-block">
                <a href="Posts.php" class="btn btn-block btn-lg">
                    <div class="card text-center bg-dark text-white">
                        <div class="card-body">
                            <h1 class="lead">Posts</h1>
                            <h4 class="display-5">
                                <i class="fab fa-readme"></i>
                                <?php
                                Count_Item('posts');
                                ?>
                            </h4>
                        </div>
                    </div>
                </a>
                <a href="Categories.php" class="btn btn-block btn-lg">
                    <div class="card text-center bg-dark text-white">
                        <div class="card-body">
                            <h1 class="lead">Categories</h1>
                            <h4 class="display-5">
                                <i class="fas fa-folder"></i>
                                <?php
                                Count_Item('category');
                                ?>
                            </h4>
                        </div>
                    </div>
                </a>
                <a href="Comments.php" class="btn btn-block btn-lg">
                    <div class="card text-center bg-dark text-white">
                        <div class="card-body">
                            <h1 class="lead">Comments</h1>
                            <h4 class="display-5">
                                <i class="fas fa-comments"></i>
                                <?php
                                Count_Item('comments');
                                ?>
                            </h4>
                        </div>
                    </div>
                </a>
                <a href="admins.php" class="btn btn-block btn-lg">
                    <div class="card text-center bg-dark text-white">
                        <div class="card-body">
                            <h1 class="lead">Admins</h1>
                            <h4 class="display-5">
                                <i class="fas fa-users"></i>
                                <?php
                                Count_Item('admins');
                                ?>
                            </h4>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Left Side area ends -->



            <!-- Right Side area starts -->
            <div class="col-lg-10">
                <h1>Total Posts</h1>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No.</th>
                            <th>Title</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Comments</th>
                            <th>Preview</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM posts ORDER BY id DESC LIMIT 0,5";
                    $stmt = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $stmt->fetch()) {
                        $PostId = $DataRows["id"];
                        $DateTime = $DataRows["dateandtime"];
                        $Author = $DataRows["author"];
                        $Title = $DataRows["title"];
                        $SrNo++;

                    ?>

                        <tbody>
                            <tr>
                                <td><?php echo $SrNo; ?></td>
                                <td><?php echo $Title; ?></td>
                                <td><?php echo $DateTime; ?></td>
                                <td><?php echo $Author; ?></td>
                                <td>
                                    <a href="Comments.php">
                                        <?php
                                        $NumberOfApprovedComments = Fetch_Comments_Number_According_To_Status('ON', $PostId);
                                        if ($NumberOfApprovedComments > 0) { ?>
                                            <span class="badge badge-success">
                                                <?php echo $NumberOfApprovedComments; ?>
                                            </span>
                                        <?php } ?>
                                    </a>

                                    <a href="Comments.php">
                                        <?php
                                        $NumberOfDisApprovedComments = Fetch_Comments_Number_According_To_Status('OFF', $PostId);
                                        if ($NumberOfDisApprovedComments > 0) { ?>
                                            <span class="badge badge-danger">
                                                <?php echo $NumberOfDisApprovedComments; ?>
                                            </span>
                                        <?php } ?>
                                    </a>
                                </td>
                                <td><a href="FullPost.php?id=<?php echo $PostId; ?>"><i class="fas fa-link text-info"></i></a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                </table>
            </div>
            <!-- Right Side area ends -->

        </div>
    </section>


    <!-- End Main Area -->



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
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
    <title>Document</title>
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
                    <h1><i class="fas fa-blog" style="color: powderblue;"></i> Blog Posts </h1>
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
    <?php echo ErrorMessage();
    echo SuccessMessage(); ?>

    <!-- Main Area -->

    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-hover table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Date&Time</th>
                            <th>Author</th>
                            <th>Banner</th>
                            <th>Comments</th>
                            <th>Actions</th>
                            <th>Live Preview</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        global $ConnectingDB;
                        $sql  = "SELECT * FROM posts";
                        $stmt = $ConnectingDB->query($sql);
                        $Sr = 0;
                        while ($DataRows = $stmt->fetch()) {
                            $Id         = $DataRows["id"];
                            $DateTime   = $DataRows["dateandtime"];
                            $PostTitle      = $DataRows["title"];
                            $Category   = $DataRows["category"];
                            $Admin      = $DataRows["author"];
                            $Image      = $DataRows["image"];
                            $PostText   = $DataRows["post"];
                            $Sr++;
                        ?>
                            <tr>
                                <td><?php echo $Sr; ?></td>
                                <td>
                                    <?php
                                    if (strlen($PostTitle) > 20) {
                                        $PostTitle = substr($PostTitle, 0, 18) . "...";
                                    }

                                    echo $PostTitle ?>
                                </td>
                                <td>
                                    <?php
                                    if (strlen($Category) > 8) {
                                        $Category = substr($Category, 0, 8) . "...";
                                    }
                                    echo $Category ?>
                                </td>
                                <td>
                                    <?php
                                    if (strlen($DateTime) > 11) {
                                        $DateTime = substr($DateTime, 0, 11) . "...";
                                    }

                                    echo $DateTime ?>
                                </td>
                                <td>
                                    <?php

                                    if (strlen($Admin) > 6) {
                                        $Admin = substr($Admin, 0, 6) . "...";
                                    }

                                    echo $Admin ?></td>
                                <td>
                                    <img src="Uploads/<?php echo $Image ?>" alt="<?php echo $Image ?>" width="90px;" height="70px;">
                                </td>
                                <td>
                                    <a href="Comments.php">
                                        <?php
                                        $NumberOfApprovedComments = Fetch_Comments_Number_According_To_Status('ON', $Id);
                                        if ($NumberOfApprovedComments > 0) { ?>
                                            <span class="badge badge-success">
                                                <?php echo $NumberOfApprovedComments; ?>
                                            </span>
                                        <?php } ?>
                                    </a>

                                    <a href="Comments.php">
                                        <?php
                                        $NumberOfDisApprovedComments = Fetch_Comments_Number_According_To_Status('OFF', $Id);
                                        if ($NumberOfDisApprovedComments > 0) { ?>
                                            <span class="badge badge-danger">
                                                <?php echo $NumberOfDisApprovedComments; ?>
                                            </span>
                                        <?php } ?>
                                    </a>
                                </td>
                                <td>
                                    <a href="EditPost.php?id=<?php echo $Id; ?>" class="btn btn-warning btn-sm btn-block" target="_blank">Edit</a>
                                    <a href="DeletePost.php?id=<?php echo $Id; ?>" class="btn btn-danger btn-sm btn-block" target="_blank">Delete</a>
                                </td>
                                <td>
                                    <a href="FullPost.php?id=<?php echo $Id; ?>" class="btn btn-primary btn-sm btn-block" target="_blank">Live Preview</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
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
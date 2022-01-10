<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"];
Login_Confirm(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Comments</title>
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
                    <h1> <i style="color: powderblue;" class="fas fa-comments"></i> Manage Comments</h1>
                </div>
            </div>
        </div>
    </header>
    <!-- END HEADER -->

    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
    <?php echo ErrorMessage();
                echo SuccessMessage();
                ?>
        <div class="row" style="min-height: 30px;">
            <div class="col-lg-12" style="min-height: 400px;">
                <h2>Un-Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Approve</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM comments WHERE status='OFF' ORDER BY id DESC";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CommentId          = $DataRows["id"];
                        $DateTimeOfComment  = $DataRows["dateandtime"];
                        $CommenterName      = $DataRows["name"];
                        $CommentContent     = $DataRows["comment"];
                        $CommentPostId      = $DataRows["post_id"];
                        $SrNo++;
                        if (strlen($DateTimeOfComment)>12) {
                            $DateTimeOfComment = substr($DateTimeOfComment,0,12). "..";
                        }
                        
                        if (strlen($CommenterName)>10) {
                            $CommenterName = substr($CommenterName,0,10). "..";
                        }

                    ?>
                        <tbody>
                            <tr>
                                <td> <?php echo $SrNo; ?></td>
                                <td> <?php echo $CommenterName; ?></td>
                                <td> <?php echo $DateTimeOfComment; ?></td>
                                <td> <?php echo $CommentContent; ?></td>
                                <td> <a href="ApproveComments.php?id=<?php echo $CommentId; ?>" class="text-success"><i class="fas fa-check"></i></a></td>
                                <td> <a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                </table>


                <!-- Approved Comments Starts -->


                <h2>Approved Comments</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Name</th>
                            <th>Date&Time</th>
                            <th>Comment</th>
                            <th>Revert</th>
                            <th>Delete</th>
                            <th>Live</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM comments WHERE status='ON' ORDER BY id DESC";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CommentId          = $DataRows["id"];
                        $DateTimeOfComment  = $DataRows["dateandtime"];
                        $CommenterName      = $DataRows["name"];
                        $CommentContent     = $DataRows["comment"];
                        $CommentPostId      = $DataRows["post_id"];
                        $SrNo++;
                        if (strlen($DateTimeOfComment)>12) {
                            $DateTimeOfComment = substr($DateTimeOfComment,0,12). "..";
                        }
                        
                        if (strlen($CommenterName)>10) {
                            $CommenterName = substr($CommenterName,0,10). "..";
                        }

                    ?>
                        <tbody>
                            <tr>
                                <td> <?php echo $SrNo; ?></td>
                                <td> <?php echo $CommenterName; ?></td>
                                <td> <?php echo $DateTimeOfComment; ?></td>
                                <td> <?php echo $CommentContent; ?></td>
                                <td> <a href="DisApproveComments.php?id=<?php echo $CommentId; ?>" class="text-dark btn btn-sm btn-outline-warning">x</a></td>
                                <td> <a href="DeleteComments.php?id=<?php echo $CommentId; ?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
                                <td>
                                    <a target="_blank" class="text-primary" href="FullPost.php?id=<?php echo $CommentPostId; ?>">
                                        <i class="fas fa-link"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                </table>
                <!-- Approved Comments Ends -->

            </div>
        </div>
    </section>

    <!-- Main Area End -->


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
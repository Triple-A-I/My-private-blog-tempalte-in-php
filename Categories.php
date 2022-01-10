<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"]; ?>

<?php
 Login_Confirm();?>

<?php
    if (isset($_POST['Submit'])) {
        $Category = $_POST['CategoryTitle'];
        $Admin = $_SESSION["userName"];
        $CurrentTime = time();
        $DateTime = strftime("%B-%d-%Y %H:%M", $CurrentTime);
        if (empty($Category)) {
            $_SESSION['ErrorMessage'] = "All fields must be filled out";
            Redirect_to("Categories.php");
        } elseif (strlen($Category) < 3) {
            $_SESSION['ErrorMessage'] = "Category Title should be greater than 2 characters";
            Redirect_to("Categories.php");
        } else {
            global $ConnectingDB;
            $sql  = "INSERT INTO category(title,author,dateandtime)";
            $sql .= "VALUES(:categoryName,:adminName,:dateTime)";
            $stmt = $ConnectingDB->prepare($sql);

            $stmt->bindValue(':categoryName', $Category);
            $stmt->bindValue(':adminName', $Admin);
            $stmt->bindValue(':dateTime', $DateTime);

            $EXecute = $stmt->execute();

            if ($EXecute) {
                $_SESSION['SuccessMessage'] = "Category with id " . $ConnectingDB->lastInsertId() . " Added Successfully";
                Redirect_to("Categories.php");
            } else {
                $_SESSION['ErrorMessage'] = "Something went wrong";
                Redirect_to("Categories.php");
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
    <title>Categories</title>
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
                    <h1><i class="fas fa-edit"></i> Manage Categories</h1>
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
                <form action="Categories.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Category</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="title" class="FieldInfo">Category Title:</label>
                                <input type="text" id="title" name="CategoryTitle" placeholder="Add title here" class="form-control">
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-2">
                                    <a href="Dashboard.php" class="btn btn-warning btn-block"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
                                </div>
                                <div class="col-lg-6 mb-2">
                                    <button type="submit" name="Submit" class="btn btn-success btn-block"><i class="fas fa-check"></i> Publish</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                  <!-- Existing Categories Starts -->


                  <h2><i class="fas fa-table"></i> Existing Categories</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Date&Time</th>
                            <th>Category Name</th>
                            <th>Creator Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM category ORDER BY id DESC";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $CategoryId          = $DataRows["id"];
                        $DateTime  = $DataRows["dateandtime"];
                        $CreatorName      = $DataRows["author"];
                        $CategoryName     = $DataRows["title"];
                        $SrNo++;

                    ?>
                        <tbody>
                            <tr>
                                <td> <?php echo $SrNo; ?></td>
                                <td> <?php echo $DateTime; ?></td>
                                <td> <?php echo $CategoryName; ?></td>
                                <td> <?php echo $CreatorName; ?></td>
                                <td> <a href="DeleteCategory.php?id=<?php echo $CategoryId; ?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                </table>
                <!-- Existing Categories Ends -->
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
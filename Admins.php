<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<?php $_SESSION["TrackingURL"] = $_SERVER["PHP_SELF"]; ?>
<?php
 Login_Confirm(); ?>


<?php

if (isset($_POST['Submit'])) {
    $Username = $_POST['Username'];
    $Name = $_POST['Name'];
    $Password = $_POST['Password'];
    $ConfirmPassword = $_POST['ConfirmPassword'];
    $Admin = $_SESSION["userName"];
    $CurrentTime = time();
    $DateTime = strftime("%B-%d-%Y %H:%M", $CurrentTime);
    if (empty($Username) || empty($Password) || empty($ConfirmPassword)) {
        $_SESSION['ErrorMessage'] = "All fields must be filled out";
        Redirect_to("Admins.php");
    } elseif (strlen($Password) < 6) {
        $_SESSION['ErrorMessage'] = "Password should be greater than 5 characters";
        Redirect_to("Admins.php");
    } elseif ($Password !== $ConfirmPassword) {
        $_SESSION['ErrorMessage'] = "Password and Confirm Password should match";
        Redirect_to("Admins.php");
    } elseif (CheckIfUserExistOrNot($Username)) {
        $_SESSION['ErrorMessage'] = "Username is already exists, choose another one";
        Redirect_to("Admins.php");
    } else {
        global $ConnectingDB;
        $sql  = "INSERT INTO admins(dateandtime,username,password,aname,addedby)";
        $sql .= "VALUES(:dateandTime,:userName,:passworD,:anamE,:addedbY)";
        $stmt = $ConnectingDB->prepare($sql);

        $stmt->bindValue(':dateandTime', $DateTime);
        $stmt->bindValue(':userName', $Username);
        $stmt->bindValue(':passworD', $Password);
        $stmt->bindValue(':anamE', $Name);
        $stmt->bindValue(':addedbY', $Admin);

        $EXecute = $stmt->execute();

        if ($EXecute) {
            $_SESSION['SuccessMessage'] = "Admin with name of " . $Username . " Added Successfully";
            Redirect_to("Admins.php");
        } else {
            $_SESSION['ErrorMessage'] = "Something went wrong";
            Redirect_to("Admins.php");
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
    <title>Manage Admins</title>
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
                    <h1><i class="fas fa-edit"></i> Manage Admins</h1>
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
                <form action="admins.php" method="post">
                    <div class="card bg-secondary text-light mb-3">
                        <div class="card-header">
                            <h1>Add New Admin</h1>
                        </div>
                        <div class="card-body bg-dark">
                            <div class="form-group">
                                <label for="username" class="FieldInfo">Username:</label>
                                <input type="text" id="username" name="Username" placeholder="Add Username here" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="name" class="FieldInfo">Name:</label>
                                <input type="text" id="name" name="Name" placeholder="Add name here" class="form-control">
                                <small class="text-muted text-warning">Optional</small>
                            </div>
                            <div class="form-group">
                                <label for="password" class="FieldInfo">Password:</label>
                                <input type="password" id="password" name="Password" placeholder="Add Password here" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="confirmpassword" class="FieldInfo">Confirm Password:</label>
                                <input type="password" id="confirmpassword" name="ConfirmPassword" placeholder="Add Confirm Password here" class="form-control">
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
                                  <!-- Existing Admins Starts -->


                                  <h2><i class="fas fa-table"></i> Existing Admins</h2>
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>No. </th>
                            <th>Date&Time</th>
                            <th> Username</th>
                            <th>Admin Name</th>
                            <th>Added By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <?php
                    global $ConnectingDB;
                    $sql = "SELECT * FROM admins ORDER BY id DESC";
                    $Execute = $ConnectingDB->query($sql);
                    $SrNo = 0;
                    while ($DataRows = $Execute->fetch()) {
                        $AdminId          = $DataRows["id"];
                        $DateTime  = $DataRows["dateandtime"];
                        $UserName      = $DataRows["username"];
                        $AdminName     = $DataRows["aname"];
                        $AddedBy     = $DataRows["addedby"];
                        $SrNo++;

                    ?>
                        <tbody>
                            <tr>
                                <td> <?php echo $SrNo; ?></td>
                                <td> <?php echo $DateTime; ?></td>
                                <td> <?php echo $UserName; ?></td>
                                <td> <?php echo $AdminName; ?></td>
                                <td> <?php echo $AddedBy; ?></td>
                                <td> <a href="DeleteAdmin.php?id=<?php echo $AdminId; ?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                </table>
                <!-- Existing Admins Ends -->
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
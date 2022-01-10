<?php require_once('Includes/DB.php'); ?>
<?php require_once('Includes/functions.php'); ?>
<?php require_once('Includes/sessions.php'); ?>
<?php
if (isset($_SESSION["userId"])) {
    Redirect_to($_SESSION["TrackingURL"]);
}
if (isset($_POST["Submit"])) {
    $Username = $_POST["Username"];
    $Password = $_POST["Password"];
    if (empty($Username) || empty($Password)) {
        $_SESSION["ErrorMessage"] = "All fields must be filled out";
        Redirect_to("Login.php");
    } else {
        /// code for checking username and password from database
        $Found_Account = Login_Attempt($Username, $Password);
        if ($Found_Account) {
            $_SESSION["userId"] = $Found_Account["id"];
            $_SESSION["userName"] = $Found_Account["username"];
            $_SESSION["adminName"] = $Found_Account["aname"];
            $_SESSION["SuccessMessage"] = "Welcome " . $_SESSION["adminName"];
            if (isset($_SESSION["TrackingURL"])) {
                Redirect_to($_SESSION["TrackingURL"]);
            } else {
                Redirect_to("Dashboard.php");
            }
        } else {
            $_SESSION["ErrorMessage"] = "Username/Password Incorrect!";
            Redirect_to("Login.php");
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
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.6.3/css/all.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous" />
    <link rel="stylesheet" href="Css/styles.css" />
</head>

<body>
    <div style="height: 10px; background: powderblue"></div>
    <!-- NAVBAR   -->
    <nav class="navbar navbar-expand-lg bg-dark navbar-dark">
        <div class="container">
            <a href="#" class="navbar-brand">BIGoH</a>
        </div>
    </nav>
    <div style="height: 10px; background: powderblue"></div>
    <!-- NAVBAR-END -->

    <!-- HEADER -->
    <header class="bg-dark text-white py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                </div>
            </div>
        </div>
    </header>
    <br />
    <!-- END HEADER -->


    <!-- Start Main Area -->
    <section class="container py-2 mb-4">
        <div class="row">
            <div class="col-sm-6 offset-sm-3" style="min-height: 400px; ">
                <br>
                <?php echo ErrorMessage();
                echo SuccessMessage();
                ?>

                <div class="card bg-secondary text-light">
                    <div class="card-header">
                        <h4>Welcome Back!</h4>
                    </div>
                    <div class="card-body bg-dark">
                        <form action="Login.php" method="post">
                            <div class="form-group">
                                <label for="username"><span class="FieldInfo">Username:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white" style="background-color: powderblue;"><i class="fas fa-user"></i></span>
                                    </div>
                                    <input type="text" class="form-control" name="Username" id="username">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password"><span class="FieldInfo">Password:</span></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text text-white" style="background-color: powderblue;"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control" name="Password" id="password">
                                </div>
                            </div>
                            <input type="submit" name="Submit" class="btn btn-block " style="background-color: powderblue;" value="Login">
                        </form>
                    </div>
                </div>
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
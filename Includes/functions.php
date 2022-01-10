<?php
function Redirect_to($location){
    header("Location:".$location);
    exit;
}

function CheckIfUserExistOrNot($Username){
    global $ConnectingDB;
    $sql = "SELECT username FROM admins WHERE username=:userName";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(":userName",$Username);
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ($Result==1) {
        return true;
    }else {
        return false;
    }
}

function Login_Attempt($Username,$Password){
    global $ConnectingDB;
    $sql = "SELECT * FROM admins WHERE username=:userName AND password=:passWord LIMIT 1";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(":userName",$Username);
    $stmt->bindValue(":passWord",$Password);
    $stmt->execute();
    $Result = $stmt->rowCount();
    if ($Result==1) {
      return  $Found_Account = $stmt->fetch();
    }else {
        return null;
    }
}


function Login_Confirm(){
    if (isset($_SESSION["userId"])) {
        return true;
    }else {
        $_SESSION["ErrorMessage"]="Login Required!.";
        Redirect_to("Login.php");
        return false;
    }
}

function Count_Item($Table){
    global $ConnectingDB;
    $sql = "SELECT COUNT(*) FROM $Table";
    $stmt = $ConnectingDB->query($sql);
    $TotalRows = $stmt->fetch();
    $TotalPosts = array_shift($TotalRows);
    echo $TotalPosts;
}

function Fetch_Comments_Number_According_To_Status($Status,$PostId){
    global $ConnectingDB;
    $sqlApprove = "SELECT COUNT(*) FROM comments WHERE post_id='$PostId' AND status='$Status'";
    $stmtApprove = $ConnectingDB->query($sqlApprove);
    $RowsTotal = $stmtApprove->fetch();
    $Total = array_shift($RowsTotal);
    return $Total;
}
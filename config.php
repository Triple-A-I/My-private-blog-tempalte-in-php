<?php 

if (!isset($_SESSION["lang"])) {
    $_SESSION["lang"] = "en";
}
elseif(isset($_GET["lang"])&& $_SESSION["lang"] !=$_GET["lang"] && !empty($_GET["lang"])){
    if ($_GET["lang"]=="en") {
        $_SESSION["lang"] = "en";
    }else {
        $_SESSION["lang"] = "ar";
    }
}

require_once "Languages/" . $_SESSION["lang"] . ".php";
?>
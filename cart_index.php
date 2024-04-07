<?php
ob_start();
session_start();
include "config.php";

if (!isset($_SESSION["intLine"])) {
    $_SESSION["intLine"] = 0;
    $_SESSION["strProductID"] = array();
    $_SESSION["strQty"] = array();
    $_SESSION["strProductID"][0] = $_GET["id"];
    $_SESSION["strQty"][0] = 1;
    header("location:cart.php");
} else {
    if (!isset($_SESSION["strProductID"])) {
        $_SESSION["strProductID"] = array();
    }

    if (!isset($_SESSION["strQty"])) {
        $_SESSION["strQty"] = array();
    }

    $key = array_search($_GET["id"], $_SESSION["strProductID"]);
    if ($key !== false) {
        $_SESSION["strQty"][$key] = $_SESSION["strQty"][$key] + 1;
    } else {
        $_SESSION["intLine"] = $_SESSION["intLine"] + 1;
        $intNewLine = $_SESSION["intLine"];
        $_SESSION["strProductID"][$intNewLine] = $_GET["id"];
        $_SESSION["strQty"][$intNewLine] = 1;
    }
    header("location:index.php");
}
?>

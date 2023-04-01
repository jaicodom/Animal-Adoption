<?php
session_start();

if (!isset($_SESSION["user"]) && !isset($_SESSION["adm"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["logout"])) {
    unset($_SESSION["user"]);
    unset($_SESSION["adm"]);

    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

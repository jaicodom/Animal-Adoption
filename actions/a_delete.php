<?php
require_once '../components/db_connection.php';
require_once '../components/db_connection.php';
require_once '../components/file_upload.php';

session_start();


// if session is not set this will redirect to login page
if (!isset($_SESSION["adm"]) && !isset($_SESSION["user"])) {
    header("Location: ../users/login.php");
    exit;
}

//if session user exist it shouldn't access delete.php    
if (isset($_SESSION["user"])) {
    header("Location: ../home.php");
    exit;
}

//is is ADMIN, then continue:

if ($_POST) {
    $id = $_POST['id'];
    $picture = $_POST['picture'];
    ($picture == "animal.png") ?: unlink("../animals/pictures/$picture");


    $sql = "DELETE FROM animals WHERE id = {$id}";
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "Successfully Deleted!";
    } else {
        $class = "danger";
        $message = "The entry was not deleted due to: <br>" . $connect->error;
    }
    mysqli_close($connect);
} else {
    header("location: ../error.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Delete</title>
    <?php require_once '../components/bootstrap.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Delete request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?= $message; ?></p>
            <a href='../animals/animals_dashboard.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>

</html>
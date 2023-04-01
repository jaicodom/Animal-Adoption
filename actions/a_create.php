<?php
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
    header("Location: ../users/user_home.php");
    exit;
}

//is is ADMIN, then continue:

if ($_POST) {
    $name = $_POST['name'];
    $type = $_POST['type'];
    $location = $_POST["location"];
    $description = $_POST["description"];
    $size = $_POST["size"];
    $age = $_POST["age"];
    $color = $_POST["color"];
    $vaccinated = $_POST["vaccinated"];
    $status = $_POST["status"];

    $uploadError = '';
    $picture = file_upload($_FILES['picture'], "animal");

    $sql = "INSERT INTO `animals`(`name`, `location`, `picture`, `description`, `size`, `age`, `color`, `type`, `vaccinated`, `status`) VALUES ('$name','$location','$picture->fileName','$description','$size','$age','$color','$type','$vaccinated','$status')";

    if (mysqli_query($connect, $sql) === true) {
        $class = "success";
        $message = "The entry below was successfully created <br>
            <table class='table w-50'><tr>
            <td> $name </td>
            <td> $type </td>
            </tr></table><hr>";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    } else {
        $class = "danger";
        $message = "Error while creating record. Try again: <br>" . $connect->error;
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    }
    mysqli_close($connect);
} else {
    header("location: error.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Update</title>
    <?php require_once '../components/bootstrap.php' ?>
</head>

<body>
    <div class="container">
        <div class="mt-3 mb-3">
            <h1>Create request response</h1>
        </div>
        <div class="alert alert-<?= $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href="../animals/animals_dashboard.php"><button class="btn btn-primary" type='button'>Home</button></a>
        </div>
    </div>
</body>

</html>
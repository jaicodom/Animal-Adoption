<?php
require_once '../components/db_connection.php';
require_once '../components/file_upload.php';


session_start();


// if session is not set this will redirect to login page
if (!isset($_SESSION["adm"]) && !isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

//if session user exist it shouldn't access delete.php    
if (isset($_SESSION["user"])) {
    header("Location: home.php");
    exit;
}

//is is ADMIN, then continue:


if ($_POST) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $id = $_POST['id'];
    //variable for upload pictures errors is initialised
    $uploadError = '';

    $picture = file_upload($_FILES['picture'], "product"); //file_upload() called  
    if ($picture->error === 0) {
        ($_POST["picture"] == "product.png") ?: unlink("../pictures/$_POST[picture]");
        $sql = "UPDATE products SET name = '$name', price = $price, picture = '$picture->fileName' WHERE id = {$id}";
    } else {
        $sql = "UPDATE products SET name = '$name', price = $price WHERE id = {$id}";
    }
    if (mysqli_query($connect, $sql) === TRUE) {
        $class = "success";
        $message = "The record was successfully updated";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
    } else {
        $class = "danger";
        $message = "Error while updating record : <br>" . mysqli_connect_error();
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
            <h1>Update request response</h1>
        </div>
        <div class="alert alert-<?php echo $class; ?>" role="alert">
            <p><?php echo ($message) ?? ''; ?></p>
            <p><?php echo ($uploadError) ?? ''; ?></p>
            <a href='../products/product_update.php?= $id; ?>'><button class="btn btn-warning" type='button'>Back</button></a>
            <a href='../products/product_home.php'><button class="btn btn-success" type='button'>Home</button></a>
        </div>
    </div>
</body>

</html>
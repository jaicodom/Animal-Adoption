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
    header("Location: ../home.php");
    exit;
}

//is is ADMIN, then continue to this page:

//fetch and populate form

$id = $_GET['id'];
$sql = "SELECT * FROM animals WHERE id = {$id}";
$result = mysqli_query($connect, $sql);
$row = mysqli_fetch_assoc($result);


//update

if (isset($_POST["submit"])) {
    $name = $_POST["name"];
    $type = $_POST["type"];
    $location = $_POST["location"];
    $description = $_POST["description"];
    $size = $_POST["size"];
    $age = $_POST["age"];
    $color = $_POST["color"];
    $vaccinated = $_POST["vaccinated"];
    $status = $_POST["status"];


    //variable for upload pictures errors is initialized
    $uploadError = '';
    $picture = file_upload($_FILES['picture'], $src = "animal"); //file_upload() called


    if ($picture->error === 0) {
        ($_POST["picture"] == "animal.png") ?: unlink("pictures/$_POST[picture]");

        $sql_update = "UPDATE animals SET `name`='$name',`location`='$location',`picture`='$picture->fileName',`description`='$description',`size`='$size',`age`='$age',`color`='$color',`type`='$type',`vaccinated`='$vaccinated',`status`='$status' WHERE id = {$id}";
    } else {

        $sql_update = "UPDATE animals SET `name`='$name',`location`='$location',`description`='$description',`size`='$size',`age`='$age',`color`='$color',`type`='$type',`vaccinated`='$vaccinated',`status`='$status' WHERE id = {$id}";
    }
    if (mysqli_query($connect, $sql_update) === true) {

        $message = "The record was successfully updated";
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        header("Location: animals_dashboard.php");
    } else {

        $message = "Error while updating record : <br>" . $connect->error;
        $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        header("refresh:3;url=animal_update.php?id={$id}");
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.108.0">
    <?php require_once '../components/bootstrap.php' ?>



    <title>Animal Kingdom</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/headers/">
    <!-- Favicons -->
    <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="apple-touch-icon" href="/docs/5.2/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
    <link rel="manifest" href="/docs/5.2/assets/img/favicons/manifest.json">
    <link rel="mask-icon" href="/docs/5.2/assets/img/favicons/safari-pinned-tab.svg" color="#712cf9">
    <link rel="icon" href="/docs/5.2/assets/img/favicons/favicon.ico">
    <meta name="theme-color" content="#712cf9">


    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        .b-example-divider {
            height: 3rem;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
        }

        .b-example-vr {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
        }

        .bi {
            vertical-align: -.125em;
            fill: currentColor;
        }

        .nav-scroller {
            position: relative;
            z-index: 2;
            height: 2.75rem;
            overflow-y: hidden;
        }

        .nav-scroller .nav {
            display: flex;
            flex-wrap: nowrap;
            padding-bottom: 1rem;
            margin-top: -1px;
            overflow-x: auto;
            text-align: center;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }

        .nav-link {
            color: black;
        }
    </style>




</head>

<body class="bg-success-subtle">

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">

        <symbol id="home" viewBox="0 0 16 16">
            <path d="M8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4.5a.5.5 0 0 0 .5-.5v-4h2v4a.5.5 0 0 0 .5.5H14a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146zM2.5 14V7.707l5.5-5.5 5.5 5.5V14H10v-4a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5v4H2.5z" />
        </symbol>
        <symbol id="speedometer2" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5V6a.5.5 0 0 1-1 0V4.5A.5.5 0 0 1 8 4zM3.732 5.732a.5.5 0 0 1 .707 0l.915.914a.5.5 0 1 1-.708.708l-.914-.915a.5.5 0 0 1 0-.707zM2 10a.5.5 0 0 1 .5-.5h1.586a.5.5 0 0 1 0 1H2.5A.5.5 0 0 1 2 10zm9.5 0a.5.5 0 0 1 .5-.5h1.5a.5.5 0 0 1 0 1H12a.5.5 0 0 1-.5-.5zm.754-4.246a.389.389 0 0 0-.527-.02L7.547 9.31a.91.91 0 1 0 1.302 1.258l3.434-4.297a.389.389 0 0 0-.029-.518z" />
            <path fill-rule="evenodd" d="M0 10a8 8 0 1 1 15.547 2.661c-.442 1.253-1.845 1.602-2.932 1.25C11.309 13.488 9.475 13 8 13c-1.474 0-3.31.488-4.615.911-1.087.352-2.49.003-2.932-1.25A7.988 7.988 0 0 1 0 10zm8-7a7 7 0 0 0-6.603 9.329c.203.575.923.876 1.68.63C4.397 12.533 6.358 12 8 12s3.604.532 4.923.96c.757.245 1.477-.056 1.68-.631A7 7 0 0 0 8 3z" />
        </symbol>
        <symbol id="table" viewBox="0 0 16 16">
            <path d="M0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm15 2h-4v3h4V4zm0 4h-4v3h4V8zm0 4h-4v3h3a1 1 0 0 0 1-1v-2zm-5 3v-3H6v3h4zm-5 0v-3H1v2a1 1 0 0 0 1 1h3zm-4-4h4V8H1v3zm0-4h4V4H1v3zm5-3v3h4V4H6zm4 4H6v3h4V8z" />
        </symbol>
        <symbol id="people-circle" viewBox="0 0 16 16">
            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
        </symbol>
        <symbol id="grid" viewBox="0 0 16 16">
            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5v-3zM2.5 2a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zM1 10.5A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3zm6.5.5A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5v-3zm1.5-.5a.5.5 0 0 0-.5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 0-.5-.5h-3z" />
        </symbol>
    </svg>

    <header>
        <div class="px-3 py-2 bg-warning bg-gradient">

            <div class="container">


                <div class="d-flex flex-wrap align-items-center  justify-content-lg-center ">



                    <div class="nav col-12 col-lg-auto justify-content-center text-black ">
                        <a href="../users/dashboard.php" class="nav-link">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24">
                                <use xlink:href="#speedometer2"></use>
                            </svg>
                            Dashboard
                        </a>



                        <a href="../animals/animals_dashboard.php" class="nav-link">
                            <svg class="bi d-block mx-auto mb-1" width="24" height="24">
                                <use xlink:href="#grid"></use>
                            </svg>
                            Animals
                        </a>


                        <a href="logout.php?logout">
                            <button type="button" class="btn btn-secondary m-3">
                                Sign-out
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>


    </header>
    <div class="container">
        <fieldset class="m-5">
            <legend class='h2'>Update animal data</legend>
            <form method="post" enctype="multipart/form-data">
                <table class='table'>
                    <tr>
                        <th>Name</th>
                        <td><input class='form-control' type="text" name="name" placeholder="Animal Name" value="<?= $row['name'] ?>" required /></td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td><select class="form-select" aria-label="Select a animal type" name="type" required>
                                <option selected><?= $row['type'] ?></option>
                                <option value="Dog">Dog</option>
                                <option value="Cat">Cat</option>
                                <option value="Bird">Bird</option>
                            </select></td>
                    </tr>
                    <tr>
                        <th>Location</th>
                        <td><input class='form-control' type="text" name="location" placeholder="Location" value="<?= $row['location'] ?>" required /></td>
                    </tr>
                    <tr>
                        <th>Picture</th>
                        <td><input class='form-control' type="file" name="picture" /></td>
                    </tr>
                    <tr>
                        <th>Description</th>
                        <td><input class="form-control" name="description" placeholder="Write a short description (max 255 charachters)" value="<?= $row['description'] ?>" required>

                        </td>
                    </tr>
                    <tr>
                        <th>Size</th>
                        <td><select class="form-select" aria-label="Select a size" name="size" required>
                                <option selected><?= $row['size'] ?></option>
                                <option value="Small">Small</option>
                                <option value="Medium">Medium</option>
                                <option value="Large">Large</option>
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td><input class="form-control" type="number" name="age" step="1" placeholder="Enter an age" maxlength="3" value="<?= $row['age'] ?>" required>

                        </td>
                    </tr>
                    <tr>
                        <th>Color</th>
                        <td><input class='form-control' type="text" name="color" placeholder="Enter a color" value="<?= $row['color'] ?>" /></td>
                    </tr>
                    <tr>
                        <th>Vaccinated</th>
                        <td><select class="form-select" name="vaccinated" required>
                                <option selected><?= $row['vaccinated'] ?></option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>

                            </select>

                        </td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><select class="form-select" name="status" required>
                                <option selected><?= $row['status'] ?></option>
                                <option value="Adopted">Adopted</option>
                                <option value="Available">Available</option>

                            </select>

                        </td>
                    </tr>


                </table>
                <button name="submit" class="btn btn-success" type="submit">Update</button>
                <a href="animals_dashboard.php" class='btn btn-warning' type="button">Back</a>
            </form>
        </fieldset>
    </div>
</body>

</html>
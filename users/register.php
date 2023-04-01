<?php
session_start(); // start a new session or continues the previous
require_once '../components/db_connection.php';
require_once '../components/file_upload.php';

if (isset($_SESSION['user']) != "") {
    header("Location: home.php"); // redirects to home.php
}
if (isset($_SESSION['adm']) != "") {
    header("Location: dashboard.php"); // redirects to home.php
}

$error = false;
$fname = $lname = $email = $phone_number = $address = $pass = $picture = '';
$fnameError = $lnameError = $emailError = $phoneError = $addressError = $passError = $picError = '';
if (isset($_POST['btn-signup'])) {

    // sanitise user input to prevent sql injection
    // trim - strips whitespace (or other characters) from the beginning and end of a string
    $fname = trim($_POST['fname']);
    // strip_tags -- strips HTML and PHP tags from a string
    $fname = strip_tags($fname);
    // htmlspecialchars converts special characters to HTML entities
    $fname = htmlspecialchars($fname);

    $lname = trim($_POST['lname']);
    $lname = strip_tags($lname);
    $lname = htmlspecialchars($lname);

    $email = trim($_POST['email']);
    $email = strip_tags($email);
    $email = htmlspecialchars($email);

    $phone_number = trim($_POST['phone_number']);
    $phone_number = strip_tags($phone_number);
    $phone_number = htmlspecialchars($phone_number);

    $pass = trim($_POST['pass']);
    $pass = strip_tags($pass);
    $pass = htmlspecialchars($pass);

    $address = trim($_POST['address']);
    $address = strip_tags($address);
    $address = htmlspecialchars($address);

    $uploadError = '';
    $picture = file_upload($_FILES['picture'], "user");

    // basic name validation
    if (empty($fname) || empty($lname)) {
        $error = true;
        $fnameError = "Please enter your full name and surname";
    } else if (strlen($fname) < 3 || strlen($lname) < 3) {
        $error = true;
        $fnameError = "Name and surname must have at least 3 characters.";
    } else if (!preg_match("/^[a-zA-Z]+$/", $fname) || !preg_match("/^[a-zA-Z]+$/", $lname)) {
        $error = true;
        $fnameError = "Name and surname must contain only letters and no spaces.";
    }

    // basic email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $emailError = "Please enter valid email address.";
    } else {
        // checks whether the email exists or not
        $query = "SELECT email FROM users WHERE email='$email'";
        $result = mysqli_query($connect, $query);
        $count = mysqli_num_rows($result);
        if ($count != 0) {
            $error = true;
            $emailError = "Provided Email is already in use.";
        }
    }

    if (empty($phone_number)) {
        $error = true;
        $phoneError = "Please enter your phone number.";
    }

    if (empty($address)) {
        $error = true;
        $phoneError = "Please enter your address.";
    }
    // password validation
    if (empty($pass)) {
        $error = true;
        $passError = "Please enter password.";
    } else if (strlen($pass) < 6) {
        $error = true;
        $passError = "Password must have at least 6 characters.";
    }

    // password hashing for security
    $password = hash('sha256', $pass);
    // if there's no error, continue to signup
    if (!$error) {

        $query = "INSERT INTO `users`(`first_name`, `last_name`, `phone_number`, `password`, `email`, `picture`, `address`) VALUES ('$fname','$lname','$phone_number','$password','$email','$picture->fileName','$address')";
        $res = mysqli_query($connect, $query);

        if ($res) {
            $errTyp = "success";
            $errMSG = "Successfully registered, you may login now";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again later...";
            $uploadError = ($picture->error != 0) ? $picture->ErrorMessage : '';
        }
    }
}

mysqli_close($connect);
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



    <header>
        <div class="px-3 py-2 bg-warning bg-gradient">

            <div class="container">


                <div class="d-flex flex-wrap align-items-center  justify-content-lg-center ">



                    <h1>Animal Paradise</h1>



                </div>
            </div>
        </div>
        </div>


    </header>
    <div class="container">
        <form class="w-75 m-3" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off" enctype="multipart/form-data">
            <h2>Sign Up.</h2>
            <hr />
            <?php
            if (isset($errMSG)) {
            ?>
                <div class="alert alert-<?php echo $errTyp ?>">
                    <p><?php echo $errMSG; ?></p>
                    <p><?php echo $uploadError; ?></p>
                </div>

            <?php
            }
            ?>

            <input type="text" name="fname" class="form-control mb-3" placeholder="First name" maxlength="50" />
            <span class="text-danger"> <?php echo $fnameError; ?> </span>

            <input type="text" name="lname" class="form-control mb-3" placeholder="Last Name" maxlength="50" />
            <span class="text-danger"> <?php echo $fnameError; ?> </span>

            <input type="email" name="email" class="form-control mb-3" placeholder="Enter Your Email" maxlength="40" />
            <span class="text-danger"> <?php echo $emailError; ?> </span>

            <input class='form-control w-45 mb-3' type="text" name="phone_number" placeholder="Phone number (ie: 0660887559)" />
            <span class="text-danger"> <?php echo $phoneError; ?> </span>

            <input class='form-control w-45 mb-3' type="text" name="address" placeholder="Enter your address" />
            <span class="text-danger"> <?php echo $addressError; ?> </span>


            <input class='form-control w-45 mb-3' type="file" name="picture">
            <span class="text-danger"> <?php echo $picError; ?> </span>

            <input type="password" name="pass" class="form-control mb-3" placeholder="Enter Password" maxlength="15" />
            <span class="text-danger"> <?php echo $passError; ?> </span>
            <hr />

            <button type="submit" class="btn btn-block btn-success" name="btn-signup">Sign Up</button>
            <hr />

            <a href="login.php" class="btn btn-block btn-primary">Sign in</a>
        </form>
    </div>
</body>

</html>
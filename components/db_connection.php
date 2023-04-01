<?php

$hostname = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "be18_cr5_animal_adoption_jaimecoca";


$connect = new mysqli($hostname, $username, $password, $dbname);


if ($connect->connect_error) {
   die("Connection failed: " . $connect->connect_error);
};

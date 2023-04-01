<?php
function file_upload($picture, $src = "user")
{
    $result = new stdClass(); //this object will carry status from file upload
    $result->fileName = 'avatar.png';

    if ($src == "animal") {
        $result->fileName = "animal.png";
    }

    $result->error = 1; //it could also be a boolean true/false
    //collect data from object $picture
    $fileName = $picture["name"];
    $fileType = $picture["type"];
    $fileTmpName = $picture["tmp_name"];
    $fileError = $picture["error"];
    $fileSize = $picture["size"];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $filesAllowed = ["png", "jpg", "jpeg"];

    if ($fileError == 4) {
        $result->ErrorMessage = "No image was chosen. It can always be updated later.";
        return $result;
    } else {
        if (in_array($fileExtension, $filesAllowed)) {
            if ($fileError === 0) {

                if ($fileSize < 500000) {

                    $fileNewName = uniqid('') . "." . $fileExtension;
                    $destination = "../users/pictures/$fileNewName";

                    if ($src == "animal") {
                        $destination = "../animals/pictures/$fileNewName";
                    }

                    if (move_uploaded_file($fileTmpName, $destination)) {
                        $result->error = 0;
                        $result->fileName = $fileNewName;
                        return $result;
                    } else {
                        $result->ErrorMessage = "There was an error uploading this image.";
                        return $result;
                    }
                } else {
                    $result->ErrorMessage = "This image is bigger than the allowed 500Kb. <br> Please choose a smaller one and update the product.";
                    return $result;
                }
            } else {
                $result->ErrorMessage = "There was an error uploading - $fileError code. Check the PHP documentation.";
                return $result;
            }
        } else {
            $result->ErrorMessage = "This file type can't be uploaded.";
            return $result;
        }
    }
}

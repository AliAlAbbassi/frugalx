<?php
        header('Access-Control-Allow-Origin: *');
    // File name
    $filename = $_FILES['file']['name'];

    // Valid file extensions
    $valid_extensions = array("jpg", "jpeg", "png", "pdf");

    // File extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);

    // Check extension
    if(in_array(strtolower($extension), $valid_extensions) ) {

        // Upload file
        if(move_uploaded_file($_FILES['file']['tmp_name'], "../../../static/".$filename)){
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    }
    exit;
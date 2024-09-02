<?php

function resizeImages($image_location) {
    // File and new size
    $filename = $image_location; //'./temp_images/temp.jpg';
    // $percent = 0.5;

    // Content type


    // Get new sizes
    // var_dump(getimagesize($filename));
    // exit();
     
    $image_details = getimagesize($filename);
    list($width, $height) = $image_details;
    $newwidth = 48;
    $newheight = 48;

    // $image_details = getimagesize($filename);
    $mime_type = $image_details['mime'];

    // Load
    $thumb = imagecreatetruecolor($newwidth, $newheight);
    set_error_handler(function($errno, $errstr, $errfile, $errline) {
        // error was suppressed with the @-operator
        if (0 === error_reporting()) {
            return false;
        }
        
        throw new Error($errstr, 0, $errno, $errfile, $errline);
    });
    if($mime_type =='image/jpeg' || $mime_type == 'image/jpg') {
        try {
            $source = imagecreatefromjpeg($filename);
        } catch (\Error $e) {
            try {
                $source = imagecreatefromjpeg($filename);
            } catch (\Error $e) {
                return "./images/temp2.jpg";
            }
        }
    } else if($mime_type == 'image/png') {
        try { echo "mime type: $mime_type<br>";
            $source = imagecreatefrompng($filename);
        } catch (\Error $e) {
            try {
                $source = imagecreatefrompng($filename);
            } catch (\Error $e) {
                var_dump($e);
                return;
                // return "./images/temp2.jpg";
            }
        }
    } else if($mime_type == 'image/gif') {
        try {
            $source = imagecreatefromgif($filename);
        } catch (\Error $e) {
            try {
                $source = imagecreatefromgif($filename);
            } catch (\Error $e) {
                return "./images/temp2.jpg";
            }
        }
    } else {
        try {
            $source = imagecreatefrombmp($filename);
        } catch (\Error $e) {
            try {
                $source = imagecreatefrombmp($filename);
            } catch (\Error $e) {
                return "./images/temp2.jpg";
            }
        }
    }
    restore_error_handler();

    // Resize
    imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

    // Output
    $result = imagepng($thumb, "./icons/icon48.png", 9);

    //destroys the image in memory
    // imagedestroy($thumb);
    if($result) {
        // return "./images/temp2.jpg";
        // echo "done";
    } else {
        return null;
        // echo "Failed";
    }
}

resizeImages("./icons/Screenshot 2024-08-09 at 11-46-42 Colors.png");
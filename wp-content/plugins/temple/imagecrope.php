<?php

 @ob_start();

// Get the File path for the image

 

$sImagePath = $_GET["file"];

 

// If you want exact dimensions, you

// will pass 'width' and 'height'

 

$iThumbnailWidth = (int)$_GET['width'];

$iThumbnailHeight = (int)$_GET['height'];

 

// If you want proportional thumbnails,

// you will pass 'maxw' and 'maxh'

 

$iMaxWidth = (int)$_GET["maxw"];

$iMaxHeight = (int)$_GET["maxh"];

 

// Based on the above we can tell which

// type of resizing our script must do

 

$sType = 'exact';

 

// The 'scale' type will make the image

// smaller but keep the same dimensions

 

// The 'exact' type will make the thumbnail

// exactly the width and height you choose

 

// To start off, we will create a copy

// of our original image in $img

 

$img = NULL;

 

// At this point, we need to know the

// format of the image

 

// Based on that, we can create a new

// image using these functions:

// - imagecreatefromjpeg

// - imagecreatefrompng

// - imagecreatefromgif

 

$sExtension = @strtolower(@end(@explode('.', $sImagePath)));

if ($sExtension == 'jpg' || $sExtension == 'jpeg') {

 

    $img = @imagecreatefromjpeg($sImagePath)

        or die("Cannot create new JPEG image");

 

} else if ($sExtension == 'png') {

 

    $img = @imagecreatefrompng($sImagePath)

        or die("Cannot create new PNG image");

 

} else if ($sExtension == 'gif') {

 

    $img = @imagecreatefromgif($sImagePath)

        or die("Cannot create new GIF image");

 

}

 

// If the image has been created, we may proceed

// to the next step

 

if ($img) {

 

    // We now need to decide how to resize the image

 

    // If we chose to scale down the image, we will

    // need to get the original image propertions

 

    $iOrigWidth = @imagesx($img);

    $iOrigHeight = @imagesy($img);

 

    if ($sType == "exact") {

 

        // Get scale ratio

 

        $fScale = @max($iThumbnailWidth/$iOrigWidth,

              $iThumbnailHeight/$iOrigHeight);

 

        

 

            $iNewWidth = $iMaxWidth;

            $iNewHeight =$iMaxHeight;

            // Create a new temporary image using the

            // imagecreatetruecolor function

 

            $tmpimg = @imagecreatetruecolor($iNewWidth,

                            $iNewHeight);

            $tmp2img = @imagecreatetruecolor($iThumbnailWidth,

                            $iThumbnailHeight);

 

            // The function below copies the original

            // image and re-samples it into the new one

            // using the new width and height

 

            @imagecopyresampled($tmpimg, $img, 0, 0, 0, 0,

            $iNewWidth, $iNewHeight, $iOrigWidth, $iOrigHeight);

 

            

            if ($iNewWidth == $iThumbnailWidth) {

 

                $yAxis = ($iNewHeight/2)-

                    ($iThumbnailHeight/2);

                $xAxis = 0;

 

            } else if ($iNewHeight == $iThumbnailHeight)  {

 

                $yAxis = 0;

                $xAxis = ($iNewWidth/2)-

                    ($iThumbnailWidth/2);

 

            }

 

            // We now have to resample the new image using the

            // new dimensions are axis values.

 

            @imagecopyresampled($tmp2img, $tmpimg, 0, 0,

                       $xAxis, $yAxis,

                       $iThumbnailWidth,

                       $iThumbnailHeight,

                       $iThumbnailWidth,

                       $iThumbnailHeight);

 

            @imagedestroy($img);

            @imagedestroy($tmpimg);

            $img = $tmp2img;

        //}   

 

    }

 

    // Display the image using the header function to specify

    // the type of output our page is giving

 

    @header("Content-type: image/jpeg");

    @imagejpeg($img);

 

}
<?php
	/*
	 * Fix Transparency
	 * 
	 * ex. (way to do this)
	 * $newImg = imagecreatetruecolor($nWidth, $nHeight);
	 * imagealphablending($newImg, false);
	 * imagesavealpha($newImg,true);
	 * $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
	 * imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
	 * imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
 	 *
 	 *	fix this repeating shit. performance is low, dunno why. investigate
	 */

	require_once "../includes/database.php";
	$link = db_connect_link();
	
    // just so we know it is broken
    error_reporting(E_ALL);
    // some basic sanity checks
    if(isset($_GET['id']) && is_numeric($_GET['id'])) {
        // get the image from the db
        $sql = "SELECT data, type FROM `user_images` WHERE `id` = '{$_GET['id']}'";
 
        // the result of the query
        $result = mysql_query("$sql") or die("Invalid query: " . mysql_error());
 
        // set the header for the image
       	$fileType = mysql_result($result, 0, "type");
       	header("Content-type: $fileType");
        
        if(isset($_GET['s']) && is_numeric($_GET['s'])){
        	$img = mysql_result($result, 0, "data");
        	$file = imagecreatefromstring($img);
        	
        	$size = $_GET['s']/100;
        	
        	$width = imagesx($file);
        	$height = imagesy($file);
        	
        	$modwidth = $width * $size;
        	$modheight = $height * $size;
        	
        	$source = imagecreatetruecolor($modwidth, $modheight);
        	
        	// Resizing our image to fit the canvas
        	imagecopyresampled($source, $file, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
        	
        	// Outputs a jpg image, you could change this to gif or png if needed
        	output($source, $fileType);
        	
        	// clean memory
        	imagedestroy ($source);
        	imagedestroy ($file);
        	
        }elseif(isset($_GET['w']) && is_numeric($_GET['w'])){	
        	
        	$img = mysql_result($result, 0, "data");
        	$file = imagecreatefromstring($img);
        	
        	$size = $_GET['w'];
        	
        	$width = imagesx($file);
        	$height = imagesy($file);
        	
        	$modwidth = $size;
        	$modheight = $height * ($modwidth / $width);
        	
        	$source = imagecreatetruecolor($modwidth, $modheight);
        	
        	// Resizing our image to fit the canvas
        	imagecopyresampled($source, $file, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
        	
        	// Outputs a jpg image, you could change this to gif or png if needed
        	output($source, $fileType);
        	
        	// clean memory
        	imagedestroy ($source);
        	imagedestroy ($file);
        	
        }elseif(isset($_GET['h']) && is_numeric($_GET['h'])){
        	
        	$img = mysql_result($result, 0, "data");
        	$file = imagecreatefromstring($img);
        	
        	$size = $_GET['h'];
        	
        	$width = imagesx($file);
        	$height = imagesy($file);
        	
        	$modheight = $size;
       		$modwidth = $width * ($modheight / $height);
        	
        	$source = imagecreatetruecolor($modwidth, $modheight);
        	
        	// Resizing our image to fit the canvas
        	imagecopyresampled($source, $file, 0, 0, 0, 0, $modwidth, $modheight, $width, $height);
        	
        	// Outputs a jpg image, you could change this to gif or png if needed
        	output($source, $fileType);
        	
        	// clean memory
       		imagedestroy ($source);
        	imagedestroy ($file);	
        }else{
        	echo mysql_result($result, 0);
        }
 
        // close the db link
        mysql_close($link);
    }
    else {
        echo 'Please use a real id number';
    }
    
    function output($file, $fileType){
    	
    	if($fileType == "image/jpeg"){
    		return imagejpeg($file);
    	}elseif($fileType == "image/png"){
    		return imagepng($file);
    	}elseif($fileType == "image/gif"){
    		return imagegif($file);
    	}elseif($fileType == "image/vnd.wap.wbmp"){
    		return imagewbmp($file);
    	}
    }
?>
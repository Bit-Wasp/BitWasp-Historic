<?php


class My_image {

	// function to strip EXIF data from images.
	public function resizeImage($array,$destPath){
		$results = array('old_path' => '',
				 'destination' => '',
				 'thumb_destination' => '',
				 'file_name' => '',
				 'format' => '' );
		$destination = $destPath.'small.png';
		$thumb_destination = $destPath.'thumb.png';

		$dim['full']['h']='202.5';
		$dim['full']['w']='270';
		$dim['thumb']['h']='112.5';
		$dim['thumb']['w']='150';

		// If magickwand extension is present
		if(extension_loaded('magickwand') && function_exists("NewMagickWand")) {
			/* ImageMagick is installed and working */

			// Create a new image from the supplied path.
			$imgFull = new Imagick($array['full_path']);
			// Strip EXIF data.
			$imgFull->stripImage();
			// Create a new PNG image, which won't hold EXIF data.
			$imgFull->setImageFormat('png');
			// Resize the image to something smaller
			$imgFull->setImageOpacity(1.0);
		     	$imgFull->resizeImage($dim['full']['w'],$dim['full']['h'], imagick::FILTER_CATROM, 0.9, true);
			// Create the image.
			$imgFull->writeImage($destination);
			// Clear buffer. 
			$imgFull->clear();

			// Create a new image from the supplied path.
			$imgThumb = new Imagick($array['full_path']);
			// Strip EXIF data.
			$imgThumb->stripImage();
			// Create a new PNG image, which won't hold EXIF data.
			$imgThumb->setImageFormat('png');
			// Resize the image to something smaller
			$imgThumb->setImageOpacity(1.0);
		     	$imgThumb->resizeImage($dim['thumb']['w'],$dim['thumb']['h'], imagick::FILTER_CATROM, 0.9, true);
			// Create the image.
			$imgThumb->writeImage($thumb_destination.'thumb.png');
			// Clear buffer. 
			$imgThumb->clear();

			// Build $results array for oldpath, and the new image location.
			$results['old_path'] = $array['full_path'];
			$results['full_name'] = $array['raw_name'].'small.png';
			$results['thumb_name'] = $array['raw_name'].'thumb.png';
			$results['destination'] = $destination;
			$results['thumb_destination'] = $thumb_destination;
			$results['format'] = '.png';
		} elseif (extension_loaded('gd') && function_exists('gd_info')) {
			/* GD is installed and working */

			if($array['file_ext'] == '.png'){			
				// Load PNG image.
				$img = imagecreatefrompng($array['full_path']);
			} elseif($array['file_ext'] == '.jpeg' || $array['file_ext'] == '.jpg'){
				// Load JPEG image.
				$img = imagecreatefromjpeg($array['full_path']);
			} elseif($array['file_ext'] == '.gif' ){
				// Load GIF image
				$img = imagecreatefromgif($array['full_path']);
			}			

			// Define the ratio to scale newimages to.
			$ourratio = $dim['full']['w']/$dim['full']['h'];

			// Extract the width and heightfrom the new image.
			list($width, $height) = getimagesize($array['full_path']);

			// Calculate the ratio of the new image.
    			$newratio = $width / $height;

			// If the new ratio < site defined ratio (is in favour of height)
        		if ($newratio < $ourratio) {
				// Dimensions for the thumbnail. Height is max, and relative width calculated.
				$newdim['thumb']['h'] = $dim['thumb']['h'];
				$newdim['thumb']['w'] = $dim['thumb']['h']*$ourratio;

				// Repeat for the 'larger image'
				$newdim['full']['h'] = $dim['full']['h'];
				$newdim['full']['w'] = $dim['full']['h']*$ourratio;
        		} else {
				// In this case the ratio is greater (in favour of the width) 
				$newdim['thumb']['w'] = $dim['thumb']['w'];
				$newdim['thumb']['h'] = $dim['thumb']['w']/$ourratio;

				$newdim['full']['w'] = $dim['full']['w'];
				$newdim['full']['h'] = $dim['full']['w']/$ourratio;
      	 		}	

			// Create the new image with the correct dimensions. 
    			$imgFull = imagecreatetruecolor($newdim['full']['w'], $newdim['full']['h']);
    			imagecopyresampled($imgFull, $img, 0, 0, 0, 0, $newdim['full']['w'], $newdim['full']['h'], $width, $height);
			// Create a PNG image and write it to the destination.
			imagepng($imgFull, $destination);

    			$imgThumb = imagecreatetruecolor($newdim['thumb']['w'], $newdim['thumb']['h']);
    			imagecopyresampled($imgThumb, $img, 0, 0, 0, 0, $newdim['thumb']['w'], $newdim['thumb']['h'], $width, $height);
			// Create a PNG image and write it to the destination.
			imagepng($imgThumb, $thumb_destination);

			// Return array of old & new image path info.
			$results['old_path'] = $array['full_path'];
			$results['full_name'] = $array['raw_name'].'small.png';
			$results['thumb_name'] = $array['raw_name'].'thumb.png';
			$results['destination'] = $destination;
			$results['thumb_destination'] = $thumb_destination;
			$results['format'] = '.png';
		} else {
			// Neither PHP-GD or ImageMagick is installed, no EXIF filtering.
			$results['old_path'] = $array['full_path'];
			$results['full_name'] = $array['file_name'];
			$results['thumb_name'] = $array['file_name'];
			$results['destination'] = $array['full_path'];
			$results['thumb_destination'] = $array['full_path'];
			$results['format'] = $array['file_ext'];
		}
		// Return array of path information for old and new image.
		return $results;
	}

	// Return the image contant.
	public function displayImage($imageHash,$height = NULL, $width = NULL){	
		// To get an image, call this function.
		$CI = &get_instance();
		$CI->load->model('images_model');
		
		// Check if the image is already held in the database
		// If the DB is missing the entry, BitWasp will try to find the file, and then encode it and add to the DB.
		$image = $CI->images_model->imageFromDB($imageHash);

        	if($image === FALSE) {
			// Failure; Image identifier is invalid.
			return FALSE;
		} else {
			// Return the values for the <img> tag with base64 encoded image, height/width
			if($height !== NULL){ $displayHeight = $height; } else { $displayHeight = $image['height']; }
			if($width !== NULL){ $displayWidth = $width; } else { $displayWidth = $image['width']; }

			$result = array('imageHash' => $imageHash,
					'encoded' => $image['encoded'],
					'height'  => $displayHeight,
					'width'   => $displayWidth );
			return $result;
			// Success; return Image information.
		}
	}

	// This function is displays an image without adding to the DB. Useful for catpchas.
	public function displayTempImage($identifier){
		$CI = &get_instance();
	
		$image = $this->simpleImageEncode($identifier);
		$validHTML = "<img src=\"data:image/gif;base64,{$image}\" />";
		// Return the <img> tag.
		return $validHTML;
	}


	// This function returns the base64 string from an image.
	public function simpleImageEncode($identifier){
		$imageFile = file_get_contents('./assets/images/'.$identifier);
		// Encode to base64/
		$validImage = base64_encode($imageFile);
	//	$validImage = chunk_split($validImage, 64, "\n");			// Uncomment this for issues with new lines

		return $validImage;
	}



};


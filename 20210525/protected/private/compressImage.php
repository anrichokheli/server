<?php
$image1 = imagecreatefromstring(file_get_contents($imageFile));
if(isset($compressedImageWidth) && isset($compressedImageHeight))	{
	$r = $width / $height;
	if($r > 1)	{
		$width2 = $compressedImageWidth;
		$height2 = $width2 / $r;
	}
	else	{
		$height2 = $compressedImageHeight;
		$width2 = $height2 * $r;
	}
	$image2 = imagescale($image1, $width2, $height2);
}
else	{
	$image2 = $image1;
}
@$exif = exif_read_data($imageFile);
if($exif && isset($exif['Orientation']))	{
	$orientation = exif_read_data($imageFile)['Orientation'];
	if($orientation != 1)	{
		$deg = 0;
		switch ($orientation) {
			case 3:
				$deg = 180;
				break;
			case 6:
				$deg = 270;
				break;
			case 8:
				$deg = 90;
				break;
		}
		if($deg)	{
			$image2 = imagerotate($image2, $deg, 0);
		}
	}
}
if(defined("maxImageSize") && ($fileSize > maxImageSize))	{
	$image_quality = 100;
	do {
		$temp_stream = fopen('php://temp', 'w+');
		$saved = imagejpeg($image2, $temp_stream, $image_quality--);
		rewind($temp_stream);
		$fstat = fstat($temp_stream);
		fclose($temp_stream);
		$file_size = $fstat['size'];
	}
	while (($file_size > maxImageSize) && ($image_quality >= 0));
	if(-1 == $image_quality)	{
		define("canNotCompress", "");
	}
	else	{
		imagejpeg($image2, $compressedImagePath, $image_quality + 1);
	}
}
else	{
	imagejpeg($image2, $compressedImagePath, compressedImageQualityValue);
}
?>
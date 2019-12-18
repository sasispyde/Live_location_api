<?php 

if (! defined('BASEPATH')) exit('No direct script access allowed');

if (! function_exists('generateNumericOTP')) {

	function generateNumericOTP($n=4) { 

		$ci = get_instance();
	     
	    $generator = "1357902468"; 

	    $otp = ""; 
	  
	    for ($i = 1; $i <= $n; $i++) { 

	        $otp .= substr($generator, (rand()%(strlen($generator))), 1); 
	    } 

	    return $otp; 
	} 
}
	/** function encoder - to encode json response */

	if (!function_exists('encoder')) {
		function encoder($result)
		{
		$json = json_encode($result);
		return base64_encode($json);
		}
	}

	/** function decoder - to decode json request */
	if (!function_exists('decoder')) {
	function decoder($result)
	{
		$decode = base64_decode($result);
		$decoded_object = json_decode($decode);
		return $decoded_object;
	}
	}

	if (!function_exists('image_url')) {
	function image_url($result)
	{
		if(empty($result[0]->image_path)){
			return $result;
		}
		else{
		$url = (string)$result[0]->image_path;
		$url="http://192.168.1.88:3001/uploads/images/".$url;
		if(!empty($url)){
		$result[0]->image_path=$url;
		}
		return $result;
		}
	}
	} 


	if (!function_exists('isValidLongitude')) {
	function isValidLongitude($longitude)
	{
	    if(preg_match("/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}$/",
	      $longitude)) 
	    {
	       return true;
	    } 
	    else 
	    {
	       return false;
	    }
  	}
  	}

	if (!function_exists('isValidLatitude')) {
	  	function isValidLatitude($latitude){
	    if (preg_match("/^-?([1-8]?[1-9]|[1-9]0)\.{1}\d{1,6}$/", $latitude)) {
	        return true;
	    } else {
	        return false;
	    }
	  }
	}
?> 
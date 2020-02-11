<?php

// function grabs the get user ip
function getUserIpAddr(){
    if(!empty($_SERVER['HTTP_CLIENT_IP'])){
        //ip from share internet
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        //ip pass from proxy
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    }else{
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

// Location grabbed from geolocation plugin to display on add post

$geopluginURL='http://www.geoplugin.net/php.gp?ip='. getUserIpAddr();
$addrDetailsArr = unserialize(file_get_contents($geopluginURL));
/*Get City name by returning array*/
$city = $addrDetailsArr['geoplugin_city'];
/*Get Country name by returning array*/
$country = $addrDetailsArr['geoplugin_countryName'];

if(!$city){
   $city='Not Defined';
}if(!$country){
   $country='Not Defined';
}


	require_once('request.php');
	
	session_start();
	
	if(isset($_POST['btn_addpost']))
	{
		$upload_address = "https://blogupsite.000webhostapp.com/";
		// include files
	$comlete_images_address = "";
		require_once('DatabaseConfiguration.php');
		
		$txt_title = $_POST['txt_title'];
		$txt_category = $_POST['txt_category'];
		$txt_description = $_POST['txt_description'];
		$location = $city;
		
			$f_name = $_FILES['img_post']['name'];
			$f_currentAddress = $_FILES['img_post']['tmp_name'];

// explode(this parameter is for where to separte string like . , this is for a complete string name)
			// end(this parameter to pass an array, which selects or return last index of array)
			// strtolower(this parameter accepts string to convert all letters into lower)
		
			$f_type = strtolower(end(explode('.',$f_name)));  // explode function is used here to separate string into two parts first file name and other its extension name after . symbol, the end function use to select last index of the array for its extension, strtolower function convert all letters into lower its. For ex: JPG to jpg
			$f_Newname = uniqid() . '.' . $f_type; // unique key mean to generate unique number for a file, this is used for not overwritting images which have same names
			$storeAddress = "uploads/" . $f_Newname;
			
			$comlete_images_address = $f_Newname;
			
			move_uploaded_file($f_currentAddress,$storeAddress);
			
			
		$image = $comlete_images_address;
		$UserID = $_SESSION['UserLoginID'];
		
		$connect = new DatabaseConfiguration();
		
		$get_user_auth = $connect->query(" SELECT * FROM users WHERE UID  = '$UserID '");
	
		$txt_name = $get_user_auth[0]['name'];
		$txt_email = $get_user_auth[0]['email'];
		
		$new_post = new DatabaseConfiguration();
		
		// send mail to the users //
			$to = $txt_email;
			$subject = "New Post Added.";
			$message = "Dear " .$txt_name . ", New Post Added - Confirmation. Thank you";
			$header = "From: Blog Up Site <zeerak.ali96@gmail.com>";
		
	    if(mail($to,$subject,$message,$header))
		{
			$query = "INSERT INTO posts(title, category, description, image, UID, location) VALUES('$txt_title', '$txt_category', '$txt_description', '$image', '$UserID', '$city')";
		
			$new_post->insert($query);
		
			error("Post Added");
	    }
		
	}
	else
	{
		
		error("Unauthorized Access, Not Clicked");
	}



?>	
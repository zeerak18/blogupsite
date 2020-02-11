<?php

	require_once('request.php');
	

	if(isset($_POST['btn_signup']))
	{
		
		// include files
	
		require_once('DatabaseConfiguration.php');

		$txt_name = $_POST['txt_name'];
		$txt_email = $_POST['txt_email'];
		$txt_password = $_POST['txt_password'];
		$status = "ALLOW";

		$new_account = new DatabaseConfiguration();
		
		$query_check = "SELECT * FROM users WHERE email = '$txt_email'";
		
		$result = $new_account->query_result($query_check);
		
		if(mysqli_num_rows($result) > 0)
		{
				error("Email Already Registered");
		}
		else
		{
				// send mail to the users //
			$to = $txt_email;
			$subject = "Account Registration Successful";
			$message = "Dear " .$txt_name . ", You're registerd with us. Thank you";
			$header = "From: Blog Up Site <zeerak.ali96@gmail.com>";
		
	    if(mail($to,$subject,$message,$header))
		{
			$query = "INSERT INTO users(name, email, password, status) VALUES('$txt_name', '$txt_email', '$txt_password', '$status')";
		
			$new_account->insert($query);
		
			error("Account Created");
	    }
		else
		{
			error("Account Not Created");

		}
	
			
		}
	}
	else
	{
		
		error("Unauthorized Access, Not Clicked");
	}



?>	
<?php
	
	
	require_once('request.php');
		
	session_start();
	
	if (isset($_POST['btn_login']))
	{
		// include files
	
		require_once('DatabaseConfiguration.php');
	
		if(!isset($_SESSION['UserLoginID']))
		{
		// getting data from user side and encrypt that information
	
		$txt_email = $_POST['txt_email'];
		$txt_password = $_POST['txt_password'];
	
		$query = "SELECT * FROM users WHERE email = '$txt_email' AND password = '$txt_password' AND status = 'ALLOW'";
	
		$user_account = new DatabaseConfiguration();

		$result = $user_account->query_result($query);
	

			if(mysqli_num_rows($result) > 0)
			{
				
				$result = $user_account->query_result_fetch($result);
				
				$UserID = $result[0]['UID'];
			
				$_SESSION['UserLoginID'] = $UserID;
			
				error("Login Successful");
			
			}
			else
			{
				error("Login Failed");
			
				session_destroy();
			}
		}
		else
		{
			error("Login Successful");
		}
		
	}
	else 
	{
		
		error("Unauthorized Access");
		
		session_destroy();
	}

	
?>
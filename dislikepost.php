<?php

	
	
	session_start();
	
	if(isset($_SESSION['UserLoginID']))
	{
		
		// include files
	
		require_once('DatabaseConfiguration.php');

		
		$PID = $_POST['PID'];
		$UserID = $_SESSION['UserLoginID'];
		
		$connect = new DatabaseConfiguration();
		
		$get_user_auth = $connect->query(" SELECT * FROM posts p , users u WHERE u.UID = p.UID AND p.PID  = '$PID'");
	
		$txt_name = $get_user_auth[0]['name'];
		$txt_email = $get_user_auth[0]['email'];
		
		$new_like = new DatabaseConfiguration();

		$query_check = "SELECT * FROM likes WHERE UID = '$UserID' AND PID = '$PID'";
		
		$result = $new_like->query_result($query_check);
		
		if(mysqli_num_rows($result) > 0)
		{
			// send mail to the users //
			$to = $txt_email;
			$subject = "Post Dislike.";
			$message = "Dear " .$txt_name . ", Someone disliked your post. Thank you";
			$header = "From: Software Engineer <zeerak.ali96@gmail.com>";
		
			if(mail($to,$subject,$message,$header))
			{
				$query = "UPDATE likes SET like_dislike = 0 WHERE UID = '$UserID' AND PID = '$PID'";
		
			    $new_like->insert($query);
				
				$totalLikes = $connect->query("SELECT count(like_dislike) as postlike FROM likes WHERE PID = '$PID' AND like_dislike = 1");
				$totaldisLikes = $connect->query("SELECT count(like_dislike) as postdislike FROM likes WHERE PID = '$PID' AND like_dislike = 0");
		
				$listPost = array("userlikes" => $totalLikes[0]['postlike'], "userdislikes" => $totaldisLikes[0]['postdislike']);
				echo json_encode($listPost);
			}

		}
		else
		{
			// send mail to the users //
			$to = $txt_email;
			$subject = "Post Dislike.";
			$message = "Dear " .$txt_name . ", User disliked your the post. Thank you";
			$header = "From: Blog Up Site <zeerak.ali96@gmail.com>";
		
			if(mail($to,$subject,$message,$header))
			{
				
				$query = "INSERT INTO likes(PID, UID, like_dislike) VALUES('$PID', '$UserID', 0)";
			
				$new_like->insert($query);
				
				$totalLikes = $connect->query("SELECT count(like_dislike) as postlike FROM likes WHERE PID = '$PID' AND like_dislike = 1");
				$totaldisLikes = $connect->query("SELECT count(like_dislike) as postdislike FROM likes WHERE PID = '$PID' AND like_dislike = 0");
		
				$listPost = array("userlikes" => $totalLikes[0]['postlike'], "userdislikes" => $totaldisLikes[0]['postdislike']);
				echo json_encode($listPost);
				
			}
			
		}
			
	}
	
?>	
<?php

	require_once('request.php');
	
	session_start();
	
	if(isset($_SESSION['UserLoginID']))
	{
		
		// include files
	
		require_once('DatabaseConfiguration.php');

		
		$PID = $_POST['PID'];
		$UserID = $_SESSION['UserLoginID'];
		$text = $_POST['textComment'];
		
		
		$new_comment = new DatabaseConfiguration();
		$view_comment = new DatabaseConfiguration();
		
		
			$query = "INSERT INTO comment(PID, UID, text) VALUES('$PID', '$UserID', '$text')";
		
			$id = $new_comment->getLastRecord($query);
		
			$result = $view_comment->query("SELECT * FROM comment WHERE CID = '$id'");
		  
			foreach($result as $display2)
			{
				
				?>
				
				<div id="all_comments">
				  <div class="comment_div"> 
				  	
					<p class="comments"><?php echo $display2['text']?></p>	
					
				  </div>
				  </div>
				  
				   <?php 
		  
			}
			
			exit;

		  ?>
<?php 
	}
	
?>	
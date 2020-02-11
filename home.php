<?php

	require_once('adminheader.php');

	require_once('request.php');

	session_start();

	if(isset($_SESSION['UserLoginID']))
	{
		
		$UserID = $_SESSION['UserLoginID'];
	
		require_once('DatabaseConfiguration.php');
		
		$connect = new DatabaseConfiguration();
	
		$get_user_auth = $connect->query(" SELECT * FROM users WHERE UID  = '$UserID '");
	
		$name = $get_user_auth[0]['name'];
		$email = $get_user_auth[0]['email'];
	
?>

<html>
	
	<head>
		
		
		
	</head>
	
	<body>
		
		
		<div class="header">
	  <h2>Add Post</h2>
	</div>
	
	<div class="d-flex justify-content-center align-items-center"  style="max-width: 100rem;"  >

					<div class="card" >

						<div class="card-body">
  
		<form action="addpost" method="POST" style="padding:10px;" enctype="multipart/form-data">
			
		<div class="custom-file">
		  <input type="file" class="custom-file-input" id="customFileLang" lang="en" name="img_post" required>
		  <label class="custom-file-label" for="customFileLang">Upload</label>
		</div>

			<!-- Material input -->
			<div class="md-form">
			  <i class="fas fa-pen prefix"></i>
			  <input type="text" id="inputIconEx2" class="form-control" name="txt_title" required  >
			  <label for="inputIconEx2">Title</label>
			</div>
			
			<!-- Material input -->
			<div class="md-form">
			  <i class="fas fa-user prefix"></i>
			  <input type="text" id="inputIconEx2" class="form-control" value="<?php echo $name;?>" name="txt_name" readonly>

			</div>
			
			<!-- Material input -->
			<div class="md-form">
			  <i class="fas fa-envelope prefix"></i>
			  <input type="text" id="inputIconEx1" class="form-control" value="<?php echo $email;?>" name="txt_email" readonly>
			  
			</div>

Select a Category:
			<select class="browser-default custom-select" name="txt_category" required>
					<option value="Blog">Blog</option>
					<option value="Template">Template</option>
			</select>		
			
			
			<!--Material textarea-->
			<div class="md-form md-outline">
			  <textarea id="form75" class="md-textarea form-control" rows="3" name="txt_description" required></textarea>
			  <label for="form75">Description</label>
			</div>


			
			<button type="submit" name="btn_addpost" class="btn btn-primary">Add Post</button>
			
		</form>
		
		
		
		
		</div>
		</div>
		</div>
	
	</body>

</html>	

<?php
			}
			else
			{
				session_destroy();

				error("Unauthorized Access");
			}
?>
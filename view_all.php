<?php

	require_once('header.php');
	
		
		require_once('DatabaseConfiguration.php');
		
		$connect = new DatabaseConfiguration();
	
		$list_category = $connect->query("SELECT * FROM posts GROUP BY category");
		
		if(isset($_POST['btn_search']))
		{
			$txt_category = $_POST['txt_category'];
			
			$result = $connect->query("SELECT * FROM posts WHERE category = '$txt_category'");
		}
		else
		{
			$result = $connect->query("SELECT * FROM posts order by PID desc");
		}
	
?>
<html>
	
	<head>
		
		
		
	</head>
		
	<body>
		
	<div class="header">
	  <h2>Blog Name</h2>
	</div>


		<form action="view_all" method="POST">
			
			<h1>Search by Category</h1>

			
				<select name="txt_category" required>
				
				 <?php 
	  
					foreach($list_category as $display)
					{
	  
				?>
	  
					<option value="<?php echo $display['category']?>"><?php echo $display['category']?></option>
					
				<?php 
	  
					}
	
				?>
	  
			</select>	
			
			<input type="submit" value="Search" name="btn_search" />
			
			
		</form>
		
	<div class="row">
	  <div class="leftcolumn">
	  
	  <?php 
	  
		foreach($result as $display)
		{
			$PID = $display['PID'];
			
			$date = new DateTime($display['created_at']);
			
			$created_at = $date->format('M d, Y');
			
			$totalLikes = $connect->query("SELECT count(like_dislike) as postlike FROM likes WHERE PID = '$PID' AND like_dislike = 1");
			$totaldisLikes = $connect->query("SELECT count(like_dislike) as postdislike FROM likes WHERE PID = '$PID' AND like_dislike = 0");
			$totalcomments = $connect->query("SELECT count(text) as postcomments FROM comment WHERE PID = '$PID'");
			
	  
	  ?>
		<div class="card">
		   <h2 style="float:right"><?php echo $display['location']?></h2>
		  <h2>Title: <?php echo $display['title']?></h2>
		  <h4>Post ID: <?php echo $display['PID']?></h4>
		  <h5>Description, <?php echo $created_at;?></h5>
		  <h5>Category: <?php echo $display['category']?></h5>
		   <div class="fakeimg" style="height:400px;"><img src="uploads/<?php echo $display['image']; ?>" style="height:400px; width:100%;"> </img> </div>
		  <br/>
		  <p><?php echo $display['description']?></p>
		  <p><?php echo "Likes: " . $totalLikes[0]['postlike']?></p>
		  <p><?php echo "Dislike: " . $totaldisLikes[0]['postdislike']?></p>
		  <p><?php echo "Comments: " . $totalcomments[0]['postcomments']?></p>
		</div>
		
	  <?php 
	  
		}

	  ?>
	  
	  </div>
	  
	</div>

	
	</body>

</html>
		

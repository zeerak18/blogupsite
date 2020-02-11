
<?php

	require_once('adminheader.php');
	
	require_once('request.php');

	session_start();

	if(isset($_SESSION['UserLoginID']))
	{
		
		require_once('DatabaseConfiguration.php');
		
		$connect = new DatabaseConfiguration();
		
		$UserID = $_SESSION['UserLoginID'];
		
		$get_user_auth = $connect->query("SELECT * FROM users WHERE UID  = '$UserID'");
	
		$name = $get_user_auth[0]['name'];
		
		$list_category = $connect->query("SELECT * FROM posts GROUP BY category");
		
		if(isset($_POST['btn_search']))
		{
			$txt_category = $_POST['txt_category'];
			
			$result = $connect->query("SELECT * FROM posts WHERE category = '$txt_category' ORDER BY PID DESC");
		}
		else if(isset($_POST['btn_search_your_post']))
		{
			
			$result = $connect->query("SELECT * FROM posts WHERE UID = '$UserID' ORDER BY PID DESC");
		}
		else if(isset($_POST['btn_comment_post']))
		{
			
			
			
		$PID = $_POST['PID'];
		$text = $_POST['textComment'];
		
		$get_post_info = $connect->query(" SELECT * FROM posts p , users u WHERE u.UID = p.UID AND p.PID  = '$PID'");
	
		$txt_name = $get_post_info[0]['name'];
		$txt_email = $get_post_info[0]['email'];
		
		
		// send mail to the users //
			$to = $txt_email;
			$subject = "Post Comment.";
			$message = "Dear " .$txt_name . ", A user has commented on your post. Thank you";
			$header = "From: Software Engineer <zeerak.ali96@gmail.com>";
		
			if(mail($to,$subject,$message,$header))
			{
		
				$new_comment = new DatabaseConfiguration();
				$view_comment = new DatabaseConfiguration();
				
			
				$query = "INSERT INTO comment(PID, UID, text) VALUES('$PID', '$UserID', '$text')";
				
				$new_comment->insert($query);
				
				$result = $connect->query("SELECT * FROM posts ORDER BY PID DESC");
			}

		}
		else
		{
			$result = $connect->query("SELECT * FROM posts ORDER BY PID DESC");
		}
	
?>
<html>
	
	<head>
		
		<style>
body{
	font-family:helvetica;
	background:url(../background2.png);
}
h1{
	text-align:center;
	margin-top:20px;
	font-size:40px;
	color:#fff;
	text-shadow: 2px 2px 0px rgba(255,255,255,.7), 5px 7px 0px rgba(0, 0, 0, 0.1); 
}
#container{
	margin:auto;
	width:38%;
}
#username{
	width:100%;
	height:40px;
	border:1px solid silver;
	margin-top:40px;
	border-radius:5px;
	font-size:17px;
	padding:10px;
	font-family:helvetica;
	margin-bottom:10px;
}
#comment{
	width:100%;
	height:100px;
	border:1px solid silver;
	border-radius:5px;
	font-size:17px;
	padding:10px;
	font-family:helvetica;
}
#submit{
	width:200px;
	height:60px;
	border:none;
	background-color:tomato;
	color:#fff;
	margin-top:20px;
	border-radius:5px;
	font-size:20px;
	border-bottom:6px solid #E90003;
	margin-left:140px;
}
.comment_div
{
	width:500px;
	text-align:left;
	margin:20px auto;
	background:#F3F3F3;
	text-align:center;
}
.name{
	height:30px;
	line-height:30px;
	padding:8px;
	background:#fff;
	color:#777;
	text-align:left;
}
.comments{
	
	font-size:18px;	
}

.popup
{
    position: fixed;
    height:50px;
    width:260px;
    top: 0px;
    right: 0px;
    background: black;
    border-radius: 5px;
    display: flex;
    display: none;
    
}

.bar
{
    position: relative;
}

.msg
{
    position: relative;
    width: 60%;
    top: -50px;
    margin-left: 70px;
    font-weight: bold;
    font-size: 12px;
    padding-top: 2px;
	color:white;
} 
</style>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 
		
	</head>
		
	<body <?php if(isset($_POST['btn_comment_post'])) { ?> onload="popup('Comment on a Post.');"  <?php } ?>>


 
<div class="popup">
 <div class="bar" style="border=5px solid red"> <img  src="images/error.png" alt="bar" width="60px" height="50px"></div>
 <div class="msg"><span  id="msg"></span></div>
 </div><!--ending popup-->

		
	<div class="header">
	  <h2>View/Manage Post</h2>
	</div>


		<form action="manage_all" method="POST">
			
			<h3>Search by Category</h3>

			
				<select class="browser-default custom-select" name="txt_category" required>
				
				 <?php 
	  
					foreach($list_category as $display)
					{
	  
				?>
	  
					<option value="<?php echo $display['category']?>"><?php echo $display['category']?></option>
					
				<?php 
	  
					}
	
				?>
	  
			</select>	
			
			<button type="submit" name="btn_search" class="btn btn-primary">Search</button>
			<button type="submit" name="btn_search_your_post" class="btn btn-primary">Your Post</button>
			

		</form>
		
	<div class="row">
	  <div class="leftcolumn">
	  
	  <?php 
	  
	  $i = 1;
	  
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
		  <p id="<?php echo "txtLikes" . $i;?>"><?php echo "Likes: " . $totalLikes[0]['postlike']?></p>
		  <p id="<?php echo "txtDisLikes" . $i;?>"><?php echo "Dislikes: " . $totaldisLikes[0]['postdislike']?></p>
		  <p><?php echo "Comments: " . $totalcomments[0]['postcomments']?></p>
		 

		</div>
		<br/>
		
		
		
		  
		  
		
		
		
		
		<?php 
	  
			$view_comments = $connect->query("SELECT * FROM comment WHERE PID = '$PID' order by PID desc");
		  
			foreach($view_comments as $display2)
			{
			
	  
			?>
				  <div id="all_comments" style="background:white;">
				  <div class="comment_div"> 
				  	
					<p class="comments"><?php echo $display2['text']?></p>	
					
				  </div>
				  </div>

			

		
		   <?php 
		  
			}

		  ?>
		

		Comment by :  <?php echo $name;?>

		

	<form method="POST" action="manage_all">
		<input type="hidden" class="form-control" name="PID" value="<?php echo $PID;?>">
		<input type="text" class="form-control" id="commenttext"  name="textComment" required placeholder="Write a comment..."/>
		<button type="submit" name="btn_comment_post" name="" class="btn btn-primary">Comment</button>
	</form>	
	
		<button type="submit" name="btn_like_post" onclick="return like(<?php echo $PID;?>, <?php echo $i;?>);" class="btn btn-primary">Like</button>
		
		<button type="submit" name="btn_dislike_post" onclick="return dislike(<?php echo $PID;?>, <?php echo $i;?>);" class="btn btn-primary">Unlike</button>
		
	  <?php 
	  
	  $i++;
		}

	  ?>
	  
	  </div>
	  
	</div>

	<script type="text/javascript">
function post(PID)
{
	
  var commenttext = document.getElementById("commenttext").value;
alert(PID);
alert(commenttext);

  if(PID && commenttext)
  {
    $.ajax
    ({
      type: 'POST',
      url: 'commentpost.php',
      data: 
      {
         PID:PID,
	     textComment:commenttext
      },
      success: function (response) 
      {
		  popup("Comment on a Post.");
		  
	    document.getElementById("all_comments").innerHTML=response+document.getElementById("all_comments").innerHTML;
        document.getElementById("commenttext").value="";
  
      }
    });
  }
  
  return false;
}

function like(PID,i)
{
		
 
  if(PID)
  {
    $.ajax
    ({
      type: 'POST',
	  dataType: "JSON",
      url: 'likepost.php',
      data: 
      {
         PID:PID
      },
      success: function (response) 
      {
		  popup("You like this Post.");

		var userlikes = response["userlikes"];
		var userdislikes = response["userdislikes"];

		document.getElementById("txtLikes" + i).innerText="Likes: " + userlikes;
		document.getElementById("txtDisLikes" + i).innerText="Dislikes: " + userdislikes;

      }
    });
  }
  
  return false;
}

function dislike(PID, i)
{
	
 
  if(PID)
  {
    $.ajax
    ({
      type: 'POST',
	  dataType: "JSON",
      url: 'dislikepost.php',
      data: 
      {
         PID:PID
      },
      success: function (response) 
      {
		 
		  popup("You dislike this Post.");
		 
		 
		    var userlikes = response["userlikes"];
		    var userdislikes = response["userdislikes"];

			
			document.getElementById("txtLikes" + i).innerText="Likes: " + userlikes;
		document.getElementById("txtDisLikes" + i).innerText="Dislikes: " + userdislikes;
        
      }
    });
  }
  
  return false;
}

function popup(msg)
{
	
  //$(".popup").css("display", "block");
  $(".popup").show(1000);

  document.getElementById("msg").innerHTML = msg.trim();

  //setTimeout(function(){$(".popup").css("display", "none");},5000);
  setTimeout(function(){$(".popup").hide(1000);},3000);

}
</script>
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


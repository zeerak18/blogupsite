<?php

	require_once('header.php');


?>

<html>
	
	<head>
		
		
		
	</head>
	
	<body>
		
		<form action="login" method="POST">
			
			<h1>Login</h1>
			
			<input type="email" placeholder="Your Email" name="txt_email" required />
			<input type="password" placeholder="Your Password" name="txt_password" required />
			
			<input type="submit" value="Login" name="btn_login" />
			
			
		</form>
		
		<form action="signup" method="POST">
			
			<h1>Sign UP</h1>
			
			<input type="text" placeholder="Your Name" name="txt_name" required />
			<input type="email" placeholder="Your Email" name="txt_email" required />
			<input type="password" placeholder="Your Password" name="txt_password" required />
			
			<input type="submit" value="Sign UP" name="btn_signup" />
			
			
		</form>
		
	</body>

</html>	
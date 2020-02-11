<script type='text/javascript'>
		
	var url = "<?php echo 'https://blogupsite.000webhostapp.com/'; ?>";
	
	var time = 1000;
				
</script>

<?php
	
	function error($request)
	{
		if($request == "Login Successful")
		{
			echo "<h1>Login Successful.</h1>";
	
			echo "Redirecting, please wait a second...";
		
			echo "<script type='text/javascript'>function leave() {  window.location = url+'home';} setTimeout ('leave()', time); </script>";
		}
		else if($request == "Login Failed")
		{
			echo "<h1>Login Failed.</h1>";
	
			echo "Redirecting, please wait a second...";
		
			echo "<script type='text/javascript'>function leave() {  window.location = url;} setTimeout ('leave()', time); </script>";
		}
		else if($request == "Logout")
		{
			session_start();
			
			echo "<h1>Logout.</h1>";
	
			echo "Redirecting, please wait a second...";
		
			echo "<script type='text/javascript'>function leave() {  window.location = url;} setTimeout ('leave()', time); </script>";
			
			session_destroy();
		}
		else if($request == "Unauthorized Access")
		{
			echo "<h1>Unauthorized Access.</h1>";
	
			echo "Redirecting, please wait a second...";
	
			echo "<script type='text/javascript'>function leave() {  window.location = url;} setTimeout ('leave()', time); </script>";
		}
		else if($request == "Unauthorized Access, Not Clicked")
		{
			echo "<h1>Unauthorized Access.</h1>";
	
			echo "Redirecting, please wait a second...";
	
			echo "<script type='text/javascript'>function leave() {  window.location = url+'home';} setTimeout ('leave()', time); </script>";
		}
		else if($request == "Permission Denied")
		{
			echo "<h1>Permission Denied.</h1>";
	
			echo "Redirecting, please wait a second...";
	
			echo "<script type='text/javascript'>function leave() {  window.location = url+'home';} setTimeout ('leave()', time); </script>";
		}
		
		else if($request == "Account Created")
		{
			echo "<h1>You're registered.</h1>";
	
			echo "Redirecting, please wait a second...";
		
			echo "<script type='text/javascript'>function leave() {  window.location = url;} setTimeout ('leave()', time); </script>";
		}
		else if($request == "Account Not Created")
		{
			echo "<h1>Registration not completed.</h1>";
	
			echo "Redirecting, please wait a second...";
		
			echo "<script type='text/javascript'>function leave() {  window.location = url;} setTimeout ('leave()', time); </script>";
		}
		else if($request == "Email Already Registered")
		{
			echo "<h1>Email Already Registered.</h1>";
	
			echo "Redirecting, please wait a second...";
	
			echo "<script type='text/javascript'>function leave() {  window.location = url;} setTimeout ('leave()', time); </script>";
		}
		
		else if($request == "Post Added")
		{
			echo "<h1>Adding a Post.</h1>";
	
			echo "Redirecting, please wait a second...";
		
			echo "<script type='text/javascript'>function leave() {  window.location = url + 'home';} setTimeout ('leave()', time); </script>";
		}
	}
?>	
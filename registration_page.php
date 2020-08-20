<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration page</title>
    <link rel="stylesheet" type = "text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
	
	<style>
		h2 {font-family: 'Permanent Marker', cursive; font-size:50px; color:#0ecc3d}
		i {font-size:30px; color: white;}
	</style>
    <script>
    if(window.location=="http://drivinglicencequiz.altervista.org/registration_page.php")
    window.location="https://drivinglicencequiz.altervista.org/registration_page.php";
    </script>
  </head>
  <?php
  function connect()
		{
			$servername = "localhost";
			$username = "drivinglicencequiz";
			$password = "";
			$dbname = "my_drivinglicencequiz";

			// Create connection
			global $conn;
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) 
			{
    			die("Connection failed: " . $conn->connect_error);
			}
		}

  if(isset($_GET["email"]) && isset($_GET["pass"]))
  {
	connect();
	
	 $email = $_GET["email"];
	 $password = $_GET["pass"];
	
	 $sql = "Select * from account WHERE mail = '$email'";
	 $result = mysqli_query($conn, $sql);
	 
	 if(mysqli_num_rows($result) > 0)
		echo("<script>alert('Already existing account!');</script>");

	 else
	 {
	 	$sql = "Insert INTO statistic() values()";
	 	$result = mysqli_query($conn, $sql);

		$sql = "Select max(id) as id from statistic";
	 	$result = mysqli_query($conn, $sql);
                
          	while($row = mysqli_fetch_assoc($result))
			$id_statistic = $row["id"];		
	 
		$sql = "Insert INTO account(mail, password, is_admin, id_statistic) values('$email', '$password', false, $id_statistic)";
		$result = mysqli_query($conn, $sql);

		echo("<script>window.onload = function(){");
		echo("alert('Registration successfully done!');");
		echo("document.getElementById('back').click();}</script>");
	 }

	mysqli_close($conn);
        
  }

  if(isset($_POST["register"]))
  {
	if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repeat"]))
		{
			session_start();
			connect(); 
			
			if(sha1($_POST["password"]) == sha1($_POST["repeat"]))
			{
				$mail = $_POST["email"];
				$password = sha1($_POST["password"]);
				
				$sql = "Select * from account WHERE mail = '" . $mail . "'";
				$result = mysqli_query($conn, $sql);
				
				if(mysqli_num_rows($result) > 0)
					echo("<script>alert('The email is already in use!')</script>");
				else
				{
					mail($mail,'Confirm your registration','Hi ' . $mail . ' :)! To confirm your registration for our -driving licence quiz test- website, click to the following link: https://drivinglicencequiz.altervista.org/registration_page.php?email=' . $mail . '&pass=' . $password);
					echo("<script>alert('An e-mail was successfully sent; check your inbox to confirm your registration.')</script>");
					
				}
			}
			
			else
				echo("<script>alert('You inserted some wrong parameter!')</script>");

			mysqli_close($conn);
		}
  }
  
  ?>
  <body style="width:98%;height:100%;background-color:#e0e2e5">
  <form method="post" action="registration_page.php">
    <div class="hidden-sm hidden-md hidden-lg">
    	<div class = "row">
    		<div class ="col-xs-12">
				<p align = "center" style = "background-image: linear-gradient(#0ecc3d,#669e87)">
					<br><br><i><b>Driving licence quiz<br>Registration page</b></i><br><br>
				</p>
    		</div>
    	</div>
    </div>
    <div class="container-big" style="width:100%;height:100%;margin-top:5px;">
    		<div class = "hidden-xs">
    	    	<div class = "row">
        			<div class="col-md-12">
          				<h2 align="center">Registration page</h2>
        			</div>
    			</div>
    		</div>
    		<div class = "hidden-xs">
            	<div class = "row">
               	 	<div class = "col-xs-36 col-md-12">
               	 	<p align = "center">
                   		 <img src = "banner.jpg" style="width:90%; height:50%; border:5px solid #0ecc3d;"/>
                   	</p>
               		</div>
            	</div>
    		</div>
    		<div class = "row">
        		<div class = "col-xs-12 col-md-12">
        			<label style="width:100%;">&nbsp</label>
        			<label style="width:100%; border-top: 2px solid lightgrey;">&nbsp</label>
        			<label style="width:20%">&nbsp</label>
            		<label style="width:20%">E-mail:</label>
            		<input style="width:40%" type = "email" placeholder = "E-mail" name = "email" required/>
            		<label style="width:20%">&nbsp</label>
        		</div>
        	</div>
        	<div class = "row">
       		 	<div class = "col-xs-12 col-md-12">
        			<label style="width:20%">&nbsp</label>
            		<label style="width:20%">Psw:</label>
            		<input style="width:40%" type = "password" placeholder = "Password" name = "password" required/>
            		<label style="width:20%">&nbsp</label>
        		</div>
    		</div>
    		
    		<div class = "row">
       		 	<div class = "col-xs-12 col-md-12">
        			<label style="width:20%">&nbsp</label>
            		<label style="width:20%">Repeat:</label>
            		<input style="width:40%" type = "password" placeholder = "Repeat" name = "repeat"required/>
            		<label style="width:20%">&nbsp</label>
            		<label style="width:100%; border-bottom: 2px solid lightgrey;">&nbsp</label>
        		</div>
    		</div>
  
    		<div class = "row">
    			<div class = "col-xs-12 col-md-12">
    				<label style="width:100%">&nbsp</label>
    			</div>
    		</div>
    		
    		<div class = "row">
        		<div class = "col-xs-12 col-md-12">
        		<p align = "center">
           			<button type = "submit" style="width:35%;display:inline-block;" class="btn btn-success" name = "register">
                	Register <span style = "font-size:10px;" class ="glyphicon glyphicon-envelope" aria-hidden="true"></span>
            		</button>
            	</p>
		 </form>
		<form action = "home_page.php" method = "post">
		<p align = "center">
			<button type = "submit" style="width:35%;display:inline-block; color:white" class="btn btn-success" name = "back" id = "back">
                	Back   <span style = "font-size:10px;" class ="glyphicon glyphicon-align-center" aria-hidden="true"></span>
            		</button>
		</form>
		</p>
            	<p align= "center">
            			<label style = "width:100%">&nbsp</label>
            			<label style = "width:100%">&nbsp</label>
            			© 2019 JDK Group. All rights reserved
            	</p>
        		</div>
    		</div>
    	</div>
  </body>
</html>
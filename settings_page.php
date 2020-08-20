<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Settings page</title>
    <link rel="stylesheet" type = "text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
	
	<style>
		h2 {font-family: 'Permanent Marker', cursive; font-size:50px; color:grey}
		i {font-size:30px; color: white;}
	</style>
     <script>
     if(window.location=="http://drivinglicencequiz.altervista.org/settings_page.php")
     window.location="https://drivinglicencequiz.altervista.org/settings_page.php";
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
 		
		session_start();
		
		if(isset($_SESSION["e-mail"]))
		{
			if(isset($_POST["new"]) && isset($_POST["repeat"]))
			{
				connect(); 

				$mail = $_SESSION["e-mail"];
				$password = $_SESSION["password"];
			
				if($_POST["new"] == $_POST["repeat"])
				{
					$new = sha1($_POST["new"]);
					$sql = "Update account SET account.password = '$new' WHERE mail = '$mail' AND password = '$password'";
					$result = mysqli_query($conn, $sql);
					echo("<script>alert('Password successfully updated !')</script>");
					$_SESSION["password"] = $new;
					mysqli_close($conn);
				}
			
				else
					echo("<script>alert('You inserted some wrong parameter !')</script>");
			}
		}

		else
			//echo("<script>window.location = 'menu_page.php';</script>");
            header("location:menu_page.php");
   	?>

  <body style="width:98%;height:100%;background-color:#e0e2e5">
    <div class="hidden-sm hidden-md hidden-lg">
    	<div class = "row">
    		<div class ="col-xs-12">
				<p align = "center" style = "background-image: linear-gradient(grey,#d6d1d1)">
					<br><br><i><b>Driving licence quiz<br>Settings page</b></i><br><br>
				</p>
    		</div>
    	</div>
    </div>
    <div class="container-big" style="width:100%;height:100%; margin-top:5px;">
    		<div class = "hidden-xs">
    	    	<div class = "row">
        			<div class="col-md-12">
          				<h2 align="center">Settings page</h2>
        			</div>
    			</div>
    		</div>

    		<div class = "hidden-xs">
            	<div class = "row">
               	 	<div class = "col-md-12">
               	 	<p align = "center">
                   		<img src = "banner.jpg" style="width:90%; height:50%; border:5px solid grey;"/>
                   	</p>
               		</div>
            	</div>
    		</div>
		<form method="post" action="settings_page.php">
        	<div class = "row">
    			<div class = "col-xs-12 col-md-12">
    				<label style="width:100%">&nbsp</label>
    			</div>
    		</div>
            
        	<div class = "row">
       		 	<div class = "col-xs-12 col-md-12">
        			<label style="width:20%">&nbsp</label>
            		<label style="width:20%">New psw:</label>
            		<input style="width:40%" type = "password" placeholder = "New psw" name = "new" required/>
            		<label style="width:20%">&nbsp</label>
        		</div>
    		</div>
    		
    		<div class = "row">
       		 	<div class = "col-xs-12 col-md-12">
        			<label style="width:20%">&nbsp</label>
            		<label style="width:20%">Repeat:</label>
            		<input style="width:40%" type = "password" placeholder = "Repeat" name = "repeat" required/>
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
           			<button type = "submit" style="width:35%;display:inline-block;background-color:grey; color:white" class="btn btn-default" name = 			"change">
                	Change psw <span style = "font-size:10px;" class ="glyphicon glyphicon-ok" aria-hidden="true" ></span>
            			</button>
				</p>
			</div>
    		</div>
		</form>
		
		<?php if($_SESSION["is_admin"] == 0) { ?>
            	<div class = "row">
        		<div class = "col-xs-12 col-md-12">
			<form method="post" action="home_page.php">
        		<p align = "center">
        			<button type = "submit" style="width:35%;display:inline-block;background-color:grey; color:white" class="btn btn-default" name = 				"delete">Delete user<span style = "font-size:10px;" class ="glyphicon glyphicon-remove" aria-hidden="true" ></span>
            		</button><br>
            	</p>
		</form>
        		</div>
    		</div>
		<?php } ?>
		
            	<div class = "row">
        		<div class = "col-xs-12 col-md-12">
			<form method="post" action="menu_page.php">
        		<p align = "center">
			<button type = "submit" style="width:35%;display:inline-block;background-color:grey; color:white" class="btn btn-default" name = "back">
                	Back   <span style = "font-size:10px;" class ="glyphicon glyphicon-align-center" aria-hidden="true"></span>
            		</button>
			<label style = "width:100%">&nbsp</label>
            		<label style = "width:100%">&nbsp</label>
            		© 2019 JDK Group. All rights reserved
			</p>
			</form>
			</div>
		</div>	
    	</div>
  </body>
</html>
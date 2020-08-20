<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Prepare yourself here for the italian driving licence quiz.">
  	<meta name="keywords" content="driving licence quiz, driving licence, car test, test, driver, italian quiz">
  	<meta name="author" content="David S.">
    <title>Main page</title>
    <link rel="stylesheet" type = "text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">    
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
	
	<style>
		h2 {font-family: 'Permanent Marker', cursive; font-size:50px; color:#296ddb}
		i {font-size:30px; color: white;}
	</style>
    
    <script>
     if(window.location=="http://drivinglicencequiz.altervista.org/home_page.php")
     window.location = "https://drivinglicencequiz.altervista.org";  
     </script>
     
  	</head>
  	<body style="width:98%;height:100%;background-color:#e0e2e5">
  	
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
		
		function destroySession()
		{
			session_start();
			session_unset();
			session_destroy();
		}

  		if(isset($_POST["login"]))
		{
			connect();
			session_start(); 

			$mail = $_POST["e-mail"];
			$password = sha1($_POST["password"]);


			$sql = "SELECT mail, password, is_admin FROM account WHERE mail = '$mail' AND password = '$password'";
			$result = mysqli_query($conn, $sql);

			if (mysqli_num_rows($result) == 0) 
				echo("<script>alert('Login credentials are wrong!')</script>");
			
			else
			{
				while($row = mysqli_fetch_assoc($result))
                {
                	$_SESSION["is_admin"] = $row["is_admin"];
                	$_SESSION["e-mail"] = $row['mail'];
					$_SESSION["password"] = $row['password'];
                }
				
				//echo("<script>window.location.replace('menu_page.php')</script>");
                header("location: menu_page.php");
			}
			
			mysqli_close($conn);
		}
		
		elseif(isset($_POST["delete"]))
		{
			connect();
			session_start();

			$mail = $_SESSION["e-mail"];
			$password = $_SESSION["password"];
			
			$sql = "Select * FROM account WHERE mail = '$mail' AND password = '$password'";
			$result = mysqli_query($conn, $sql);
			
			while($row = mysqli_fetch_assoc($result))
				$id_statistic = $row["id_statistic"];

			$sql = "Delete FROM account WHERE mail = '$mail' AND password = '$password'";
			$result = mysqli_query($conn, $sql);

			$sql = "Delete FROM statistic WHERE id = $id_statistic"; 
			$result = mysqli_query($conn, $sql);
			
			destroySession();	
		}

		else
			destroySession();
			
		?> 
  	
  	<form method="post" action="home_page.php">
    <div class="hidden-sm hidden-md hidden-lg">
    	<div class = "row">
    		<div class ="col-xs-12">
					<p align = "center" style = "background-image: linear-gradient(#296ddb,#5089aa)">
					<br><br><i><b>Driving licence quiz<br>Main page</b></i><br><br>
				</p>
    		</div>
    	</div>
    </div>
    <div class="container-big" style="width:100%;height:100%;margin-top:5px;">
    		<div class = "hidden-xs">
    	    	<div class = "row">
        			<div class="col-md-12">
          				<h2 align="center">Main page</h2>
        			</div>
    			</div>
    		</div>
    		<div class = "hidden-xs">
            	<div class = "row">
               	 	<div class = "col-xs-36 col-md-12">
               	 	<p align = "center">
                   		 <img src = "banner.jpg" style="width:90%; height:50%; border:5px solid #296ddb;"/>
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
            		<input style="width:40%" type = "email" placeholder = "E-mail" name = "e-mail" required/>
            		<label style="width:20%">&nbsp</label>
        		</div>
        	</div>
        	<div class = "row">
       		 	<div class = "col-xs-12 col-md-12">
        			<label style="width:20%">&nbsp</label>
            		<label style="width:20%">Psw:</label>
            		<input style="width:40%" type = "password" placeholder = "Password" name = "password" required/>
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
           			<button type = "submit" style="width:35%;display:inline-block;" class="btn btn-primary" name = "login">
                	Login <span style = "font-size:10px;" class ="glyphicon glyphicon-align-center" aria-hidden="true"></span>
            		</button>
            	</p>
        		</div>
    		</div>
    		
    		<div class = "row">
        		<div class = "col-xs-12 col-md-12">
        		<p align = "center">
        			<a href = "registration_page.php">Register</a>
        		</p>
        		</div>
        	</div>
        	
        	<div class = "row">
        		<div class = "col-xs-12 col-md-12">
        		<p align = "center">
        			<a href = "menu_page.php">Enter as guest</a>
        		</p>
        		<p align= "center">
            			<label style = "width:100%">&nbsp</label>
            			<label style = "width:100%">&nbsp</label>
            			© 2019 JDK Group. All rights reserved
            	</p>
        		</div>
        	</div>
    	</div>
    </form>
  </body>
</html>
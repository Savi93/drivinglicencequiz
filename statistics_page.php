<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistics page</title>
    <link rel="stylesheet" type = "text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
	
	<style>
		h2 {font-family: 'Permanent Marker', cursive; font-size:50px; color:#ef8f00}
		i {font-size:30px; color: white;}
	</style>
    <script>
    if(window.location=="http://drivinglicencequiz.altervista.org/statistics_page.php")
    window.location="https://drivinglicencequiz.altervista.org/statistics_page.php";
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
			connect(); 

			$mail = $_SESSION["e-mail"];
			$password = $_SESSION["password"];
			
			$sql = "SELECT solved, time, errors_1_10, errors_11_20, errors_21_30, errors_31_40 FROM statistic, account WHERE id_statistic = statistic.id 				AND account.mail = '$mail'";
			$result = mysqli_query($conn, $sql);
		
			if (mysqli_num_rows($result) > 0) 
			{
				$row = mysqli_fetch_assoc($result);
        			$solved = $row["solved"];
				$time = $row["time"];
				$errors_1_10 = $row["errors_1_10"];
				$errors_11_20 = $row["errors_11_20"];
				$errors_21_30 = $row["errors_21_30"];
				$errors_31_40 = $row["errors_31_40"];

				if($solved && $time > 0)
				{
					$average_errors = round(($errors_1_10 + $errors_11_20 + $errors_21_30 + $errors_31_40) / $solved, 2);
					$average_time = round(($time / $solved) / 60, 2);
					$worst = max($errors_1_10, $errors_11_20, $errors_21_30, $errors_31_40);
				
					if($worst == $errors_1_10)
					$attention = "You are distracted at most in the piece <label style = 'color:#ef8f00'>1-10</label>, since you made <label style = 'color:#ef8f00'>$errors_1_10</label> errors. Be careful!";
					elseif($worst == $errors_11_20)
					$attention = "You are distracted at most in the piece <label style = 'color:#ef8f00'>11-20</label>, since you made <label style = 'color:#ef8f00'>$errors_11_20</label> errors. Be careful!";
					elseif($worst == $errors_21_30)
					$attention = "You are distracted at most in the piece <label style = 'color:#ef8f00'>21-30</label>, since you made <label style = 'color:#ef8f00'>$errors_21_30</label> errors. Be careful!";
					elseif($worst == $errors_31_40)
					$attention = "You are distracted at most in the piece <label style = 'color:#ef8f00'>31-40</label>, since you made <label style = 'color:#ef8f00'>$errors_31_40</label> errors. Be careful!";
				}
			
				else
				{
					$average_errors = 0;
					$average_time = 0;
					$attention = "Solve at least one quiz to see your performance!";
				}
			}
		
		
			mysqli_close($conn);
		}
		
		else
			//echo("<script>window.location = 'menu_page.php';</script>");
            header("location:menu_page.php");
  ?>

  <body style="width:98%;height:100%;background-color:#e0e2e5">
    <div class="hidden-sm hidden-md hidden-lg">
    	<div class = "row">
    		<div class ="col-xs-12">
				<p align = "center" style = "background-image: linear-gradient(#ef8f00,#f7ff1c)">
					<br><br><i><b>Driving licence quiz<br>Statistics page</b></i><br><br>
				</p>
    		</div>
    	</div>
    </div>
    <div class="container-big" style="width:100%;height:100%;margin-top:5px;">
    		<div class = "hidden-xs">
    	    	<div class = "row">
        			<div class="col-md-12">
          				<h2 align="center">Statistics page</h2>
        			</div>
    			</div>
    		</div>
    		<div class = "hidden-xs">
            	<div class = "row">
               	 	<div class = "col-xs-36 col-md-12">
               	 	<p align = "center">
                   		 <img src = "banner.jpg" style="width:90%; height:50%; border:5px solid #ef8f00;"/>
                   	</p>
               		</div>
            	</div>
    		</div>
    		<div class = "row">
        		<div class = "col-xs-12 col-md-12">
        			<label style="width:100%;">&nbsp</label>
        			<label style="width:100%; border-top: 2px solid lightgrey;">&nbsp</label>
        		<p align = "center">
            		<label style="width:100%;"><b>User <?php echo("$mail") ?>, you have an average of errors per quiz of:</b></label>
        		<?php 
				if($average_errors <= 4)
				{
					echo("<label style='width:100%;font-size:30px;color:green'><b>$average_errors Well done!</b></label>");
					echo("<img style='width:15%' src = 'happy.png'></img>");
				}
        				
				else
				{
					echo("<label style='width:100%;font-size:30px;color:red'><b>$average_errors Train more!</b></label>");
					echo("<img style='width:10%' src = 'sad.png'></img>");
				}
			?>
				<label style="width:100%">&nbsp</label>
				<label style="width:100%;"><b>You have completed in total <?php echo("<label style = 'color:#ef8f00'>$solved</label>") ?> quizzes and your average time in minutes per quiz is: <?php echo("<label style = 'color:#ef8f00'>$average_time</label>")?></b></label>
				<label style="width:100%;"><b><?php echo($attention)?></b></label>
        		</p>
            		<label style="width:100%">&nbsp</label>
            		<label style="width:100%; border-bottom: 2px solid lightgrey;">&nbsp</label>
			<label style="width:100%">&nbsp</label>
			<form action = "menu_page.php" method = "post">
			<p align = "center">
			<button type = "submit" style="width:35%;display:inline-block;background-color:#ef8f00; color:white" class="btn btn-default" name = "back">
                	Back   <span style = "font-size:10px;" class ="glyphicon glyphicon-align-center" aria-hidden="true"></span>
            		</button>
		</form>
		</p>
        		</div>
    		</div>
  
    		<div class = "row">
    			<div class = "col-xs-12 col-md-12">
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
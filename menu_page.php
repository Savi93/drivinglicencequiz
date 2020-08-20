<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu page</title>
    <link rel="stylesheet" type = "text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
	
	<style>
		h2 {font-family: 'Permanent Marker', cursive; font-size:50px; color:#b042f4}
		i {font-size:30px; color: white;}
	</style>
	<script>
    if(window.location=="http://drivinglicencequiz.altervista.org/menu_page.php")
    window.location="https://drivinglicencequiz.altervista.org/menu_page.php";
	</script>
  </head>
  <body style="width:98%;height:100%;background-color:#e0e2e5">
  
   <?php 
	session_start(); 
	
	unset($_SESSION["question_pos"]);
	unset($_SESSION["questions"]);
	for($j = 1; $j < 41; $j++)
		unset($_SESSION["answer" . $j]);

	if(isset($_SESSION["e-mail"]) && isset($_SESSION["password"]))
        {
		$email = $_SESSION["e-mail"];
		$password = $_SESSION["password"];
	}
   ?>

   <div class="hidden-sm hidden-md hidden-lg">
    	<div class = "row">
    		<div class ="col-xs-12">
				<p align = "center" style = "background-image: linear-gradient(#b042f4,#5b516d)">
					<br><br><i><b>Driving licence quiz<br>Menu page</b></i><br><br>
				</p>
    		</div>
    	</div>
    </div>
    <div class="container-big" style="width:100%;height:100%;margin-top:5px;">
    		<div class = "hidden-xs">
    	    	<div class = "row">
        			<div class="col-md-12">
          				<h2 align="center">Menu page</h2>
        			</div>
    			</div>
    		</div>
    		<div class = "hidden-xs">
            	<div class = "row">
               	 	<div class = "col-xs-36 col-md-12">
               	 	<p align = "center">
                   		 <img id = "title" src = "banner.jpg" style="width:90%; height:50%; border:5px solid #b042f4;"/>
                   	</p>
               		</div>
            	</div>
    		</div>
    		<div class = "row">
        		<div class = "col-xs-12 col-md-12">
        			<label style="width:100%;">&nbsp</label>
        			<label style="width:100%; border-top: 2px solid lightgrey;">&nbsp</label>
				
				<?php
					if(isset($email) && isset($password))
						echo("<p align='center'><label style='width:100%; color:#b042f4; align:center'>Welcome user $email !</label></p>");
					else
						echo("<p align='center'><label style='width:100%; color:#b042f4; align:center'>Welcome guest !</label></p>");
				?>
				
				<label style="width:100%">&nbsp</label>
        			<label style="width:30%">&nbsp</label>
           			<a href = "quiz_page.php"><button type = "submit" style="width:35%;display:inline-block;width:40%; background-color:#b042f4;color:white" class="btn btn-default">
                	 New quiz <span style = "font-size:10px;" class ="glyphicon glyphicon-road" aria-hidden="true" ></span>
            		</button></a>
            		<label style="width:30%">&nbsp</label>
        		</div>
        	</div>
        	
				<?php
					if(isset($email) && isset($password))
					{
				?>

		<div class = "row">
       		 	<div class = "col-xs-12 col-md-12">
        		<label style="width:30%">&nbsp</label>
            		<a href = "statistics_page.php"><button type = "submit" style="width:35%;display:inline-block;width:40%; background-color:#b042f4;color:white" class="btn btn-default">
                	 Statistics page <span style = "font-size:10px;" class ="glyphicon glyphicon-remove-circle" aria-hidden="true" ></span>
            		</button></a>
            		<label style="width:30%">&nbsp</label>
        		</div>
    		</div>
    		
    		<div class = "row">
       		 	<div class = "col-xs-12 col-md-12">
        			<label style="width:30%">&nbsp</label>
            		<a href = "settings_page.php"><button type = "submit" style="width:35%;display:inline-block;width:40%; background-color:#b042f4;color:white" class="btn btn-default">
                	 Settings Page <span style = "font-size:10px;" class ="glyphicon glyphicon-pencil" aria-hidden="true" ></span>
            		</button></a>
            		<label style="width:30%">&nbsp</label>
        		</div>
    		</div>
		
		<?php if($_SESSION["is_admin"] == 1) { ?>
    		<div class = "row">
    			<div class = "col-xs-12 col-md-12">
        			<label style="width:30%">&nbsp</label>
            		<a href = "admin_page.php"><button type = "submit" style="width:35%;display:inline-block;width:40%; background-color:#b042f4;color:white" 			class="btn btn-default">
                	 Admin page <span style = "font-size:10px;" class ="glyphicon glyphicon-user" aria-hidden="true" ></span>
            		</button></a>
            		<label style = "width:100%">&nbsp</label>
			</div>
		</div>
		<?php } ?>
		
		<div class = "row">
    			<div class = "col-xs-12 col-md-12">
            		<label style = "width:100%">&nbsp</label>
            		<p align = "center">
            		<a href = "home_page.php" style = "color:#b042f4">Logout</a>
            		</p>
			</div>
    		</div>

		<?php
		}

		else
		{
		?>
			<div class = "row">
    			<div class = "col-xs-12 col-md-12">
        		<label style="width:100%">&nbsp</label>
            		<p align = "center">
            		<a href = "home_page.php" style = "color:#b042f4">Return back</a>
            		</p>
			</div>
    		</div>
		<?php
		}
		?>
			<div class = "row">
    			<div class = "col-xs-12 col-md-12">
            		<label style = "width:100%">&nbsp</label>
            		<label style="width:100%; border-bottom: 2px solid lightgrey;">&nbsp</label>
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
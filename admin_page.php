<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin page</title>
    <link rel="stylesheet" type = "text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">    
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
	
	<style>
		h2 {font-family: 'Permanent Marker', cursive; font-size:50px; color:#e00000}
		i {font-size:30px; color: white;}
	</style>
    <script>
    if(window.location=="http://drivinglicencequiz.altervista.org/admin_page.php")
    window.location="https://drivinglicencequiz.altervista.org/admin_page.php";
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
			$conn = new mysqli($servername, $username, $password, $dbname);
			// Check connection
			if ($conn->connect_error) 
			{
    			die("Connection failed: " . $conn->connect_error);
			}

			return $conn;
	}

  	function showQuestions()
  	{
			$conn = connect();

			$sql = "SELECT * from question order by id asc";
			$result = mysqli_query($conn, $sql);
		
			if(mysqli_num_rows($result) > 0) 
			{
				while($row = mysqli_fetch_assoc($result))
				{
					$id = $row["id"];
					$text = $row["text"];
				
					echo("<p align = 'center'><input style = 'width:15px;height:15px;' type = 'checkbox' name = 'check[]' value = '$id'/>  <b>						$id:</b>  $text<br><br><button type = 'submit' style='width:30%;display:inline-block;background-color:#e00000;color:white' name = 						'modify' value = '$id'>Modify</button></p><label style='width:100%; border-bottom: 2px solid 											lightgrey;'>&nbsp</label><label style='width:100%'>&nbsp</label>");
				}
			}

		mysqli_close($conn);
  	}
	
	session_start();

	if($_SESSION["is_admin"] == 1)
	{
		if(isset($_POST["delete"]) && isset($_POST["check"]) && !empty($_POST["check"]))
		{
			$conn = connect();
		
			$count = 0;
			foreach($_POST["check"] as $value)
			{
				$sql = "Select image from question WHERE id = $value";
				$result = mysqli_query($conn, $sql);
				$row = mysqli_fetch_assoc($result);
				$to_delete = $row["image"];
				if($to_delete != "")
					unlink($to_delete);

				$sql = "DELETE from question where id = $value";
				$result = mysqli_query($conn, $sql);
				$count += mysqli_affected_rows($conn);
			}

			echo("<script>alert('You deleted correctly $count rows!');</script>");
			
			mysqli_close($conn);
		}

		elseif(isset($_POST["modify"]))
		{
			$_SESSION["to_modify"] = $_POST["modify"];
			//echo("<script>window.location = 'admin_page_modify.php';</script>");
            header("location:admin_page_modify.php");
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
				<p align = "center" style = "background-image: linear-gradient(#e00000,#c94848)">
					<br><br><i><b>Driving licence quiz<br>Admin page</b></i><br><br>
				</p>
    		</div>
    	</div>
    </div>
    <div class="container-big" style="width:100%;height:100%;margin-top:5px;">
    		<div class = "hidden-xs">
    	    	<div class = "row">
        			<div class="col-md-12">
          				<h2 align="center">Admin page</h2>
        			</div>
    			</div>
    		</div>

    		<div class = "hidden-xs">
            	<div class = "row">
               	 	<div class = "col-xs-36 col-md-12">
               	 	<p align = "center">
                   		 <img src = "banner.jpg" style="width:90%; height:50%; border:5px solid #e00000;"/>
                   	</p>
               		</div>
            	</div>
    		</div>
		
		<form align = "center" action = "admin_page.php" method = "post">
    		<div class = "row" align = "center">
        		<div class = "col-xs-12 col-md-12">
			<label style="width:100%;">&nbsp</label>
			<label style="width:100%; border-top: 2px solid lightgrey;">&nbsp</label>
    					<div class = "newScrollBar" style = "overflow-y:scroll; width:95%; height:170px; border:1px solid #e00000;">
					<?php showQuestions(); ?>
					</div>
        		</div>
        	</div>
    		
    		<div class = "row">
       		 	<div class = "col-xs-12 col-md-12">
            		<label style="width:100%">&nbsp</label>
            		<label style="width:100%; border-bottom: 2px solid lightgrey;">&nbsp</label>
			<label style="width:100%">&nbsp</label>
        		</div>
    		</div>
  
    		<div class = "row">
    			<div class = "col-xs-12 col-md-12">
				<button type = "submit" style="width:35%;display:inline-block; color:white" class="btn btn-danger" name = "delete" id = "delete">
                		Delete <span style = "font-size:10px;" class ="glyphicon glyphicon-trash" aria-hidden="true"></span>
            			</button>
				</form>
				<br><br>
				<form action = "admin_page_new.php" method = "post">
				<p align = "center">
           			<button type = "submit" style="width:35%;display:inline-block;" class="btn btn-danger" name = "add">
                		Add new <span style = "font-size:10px;" class ="glyphicon glyphicon-plus" aria-hidden="true"></span>
            			</button>
				</p>
				</form>
				<form action = "menu_page.php" method = "post">
				<p align = "center">
				<button type = "submit" style="width:35%;display:inline-block;; color:white" class="btn btn-danger" name = "back">
                		Back <span style = "font-size:10px;" class ="glyphicon glyphicon-align-center" aria-hidden="true"></span>
            			</button>
				</p>
				</form>
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
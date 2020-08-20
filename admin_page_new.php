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
        
        .form-radio
		{
     			-webkit-appearance: none;
     			-moz-appearance: none;
    			 appearance: none;
     			display: inline-block;
     			position: relative;
     			background-color: #f1f1f1;
     			color: #666;
     			top: 10px;
     			height: 30px;
     			width: 30px;
     			border: 0;
     			border-radius: 50px;
     			cursor: pointer;     
     			margin-right: 7px;
     			outline: none;
			}
		.form-radio:checked::before
		{
     			position: absolute;
     			font: 13px/1 'Open Sans', sans-serif;
     			left: 11px;
     			top: 7px;
     			content: '\02143';
     			transform: rotate(40deg);
		}
		.form-radio:hover
		{
     			background-color: #f7f7f7;
		}
		.form-radio:checked
		{
     			color: black;
     			background-color: #f1f1f1;
		}	
  </style>
  <script>
  if(window.location=="http://drivinglicencequiz.altervista.org/admin_page_new.php")
  window.location="https://drivinglicencequiz.altervista.org/admin_page_new.php";
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
    
    function endsWith($string, $endString) 
	{ 
    	$len = strlen($endString); 
   	 	if ($len == 0)
        	return true; 
            
    	return (substr($string, -$len) === $endString); 
	} 
	
	session_start();

	if($_SESSION["is_admin"] == 1)
	{   
		if(isset($_POST["insert"]) && $_FILES["file"]["name"] != "")
		{	
			$file_name = $_FILES["file"]["name"];
      			$file_size =$_FILES["file"]["size"];
      			$file_tmp =$_FILES["file"]["tmp_name"];
			$path = 'image/';
		
			if($file_size > 5000000)
         			echo("<script>alert('Image is to big!');</script>");
		
			elseif(file_exists($path . $file_name))
				echo("<script>alert('Image already existing!');</script>");
		
			elseif(!(endsWith($file_name, ".png") || endsWith($file_name, ".jpg") || endsWith($file_name, ".jpeg")))
				echo("<script>alert('Invalid image format!');</script>");

			else
			{
				$text = $_POST["text"];
				$answer = $_POST["answer"];
			
				move_uploaded_file($file_tmp, $path . $file_name);

				$conn = connect();
				$sql = "INSERT into question(text, image, is_true) values('$text', '$path$file_name', $answer)";
				$result = mysqli_query($conn, $sql);
			
				if(mysqli_affected_rows($conn) > 0)
					echo("<script>alert('Question with image correctly inserted!');</script>");
	
				mysqli_close($conn);
			}
      		}

		elseif(isset($_POST["insert"]) && $_FILES["file"]["name"] == "")
		{
        	echo("ERRORE 4");
			$text = $_POST["text"];
			$answer = $_POST["answer"];
		
			$conn = connect();

			$sql = "INSERT into question(text, is_true) values('$text', $answer)";
			$result = mysqli_query($conn, $sql);

			if(mysqli_affected_rows($conn) > 0)
				echo("<script>alert('Question correctly inserted!');</script>");

			mysqli_close($conn);
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
		
		<form action = "admin_page_new.php" method = "post" enctype = "multipart/form-data">
    		<div class = "row" align = "center">
        		<div class = "col-xs-12col-md-12">
				<label style="width:100%;">&nbsp</label>
				<label style="width:100%; border-top: 2px solid lightgrey;">&nbsp</label>
    				<label style = "color:#e00000; width:100%">Insert here the text of your question:</label>
				<textarea style = "border:1px solid red; width:85%;background-color:#e0e2e5" rows="4" name = "text" required></textarea>
				<label style="width:100%">&nbsp</label>
				<label style = "color:#e00000; width:100%">If you want to use also an image, select it here:</label>
				<input type = "file" name="file" id="file" accept = ".png, .jpg, .jpeg" >
				<label style="width:100%">&nbsp</label>
        		</div>
        	</div>

		<div class = "row" align = "center">
			<div class = "col-xs-12 col-md-12">
			<label style = "color:#e00000; width:100%">Select the answer to the question:</label>
	<label style = "color:green; font-size:20px">TRUE &nbsp</label><input class= "form-radio" style = "height:25px; width:25px;" type = "radio" name="answer" value = "true" checked/>
			<label style="width:5%;">&nbsp</label>
	<label style = "color:red; font-size:20px">FALSE &nbsp</label><input class="form-radio" style = "height:25px; width:25px;" type = "radio" name="answer" value = "false"/>
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
				<p align = "center">
				<label style="width:100%">&nbsp</label>
           			<button type = "submit" style="width:35%;display:inline-block;" class="btn btn-danger" name = "insert">
                		Insert <span style = "font-size:10px;" class ="glyphicon glyphicon-plus" aria-hidden="true"></span>
            			</button>
				</p>
			</div>
		</div>
		</form>

    		<div class = "row">
    			<div class = "col-xs-12 col-md-12">
				<form action = "admin_page.php" method = "post">
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
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quiz page</title>
    <link rel="stylesheet" type = "text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">
	
	<style>
		h2 {font-family: 'Permanent Marker', cursive; font-size:50px; color:black}
		i {font-size:30px; color: white;}
		button {background-color:black; color:white}
        
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
		if(window.location=="http://drivinglicencequiz.altervista.org/quiz_page_correct.php")
         window.location="https://drivinglicencequiz.altervista.org/quiz_page_correct.php";
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

	function createQuestionButtons($start, $end, $size)
	{
			for($j = $start; $j < $end; $j++)
			{
				if($_SESSION["question_pos"] === $j && $_SESSION["questions"][$j][3] != $_SESSION["answer" . $j])
					echo("<button style='width:$size%;background-color:#910000' name = 'question' value = '$j'>$j</button>");
				elseif($_SESSION["question_pos"] === $j && $_SESSION["questions"][$j][3] === $_SESSION["answer" . $j])
					echo("<button style='width:$size%;background-color:#1a4f00' name = 'question' value = '$j'>$j</button>");
				elseif($_SESSION["questions"][$j][3] != $_SESSION["answer" . $j])
					echo("<button style='width:$size%;background-color:red' name = 'question' value = '$j'>$j</button>");
				elseif($_SESSION["questions"][$j][3] === $_SESSION["answer" . $j])
					echo("<button style='width:$size%;background-color:green' name = 'question' value = '$j'>$j</button>");		
			}		
	}

	function computeTimeSeconds($minutes, $seconds)
	{
		$total = 30 * 60;

		return $total - ($minutes * 60 + $seconds);
	}

	function computeErrors($start, $end)
	{
		$errors = 0;

		for($j = $start; $j <= $end; $j++)
			if($_SESSION["questions"][$j][3] !== $_SESSION["answer" . $j])
				$errors++;
		
		return $errors;
	}
	
	session_start();
	
	if(isset($_POST["correct"]))
	{
		$_SESSION["answer" . $_SESSION["question_pos"]] = $_POST["last_answer"];

		$change = 1;
		$_SESSION["question_pos"] = $change;
		
			$errors = computeErrors(1,40);

			if($errors > 4)
				echo("<script>alert(':( You failed the test! You made $errors errors.')</script>");
			else
				echo("<script>alert(':) You passed the test! You made $errors errors.')</script>");
		
		if(isset($_SESSION["e-mail"]))
		{
			connect();
			
			$mail = $_SESSION["e-mail"];

			$sql = "UPDATE statistic, account set solved = solved + 1, time = time +" . computeTimeSeconds($_POST["minutes_correct"], $_POST					["seconds_correct"]) . ", errors_1_10 = errors_1_10 + " . computeErrors(1,10) . ", errors_11_20 = errors_11_20 + "  . computeErrors(11,20) .", 				errors_21_30 = errors_21_30 + " . computeErrors(21,30) . ", errors_31_40 = errors_31_40 + " . 	computeErrors(31,40) . " WHERE account.mail ='" 			. $mail . "' AND account.id_statistic = statistic.id";

			$result = mysqli_query($conn, $sql);
			
			mysqli_close();
		}
	}
	
	elseif(isset($_POST["question"]))
  	for($j = 1; $j < 41; $j++)
	{
		if($_POST["question"] == $j)
		{
			$change = $j;
			$_SESSION["question_pos"] = $j;
			break;
		}
	}	
	
	elseif(isset($_POST["previous"]))
	{
		$change = $_SESSION["question_pos"] - 1;
		$_SESSION["question_pos"] = $change;
	}
	
	elseif(isset($_POST["next"]))
	{
		$change = $_SESSION["question_pos"] + 1;
		$_SESSION["question_pos"] = $change;
	}

	else
		//echo("<script>window.location = 'menu_page.php';</script>");
        header("location:menu_page.php");
	
  ?>

  <body style="width:98%;height:100%;background-color:#e0e2e5">
    <div class="hidden-sm hidden-md hidden-lg">
    	<div class = "row">
    		<div class ="col-xs-12">
				<p align = "center" style = "background-image: linear-gradient(black,#4f4f4f)">
					<br><br><i><b>Driving licence quiz<br>Quiz page</b></i><br><br>
				</p>
    		</div>
    	</div>
    </div>
    <div class="container-big" style="width:100%;height:100%;margin-top:5px;">
    		<div class = "hidden-xs">
    	    	<div class = "row">
        			<div class="col-md-12">
          				<h2 align="center">Quiz page</h2>
        			</div>
    			</div>
    		</div>
    		<div class = "hidden-xs">
            	<div class = "row">
               	 	<div class = "col-xs-36 col-md-12">
               	 	<p align = "center">
                   		 <img src = "banner.jpg" style="width:90%; height:50%; border:5px solid black;"/>
                   	</p>
               		</div>
            	</div>
    		</div>
		
		<form action = "quiz_page_correct.php" method = "post">
    		<div class = "hidden-xs">
    		<div class = "row">
        		<div class = "col-md-12">
        			<label style="width:100%;">&nbsp</label>
        			<label style="width:100%; border-top: 2px solid lightgrey;">&nbsp</label>
        			<label style="width:100%">&nbsp</label>
        			<p align = "center">
			<?php 
			createQuestionButtons(1,21,4)
			?>
			<br>
			<?php 
			createQuestionButtons(21,41,4);
			?>
            		</p>
            		<label style="width:100%">&nbsp</label>
        		</div>
        	</div>
        	</div>
        	<div class = "hidden-md hidden-sm hidden-lg">
    		<div class = "row">
        		<div class = "col-xs-36">
        			<label style="width:100%;">&nbsp</label>
        			<label style="width:100%; border-top: 2px solid lightgrey;">&nbsp</label>
        			<p align = "center" style = "width:100%">
            		<?php 
			createQuestionButtons(1,11,8);
			?>
            		</p>
        		</div>
        	</div>
    		<div class = "row">
        		<div class = "col-xs-36">
        			<p align = "center" style = "width:100%">
            		<?php 
			createQuestionButtons(11,21,8);
			?>
            		</p>
        		</div>
        	</div>
    		<div class = "row">
        		<div class = "col-xs-36">
        			<p align = "center" style = "width:100%">
            		<?php 
			createQuestionButtons(21,31,8);
			?>
            		</p>
        		</div>
        	</div>
    		<div class = "row">
        		<div class = "col-xs-36">
        		<p align = "center" style = "width:100%">
            		<?php 
			createQuestionButtons(31,41,8);
			?>
            		<label style="width:100%;">&nbsp</label>
            		</p>
        		</div>
        	</div>
        	</div>

		<div class = "row">
        		<div class = "col-xs-12 col-md-12">
        		<p align = "center" style = "width:100%">

			<?php
				echo("<label id = 'timer' style='width:100%;font-size:25px'><b>Time " . $_POST["minutes_correct"] . ":" . $_POST["seconds_correct"] . "</b></label>");
			?>	

            		</p>
        		</div>
        	</div>

		
		<div class = "row">
        		<div class = "col-xs-12 col-md-12">
        		<p align = "center" style = "width:100%">
            			<label style="width:100%;font-size:18px"><b>Question nr. <?php echo($_SESSION["question_pos"]); ?></b></label>
            		</p>
        		</div>
        	</div>

        	<div class = "hidden-md hidden-sm hidden-lg">
        	<div class = "row">
       		 	<div class = "col-xs-12">	
        			<p align = "center">
        			<?php if($_SESSION["questions"][$_SESSION["question_pos"]][1] != "")
				{	
					$image = $_SESSION["questions"][$_SESSION["question_pos"]][1];
					echo("<img src = '$image' style = 'border:2px solid black' width = '50%' alt='Image not found'></img>");
				} 
				?>
        			<label style="width:100%;">&nbsp</label>
            		<label style="width:80%"><?php echo($_SESSION["questions"][$_SESSION["question_pos"]][2])?></label>
            		</p>
        		</div>
    		</div>
    		</div>
    		
    		<div class = "hidden-xs">
        	<div class = "row">
       		 	<div class = "col-md-12">
        			<p align = "center">
        			<?php if($_SESSION["questions"][$_SESSION["question_pos"]][1] != "")
				{	
					$image = $_SESSION["questions"][$_SESSION["question_pos"]][1];
					echo("<img src = '$image' style = 'border:2px solid black' width = '30%' alt='Image not found'></img>");
				} 
				?>
        			<label style="width:100%;">&nbsp</label>
            		<label style="width:80%"><?php echo($_SESSION["questions"][$_SESSION["question_pos"]][2])?></label>
            		</p>
        		</div>
    		</div>
    		</div>
    		
    		<div class = "row">
    			<div class = "col-xs-12 col-md-12">
    			<p align = "center">
				<?php
				if($_SESSION["answer" . $change] == "true")
				{ 
					?>
					<label style = "color:green; font-size:20px">TRUE &nbsp</label><input style = "height:25px; 										width:25px;" type = "radio" name = "answer" value = "true" class = "form-radio" checked disabled/>
    					<label style="width:5%;">&nbsp</label>
    					<label style = "color:red; font-size:20px">FALSE &nbsp</label><input style = "height:25px; width:25px;" 								type = 	"radio" name = "answer" value = "false" class = "form-radio" disabled/>
				<?php

				}
				
				elseif($_SESSION["answer" . $change] == "false")
				{
					?>
					<label style = "color:green; font-size:20px">TRUE &nbsp</label><input style = "height:25px; 										width:25px;" type = "radio" name = "answer" value = "true" class = "form-radio" disabled/>
    					<label style="width:5%;">&nbsp</label>
    					<label style = "color:red; font-size:20px">FALSE &nbsp</label><input style = "height:25px; width:25px;" 								type = "radio" name = "answer" value = "false" checked class = "form-radio" disabled/>
				<?php
				}

				else
				{
					?>
					<label style = "color:green; font-size:20px">TRUE &nbsp</label><input style = "height:25px; 										width:25px;" type = "radio" name = "answer" id = "true" value = "true" class = "form-radio" disabled/>
    					<label style="width:5%;">&nbsp</label>
    					<label style = "color:red; font-size:20px">FALSE &nbsp</label><input style = "height:25px; width:25px;" 								type = "radio" name = "answer" id = "false" value = "false" class = "form-radio" disabled/>
					<?php
				}
				?>
    				
    				<label style="width:100%; border-bottom: 2px solid lightgrey;">&nbsp</label>
    			</p>
    			</div>
    		</div>
  		
		<?php

			echo("<input type = 'hidden' name = 'minutes_correct' id = 'minutes_correct' value ='" . $_POST["minutes_correct"] . "'/>");
			echo("<input type = 'hidden' name = 'seconds_correct' id = 'seconds_correc' value = '" . $_POST["seconds_correct"] . "'/>");
		?>	

    		<div class = "row">
        		<div class = "col-xs-12 col-md-12">
        		<p align = "center">
			<?php
				if($_SESSION["question_pos"] > 1)
				{ ?>
        		<button type = "submit" style="width:30%;display:inline-block; background-color:black; color:white" class="btn btn-default" name = "previous">
                	<span style = "font-size:10px;" class ="glyphicon glyphicon-backward" aria-hidden="true" ></span>
            		</button>
			<?php
				}

			if($_SESSION["question_pos"] < 40)
				{ ?>
            		<button type = "submit" style="width:30%;display:inline-block;background-color:black; color:white" class="btn btn-default" name = "next">
                	<span style = "font-size:10px;" class ="glyphicon glyphicon-forward" aria-hidden="true" ></span>
            		</button>
			<?php
				}
				?>
            	</p>
		</form>
		
		<form action = "quiz_page.php" method = "post">
		<p align = "center">
           			<button type = "submit" style="width:60%;display:inline-block;background-color:black; color:white" class="btn btn-default" name = 				"new">
                	New quiz <span style = "font-size:10px;" class ="glyphicon glyphicon-star" aria-hidden="true"></span>
            		</button>
		</p>
		</form>

		<form action = "menu_page.php" method = "post">
		<p align = "center">
			<button type = "submit" style="width:60%;display:inline-block;background-color:black; color:white" class="btn btn-default" name = "back">
                	Back   <span style = "font-size:10px;" class ="glyphicon glyphicon-align-center" aria-hidden="true"></span>
            		</button>
		</form>
		</p>

            	<p align= "center">
            			<label style = "width:100%">&nbsp</label>
            			<label style = "width:100%">&nbsp</label>
            			&#9400; 2019 JDK Group. All rights reserved
            	</p>
        		</div>
    		</div>
    	</div>
  </body>
</html>
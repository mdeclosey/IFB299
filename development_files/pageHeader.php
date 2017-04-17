<!DOCTYPE html>
<html>
	<head>
		<title>David's Houses</title>
		
		<!-- Imported styles -->
		<?php
			if ($_SERVER['PHP_SELF'] == '/login.php') { echo '<link rel="stylesheet" href="_CSS/login.css">'; }
		?>
		<link rel="stylesheet" href="_CSS/project.css">
	   
		<!-- Bootstrap CDN -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script type="language/javascript src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		
		<!-- jQuery CDN -->
		<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
	</head>
	<body>
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
			<div class="navbar-header">
			  <a class="navbar-brand" href="#">David's Houses</a>
			</div>
			<ul class="nav navbar-nav">
			  <li><a href="home.php">Home</a></li>
			  <li><a href="tenants.php">Tenants</a></li>
			  <li><a href="staff.php">Staff</a></li>
			  <li><a href="contracts.php">Contracts</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
			  <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			  <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			</ul>
		  </div>
		</nav>
	
		<div id="content">
			
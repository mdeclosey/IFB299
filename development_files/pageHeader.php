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
				<?php
					$navBarItems = [
						[
							'name' => 'Home',
							'url' => 'home.php'
						],
						[
							'name' => 'Tenants',
							'url' => 'tenants.php'
						],
						[
							'name' => 'Staff',
							'url' => 'staff.php'
						],
						[
							'name' => 'Owners',
							'url' => 'owners.php'
						],
						[
							'name' => 'Contracts',
							'url' => 'contracts.php'
						],
						[
							'name' => 'Properties',
							'url' => 'properties.php'
						]
					];
					
					$navBarQuickLinks = [
						[
							'name' => 'Sign Up',
							'url' => 'register.php',
							'icon' => 'glyphicon glyphicon-user'
						],
						[
							'name' => 'Login',
							'url' => 'login.php',
							'icon' => 'glyphicon glyphicon-log-in'
						],
						[
							'name' => 'Contact',
							'url' => 'contact',
							'icon' => 'glyphicon glyphicon-pencil'
						],
						
					];
					
					/* Print the features list navbar */
					echo '<ul class="nav navbar-nav">';
					foreach ($navBarItems as $nbItem) {
						if ($_SERVER['SCRIPT_NAME'] == "/{$nbItem['url']}") {
							echo '<li class="active">';
						} else {
							echo '<li>';
						}
						echo "<a href=\"{$nbItem['url']}\">{$nbItem['name']}</a></li>";
					}
					echo '</ul>';
					
					/* Print the auth list navbar (this one has icons) */
					echo '<ul class="nav navbar-nav navbar-right">';
					foreach ($navBarQuickLinks as $nbItem) {
						if ($_SERVER['SCRIPT_NAME'] == "/{$nbItem['url']}") {
							echo '<li class="active">';
						} else {
							echo '<li>';
						}
						echo "<a href=\"{$nbItem['url']}\"><span class=\"{$nbItem['icon']}\"></span> {$nbItem['name']}</a></li>";
					}
					echo '</ul>';
				?>
		  </div>
		</nav>
	
		<div id="content">
			
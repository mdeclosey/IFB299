<!DOCTYPE html>
<html>
	<head>
		<title>David's Houses</title>
		
		<!-- Imported styles -->
		<?php
			if ($_SERVER['PHP_SELF'] == '/login.php') { echo '<link rel="stylesheet" href="_CSS/login.css">'; }
		?>
		<link rel="stylesheet" href="_CSS/project.css">
		<link href="https://fonts.googleapis.com/css?family=Quicksand" rel="stylesheet">
	   
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
							'url' => 'tenants.php',
							'user_type' => [
								'david',
								'staff'
							]
						],
						[
							'name' => 'Staff',
							'url' => 'staff.php',
							'user_type' => [
								'david'
							]
						],
						[
							'name' => 'Owners',
							'url' => 'owners.php',
							'user_type' => [
								'david'
							]
						],
						[
							'name' => 'Contracts',
							'url' => 'contracts.php',
							'user_type' => [
								'david',
								'staff'
							]
						],
						[
							'name' => 'Properties',
							'url' => 'properties.php',
							'user_type' => [
								'david',
								'staff'
							]
						],
						[
							'name' => 'Viewing Times',
							'url' => 'propertyViews.php',
							'user_type' => [
								'david',
								'staff'
							]
						],
						[
							'name' => 'Inspection',
							'url' => 'inspection.php',
							'user_type' => [
								'david',
								'staff',
								'tenant'
							]
						],
						[
							'name' => 'Contact Us',
							'url' => 'contact.php'
						]
					];
					
					$navBarQuickLinks = [
						[
							'name' => 'Sign Up',
							'url' => 'register.php',
							'icon' => 'glyphicon glyphicon-user',
							'hideWhenAuthed' => true
						],
						[
							'name' => 'Login',
							'url' => 'login.php',
							'icon' => 'glyphicon glyphicon-log-in',
							'hideWhenAuthed' => true
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
						if (isset($nbItem['user_type']) && isset($_SESSION['user_type']) && in_array($_SESSION['user_type'], $nbItem['user_type']) || !isset($nbItem['user_type'])) {
							if ($_SERVER['SCRIPT_NAME'] == "/{$nbItem['url']}") {
								echo '<li class="active">';
							} else {
								echo '<li>';
							}
							echo "<a href=\"{$nbItem['url']}\">{$nbItem['name']}</a></li>";
						}
					}
					echo '</ul>';
					
					/* Print the auth list navbar (this one has icons) */
					echo '<ul class="nav navbar-nav navbar-right">';
					foreach ($navBarQuickLinks as $nbItem) {
						if (isset($nbItem['hideWhenAuthed']) && !isset($_SESSION['user_type'])) {
							if ($_SERVER['SCRIPT_NAME'] == "/{$nbItem['url']}") {
								echo '<li class="active">';
							} else {
								echo '<li>';
							}
							echo "<a href=\"{$nbItem['url']}\"><span class=\"{$nbItem['icon']}\"></span> {$nbItem['name']}</a></li>";
						}
					}
					
					/* Print the logout button */
					if (isset($_SESSION['user_type'])) {
						echo '<li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>';
					}
					
					echo '</ul>';
				?>
		  </div>
		</nav>
	
		<div id="content">
			

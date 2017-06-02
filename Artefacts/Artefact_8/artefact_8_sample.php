<?php
	/** The array below is the structure of the navigation bar which appears at the top of every page.
	 * The user_type key holds the user type flags which are allowed to access that particular navigation tab.
	 * For example: the Staff (staff.php) only appears to user_type 'david', whilst Contracts (contracts.php)
	 * 	only appears to 'david' and 'staff'
	 */

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
				'staff',
				'owner'
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
				'staff'
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
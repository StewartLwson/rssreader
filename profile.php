<?php
require_once 'core/init.php';
$user = new User();
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>RSS Reader</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="js/profile_script.js"></script>
	<link href="css/style.css" rel="stylesheet">
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
<div class="container-fluid">
	<a class="navbar-brand" href="index.php">RSS Reader</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="navbarResponsive">
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href="index.php">Feed</a>
			</li>
			<?php if($user->isLoggedIn()) { ?>
			<li class="nav-item active">
				<a class="nav-link" href="profile.php">Profile</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="logout.php">Logout</a>
			</li>
			<?php } else { ?>
			<li class="nav-item">
				<a class="nav-link" href="login.php">Login</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="register.php">Register</a>
			</li>
			<?php } ?>
		</ul>
	</div>
</div>
</nav>

<?php if($user->isLoggedIn()) { ?>
<!-- Welcome -->
<div class="container-fluid padding">
<div class="row welcome text-center">
	<div class="col-12">
		<h1 class="display-4"><?php echo escape($user->data()->username);?>'s Profile</h1>
	</div>
	<hr>
</div>
</div>

<!-- Main Feed -->
<div class="container-fluid padding">
<div class="row text-center padding">
	<div id="feed" class="col-12">
		<h4>Your Current Sources</h4>
		<p>These are the RSS sources that will appear on your feed on the main <a href="index.php">Feed</a> page. If you would like to remove one, click on it and press the remove button.</p>
		<div id="feed_list">
		</div>
		<form action="" method="post">
			<input id="remove_source" type="submit" value="Remove">
		</form>
	</div>
	<div id="feed" class="col-12">
	    <h4>Add New Source to your Feed</h4>
		<p>Copy and paste the link to an RSS source and enter it into the box below to add it to your feed</p>
		<form action="" method="post">
			<div class="field">
				<label for="new_feed">Feed Link</label>
				<input type="text" name="new_feed_link" id="link" autocomplete="off">
			<input id="add_source" type="submit" value="Add">
		</form>
	</div>
	</div>
<hr class="my-4">
</div>
<?php } else { ?>
<div class="container-fluid padding">
<div class="row welcome text-center">
	<div class="col-12">
		<h1 class="display-4">Sorry, you must be logged in to do that...</p>
	</div>
	<hr>
	<div class="col-12">
		<p>You can either <a href="login.php">Login</a> or <a href="register.php">Create a Profile</a>.</p>
	</div>
</div>
</div>
<?php } ?>
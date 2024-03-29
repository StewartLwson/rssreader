<?php
require_once 'core/init.php';
if(Session::exists("home")) {
    echo '<p>' . Session::flash("home") . '</p>';
}

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
	<script src="js/feed_script.js"></script>
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
				<a class="nav-link active" href="index.php">Feed</a>
			</li>
			<?php if($user->isLoggedIn()) { ?>
			<li class="nav-item">
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
		<h1 class="display-4">Hello, <?php echo escape($user->data()->username);?></h1>
	</div>
	<hr>
	<div class="col-12">
		<p class="lead">Welcome to your RSS feed.</p>
		<p>If you would like to add a new source to your feed, you can do so on your <a href="profile.php">Profile</a>.</p>
		<button type="button" id="get_feed">Get Feed!</button>
	</div>
</div>
</div>

<!-- Main Feed -->
<div class="container-fluid padding">
<div class="row text-center padding">
	<div id="feed" class="col-12">
<hr class="my-4">
</div>

<?php } else { ?>
<div class="container-fluid padding">
<div class="row welcome text-center">
	<div class="col-12">
		<h1 class="display-4">Hello!</p>
	</div>
	<hr>
	<div class="col-12">
		<p class="lead">Welcome to the RSS Reader. In order to use the reader, you must have an account.</p>
		<p>You can either <a href="login.php">Login</a> or <a href="register.php">Create a Profile</a>.</p>
	</div>
</div>
</div>
<?php } ?>

</body>

</html>
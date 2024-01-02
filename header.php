<?php
	$filepath = realpath(dirname(__FILE__));
	include_once $filepath.'/inc/Session.php';
	Session::init();
?>

<?php
	if (isset($_GET['action']) && $_GET['action'] == 'logout') {
		Session::destroy();
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Registration System</title>

	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<script src="assets/js/jquery.min.css"></script>
	<script src="assets/js/bootstrap.min.css"></script>
</head>
<body>
<div class="container">
<div class="bg-light border">
	<nav class="navbar navbar-expand-lg navbar-light">
	  <div class="container-fluid">
		<a class="navbar-brand" href="#">Login Register</a>
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarText">
			<ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-right">
				<?php
					$id = Session::get('id');
					$userlogin = Session::get('login');
					if ($userlogin == true) { ?> 
						<li class="nav-item">
							<a class="nav-link" href="index.php">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="profile.php?id=<?php echo $id; ?>">Profile</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="?action=logout">Logout</a>
						</li>
					<?php }else { ?> 
						<li class="nav-item">
							<a class="nav-link" href="login.php">Login</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="register.php">Register</a>
						</li>
					<?php }
				?>
			</ul>
		</div>
	  </div>
	</nav>
</div>
</div>
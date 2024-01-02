<?php 
	include 'header.php'; 
	include 'inc/User.php'; 
	Session::checkLogin();

	$user = new User();
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
		$userLogin = $user->userLogin($_POST);
	}

?>

<div class="mt-4 mb-4">
<div class="container">
<div class="card">
	<div class="panel-heading border bg-light p-4 pt-3 pb-2"><h3>User Login</h3></div>
	<div class="card-body p-5">
		<?php
			if (isset($userLogin)) {
				echo $userLogin;
			}
		?>
		<form action="" method="POST">
			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input id="email" type="email" name="email" class="form-control">
			</div>
			<div class="mb-3">
				<label for="pass" class="form-label">Password</label>
				<input id="pass" type="text" name="password" class="form-control">
			</div>
			<button type="submit" name="login" class="btn btn-primary">Login</button>
		</form>
	</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
<?php 
	include 'header.php'; 
	include 'inc/User.php'; 
	Session::checkLogin();

	$user = new User();
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
		$userReg = $user->userRegistration($_POST);
	}

?>

<div class="mt-4 mb-4">
<div class="container">
<div class="card">
	<div class="panel-heading border bg-light p-3 pt-4 pb-2"><h3>User Registration</h3></div>
	<div class="card-body p-5">

		<?php
			if (isset($userReg)) {
				echo $userReg;
			}
		?>

		<form action="" method="POST">
			<div class="mb-3">
				<label for="name" class="form-label">Name</label>
				<input id="name" type="name" name="name" class="form-control">
			</div>
			<div class="mb-3">
				<label for="username" class="form-label">User Name</label>
				<input id="username" type="username" name="username" class="form-control">
			</div>
			<div class="mb-3">
				<label for="email" class="form-label">Email</label>
				<input id="email" type="email" name="email" class="form-control">
			</div>
			<div class="mb-3">
				<label for="pass" class="form-label">Password</label>
				<input id="pass" type="text" name="password" class="form-control">
			</div>
			<button type="submit" name="register" class="btn btn-primary">Submit</button>
		</form>
	</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
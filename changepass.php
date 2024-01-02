<?php 
	include 'header.php'; 
	include 'inc/User.php'; 
	Session::checkSession();

	if (isset($_GET['id'])) {
		$userid = (int)$_GET['id'];
		$usesId = Session::get('id');
		if ($userid != $usesId) {
			header("Location: index.php");
		}
	}
	$user = new User();
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changepass'])) {
		$updatePassword = $user->updatePassword($userid, $_POST);
	}
?>

<div class="mt-4 mb-4">
<div class="container">
<?php
	if (isset($updatePassword)) {
		echo $updatePassword;
	}
?>
<div class="card">
	<div class="panel-heading border bg-light p-4 pt-3 pb-3">
		<h3 class="mb-0">Change Password <a class="btn btn-primary float-end" href="profile.php?id=<?php echo $userid; ?>">Back</a></h3>
	</div>
	<div class="card-body p-5">
		<form action="" method="POST">
			<div class="mb-3">
				<label for="old_pass" class="form-label">Old Password</label>
				<input id="old_pass" type="password" name="old_pass" class="form-control">
			</div>
			<div class="mb-3">
				<label for="password" class="form-label">New Password</label>
				<input id="password" type="password" name="password" class="form-control">
			</div>
			<button type="submit" name="changepass" class="btn btn-primary">Update Password</button>
		</form>
	</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
<?php 
	include 'header.php'; 
	include 'inc/User.php'; 
	Session::checkSession();

	if (isset($_GET['id'])) {
		$userid = (int)$_GET['id'];
	}
	$user = new User();
	if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
		$updateUserData = $user->updateUserData($userid, $_POST);
	}
?>

<div class="mt-4 mb-4">
<div class="container">
<?php
	if (isset($updateUserData)) {
		echo $updateUserData;
	}
?>
<div class="card">
	<div class="panel-heading border bg-light p-4 pt-3 pb-3">
		<h3 class="mb-0">User Profile <a class="btn btn-primary float-end" href="index.php">Back</a></h3>
	</div>
	<div class="card-body p-5">
		<?php
			$userdata = $user->getUserById($userid);
			if ($userdata) { ?>
				<form action="" method="POST">
					<div class="mb-3">
						<label for="name" class="form-label">Name</label>
						<input id="name" type="name" name="name" class="form-control" value="<?php echo $userdata->name; ?>">
					</div>
					<div class="mb-3">
						<label for="username" class="form-label">User Name</label>
						<input id="username" type="username" name="username" class="form-control" value="<?php echo $userdata->username; ?>">
					</div>
					<div class="mb-3">
						<label for="email" class="form-label">Email</label>
						<input id="email" type="email" name="email" class="form-control" value="<?php echo $userdata->email; ?>">
					</div>
					<?php
						$sesId = Session::get('id');
						if ($userid == $sesId) { ?>
							<button type="submit" name="update" class="btn btn-success">Update</button>
							<a class="btn btn-primary" href="changepass.php?id=<?php echo $id; ?>">Change Password</a>
						<?php }
					?>
					
				</form>
			<?php }
		?>
	</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
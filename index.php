<?php 
	include 'header.php';
	include 'inc/User.php';
	Session::checkSession();
	$user = new User();
?>

<div class="user-panel mt-4 mb-4">
<div class="container">
	<?php
		$loginmsg = Session::get("loginmsg");
		if (isset($loginmsg)) {
			echo $loginmsg;
		}
		Session::set("loginmsg", NULL);
	?>
	<div class="card">
	<div class="panel-heading border bg-light p-4 pt-3 pb-2"><h3>
		Welcome !! 
		<?php
			$name = Session::get("username");
			if (isset($name)) {
				echo $name;
			}
		?>
	</h3></div>
	<div class="card-body p-0">
		<table class="table table-bordered mb-0">
			<thead>
				<tr>
					<th scope="col">Serial</th>
					<th scope="col">Name</th>
					<th scope="col">Username</th>
					<th scope="col">Email</th>
					<th scope="col">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$userdata = $user->getUserData();
					if ($userdata) {
						$i = 0;
						foreach ($userdata as $data) { 
						$i++;
						?>
							<tr>
								<th><?php echo $i; ?></th>
								<td><?php echo $data['name'] ?></td>
								<td><?php echo $data['username'] ?></td>
								<td><?php echo $data['email'] ?></td>
								<td>
									<a class="btn btn-primary" href="profile.php?id=<?php echo $data['id'] ?>">View</a>
								</td>
							</tr>
						<?php }
					}else { ?>
						<tr>
							<td colspan="5">Table data not Found</td>
						</tr>
					<?php }
				?>
			</tbody>
		</table>
	</div>
</div>
</div>
</div>

<?php include 'footer.php'; ?>
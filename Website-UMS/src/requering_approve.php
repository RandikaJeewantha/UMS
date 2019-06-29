<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: index.php?err=cannot-access');
	}

	$user_list = '';

	$query = "SELECT * FROM pendings ORDER BY user_type";
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {
		$user_list .= "<tr>";
		$user_list .= "<td>{$user['user_type']}</td>";
		$user_list .= "<td>{$user['first_name']}</td>";
		$user_list .= "<td>{$user['last_name']}</td>";
		$user_list .= "<td>{$user['email']}</td>";
		$user_list .= "<td><a href=\"Approve.php?email={$user['email']}\">Approve</a></td>";
		$user_list .= "</tr>";
	}

	$user_delete_re_list = '';

	$query_2 = "SELECT * FROM user WHERE require_delete_account = 1 ORDER BY user_type";
	$users_2 = mysqli_query($connection, $query_2);

	verify_query($users_2);

	while ($ur = mysqli_fetch_assoc($users_2)) {
		$user_delete_re_list .= "<tr>";
		$user_delete_re_list .= "<td>{$ur['user_type']}</td>";
		$user_delete_re_list .= "<td>{$ur['first_name']}</td>";
		$user_delete_re_list .= "<td>{$ur['last_name']}</td>";
		$user_delete_re_list .= "<td>{$ur['email']}</td>";
		$user_delete_re_list .= "<td><a href=\"delete.php?id={$ur['id']}\">Approve</a></td>";
		$user_delete_re_list .= "</tr>";
	}

 ?>

<!DOCTYPE html>
<html lang="en">
	
	<head>

		<meta charset="utf-8">
		<title>Requestings</title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/requering_approve.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
	
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header> 

		<main>
			<h2><< <a href="users.php"> Back</a></h2>
			<h3>Account Activation Requestings</h3>

			<table class="masterlist">
				<tr>
					<th>User Type</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Approve</th>
				</tr>

				<?php echo $user_list; ?>

			</table><br><br>

			<h3>Account Deletion Requestings</h3>

			<table class="masterlist">
				<tr>
					<th>User Type</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th>Approve</th>
				</tr>

				<?php echo $user_delete_re_list; ?>

			</table><br><br>

		</main>
	
	</body>

</html>
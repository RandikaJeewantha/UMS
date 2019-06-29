<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: index.php?err=cannot-access');
	}

	$user_list = '';

	$query = "SELECT * FROM user WHERE is_deleted=1 ORDER BY user_type";
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {
		$user_list .= "<tr>";
		$user_list .= "<td>{$user['user_type']}</td>";
		$user_list .= "<td>{$user['first_name']}</td>";
		$user_list .= "<td>{$user['last_name']}</td>";
		$user_list .= "<td>{$user['last_login']}</td>";
		$user_list .= "<td><a href=\"restoreUser.php?user_id={$user['id']}\">Restore</a></td>";
		$user_list .= "</tr>";
	}
 ?>

<!DOCTYPE html>
<html lang="en">
	
	<head>

		<meta charset="utf-8">
		<title>Users</title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/tempDeletedUser.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
	
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header> 

		<main>
			<h2><< <a href="users.php"> Back</a></h2>
			<h1>Deleted Users</h1>

			<table class="masterlist">
				<tr>
					<th>User Type</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Last Login</th>
					<th>Restore</th>
				</tr>

				<?php echo $user_list; ?>

			</table><br><br>

		</main>
	
	</body>

</html>
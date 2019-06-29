<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: index.php?err=cannot-access');
	}

	$user_list = '';

	$query = "SELECT * FROM user WHERE is_deleted=0 ORDER BY user_type";
	$users = mysqli_query($connection, $query);

	verify_query($users);

	while ($user = mysqli_fetch_assoc($users)) {
		$user_list .= "<tr>";
		$user_list .= "<td>{$user['user_type']}</td>";
		$user_list .= "<td>{$user['first_name']}</td>";
		$user_list .= "<td>{$user['last_name']}</td>";
		$user_list .= "<td>{$user['last_login']}</td>";
		$user_list .= "<td><a href=\"modifyUser.php?user_id={$user['id']}\">Edit</a></td>";
		$user_list .= "<td><a href=\"deleteUser.php?user_id={$user['id']}\">Delete</a></td>";
		$user_list .= "</tr>";
	}
 ?>

<!DOCTYPE html>
<html lang="en">
	
	<head>

		<meta charset="utf-8">
		<title>Users</title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/users.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
	
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header> 

		<main>
			<h2><< <a href="home.php"> Back</a></h2>
			<h1>Users <span><a href="addUser.php">+ Add New</a></span></h1>

			<table class="masterlist">
				<tr>
					<th>User Type</th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Last Login</th>
					<th>Edit</th>
					<th>Delete</th>
				</tr>

				<?php echo $user_list; ?>

			</table><br><br>

			<span id="request"> <a href="requering_approve.php">Requestings >> </a> </span>
			<span id="delete"> <a href="tempDeletedUser.php">Deleted Users >> </a> </span>
			

		</main>
	
	</body>

</html>
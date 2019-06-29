<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: index.php?err=cannot-access');
	}

	$errors = array();

	$user_type = '';
	$email = '';
	$first_Name = '';
	$last_Name = '';
	$password = '';
	$result = false;

	if (isset($_GET['email'])) {
		$email = mysqli_real_escape_string($connection, $_GET['email']);
		$query = "SELECT * FROM pendings WHERE email = '{$email}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {

			if (mysqli_num_rows($result_set) == 1) {
				$result = mysqli_fetch_assoc($result_set);
				$user_type = $result['user_type'];
				$email = $result['email'];
				$first_Name = $result['first_name'];
				$last_Name = $result['last_name'];
				$password = $result['password'];
			}
			else {
				header('Location: requering_approve.php?err=user-not-found');
			}
		}
		else {
			header('Location: requering_approv.php?err=query-failed');
		}

		$query = "SELECT email FROM user WHERE email = '{$email}' LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				header('Location: requering_approve.php?err=email');
			}
		}

		$query = "INSERT INTO user ( user_type, first_name, last_name, email, password, is_deleted ) VALUES ( '{$user_type}', '{$first_Name}', '{$last_Name}', '{$email}', '{$password}', 0 )";

		$result = mysqli_query($connection, $query);

		if ($result) {

			$query = "DELETE FROM pendings WHERE email = '{$email}' LIMIT 1";
			$result = mysqli_query($connection, $query);
		
			if ($result) {
				header('Location: users.php?user_added=true');
			}
			else {
				header('Location: requering_approve.php?err=delete');
			}
		}
		else {
			header('Location: requering_approve.php?err=add');
		}
	}
	else {
		header('Location: requering_approve.php?err=get');
	}
?> 

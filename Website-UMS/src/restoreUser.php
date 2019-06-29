<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: index.php?err=cannot-access');
	}

	if (isset($_GET['user_id'])) {
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);

		
		$query = "UPDATE user SET is_deleted = 0 WHERE id = {$user_id} LIMIT 1";

		$result = mysqli_query($connection, $query);

		if ($result) {
			header('Location: users.php?msg=user-restore');
		}

		else {
				header('Location: tempDeleteduser.php?err=restore-failed');
		}
	}

	else {
		header('Location: tempDeleteduser.phhp');
	}
?> 
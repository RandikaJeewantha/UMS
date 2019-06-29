<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: index.php?err=cannot-access');
	}

	if (isset($_GET['user_id'])) {
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);

		if ($user_id == $_SESSION['user_id']) {
			header('Location: users.php?err=cannot-delete-current-user');
		}

		else {
			$query = "UPDATE user SET is_deleted = 1 WHERE id = {$user_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				header('Location: tempDeletedUser.php?msg=user-deleted');
			}

			else {
				header('Location: users.php?err=delete-failed');
			}
		}
	}

	else {
		header('Location: users.phhp');
	}
?> 
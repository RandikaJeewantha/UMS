<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: index.php?err=cannot-access');
	}

	$errors = array();

	$user_type = '';
	$user_id = '';
	$user_Name = '';
	$first_Name = '';
	$last_Name = '';
	$result = false;
	$requirest_delete = 0;

	if (isset($_GET['user_id'])) {
		$user_id = mysqli_real_escape_string($connection, $_GET['user_id']);
		$query = "SELECT * FROM user WHERE id = {$user_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$result = mysqli_fetch_assoc($result_set);
				$user_type = $result['user_type'];
				$user_Name = $result['email'];
				$first_Name = $result['first_name'];
				$last_Name = $result['last_name'];
				$requirest_delete = $result['require_delete_account'];
			}

			else {
				header('Location: users.php?err=user-not-found');
			}
		}

		else {
			header('Location: users.php?err=query-failed');
		}

	}
	else {
		
		$user_id = mysqli_real_escape_string($connection, $_SESSION['user_id']);
		$query = "SELECT * FROM user WHERE id = {$user_id} LIMIT 1";

		$result_set = mysqli_query($connection, $query);

		$result = mysqli_fetch_assoc($result_set);
				
		$user_type = $result['user_type'];
		$user_Name = $result['email'];
		$first_Name = $result['first_name'];
		$last_Name = $result['last_name'];
		$password = $result['password'];
		$requirest_delete = $result['require_delete_account'];
	}

	if (isset($_POST['submit'])) {

		$user_id = $_POST['user_id'];
		$user_type = $_POST['user_type'];
		$user_Name = $_POST['user_Name'];
		$first_Name = $_POST['first_Name'];
		$last_Name = $_POST['last_Name'];
		
		$req_fields = array('user_type', 'user_id', 'user_Name', 'first_Name', 'last_Name');
		$errors = array_merge($errors, check_req_fields($req_fields));

		$max_len_fields = array('user_Name' => 100, 'first_Name' => 50, 'last_Name' => 100);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		$email = mysqli_real_escape_string($connection, $_POST['user_Name']);
		$query = "SELECT * FROM user WHERE email = '{$email}' AND id != {$user_id} LIMIT 1"; 

		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			if (mysqli_num_rows($result_set) == 1) {
				$errors[] = 'Email address already exists';
			}
		}

		if (empty($errors)) {
			$user_type = mysqli_real_escape_string($connection, $_POST['user_type']);
			$first_Name = mysqli_real_escape_string($connection, $_POST['first_Name']);
			$last_Name = mysqli_real_escape_string($connection, $_POST['last_Name']);

			$query = "UPDATE user SET user_type = '{$user_type}', first_name = '{$first_Name}', last_name = '{$last_Name}', email = '{$email}' WHERE id = {$user_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				header('Location: users.php?user_modified=true');
			}

			if (!$result) {
				$errors[] = 'Failed to Modify the new records.';
			}
		}
	}

	if (isset($_POST['delete'])) {
		$query = "UPDATE user SET require_delete_account = 1 WHERE id = {$user_id} LIMIT 1";

		$result = mysqli_query($connection, $query);

		if ($result) {
			header('Location: modifyUser.php');
		}

		if (!$result) {
			$errors[] = 'Failed to Delete Account.';
		}
	}

	if (isset($_POST['cansel'])) {
		$query = "UPDATE user SET require_delete_account = 0 WHERE id = {$user_id} LIMIT 1";

		$result = mysqli_query($connection, $query);

		if ($result) {
			header('Location: modifyUser.php');
		}

		if (!$result) {
			$errors[] = 'Failed to Cansel Requrest.';
		}
	}

?> 

<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/modifyUser.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
	
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header>

		<main>

			<h2><< <a href="users.php"> Back</a></h2>

			<h1>Modifying Users</h1>

			<p>
				<?php 

					if (!empty($errors)) {
						foreach ($errors as $error) {
							$error = ucfirst(str_replace("_", " ", $error));
							echo "<< &nbsp;&nbsp;".$error."&nbsp;&nbsp; >><br>";
						}
					}
				?>
			</p><br>

			<form action="modifyUser.php" method="POST">

				<input type="hidden" name="user_id" value=" <?php echo $user_id; ?> ">

				<select name="user_type">
					<option value="">User Type</option>
					<option value="Librarian" <?php if ($user_type == "Librarian") { echo "selected"; } ?> >Librarian</option>
					<option value="Teacher" <?php if ($user_type == "Teacher") { echo "selected"; } ?> >Teacher</option>
					<option value="Student" <?php if ($user_type == "Student") { echo "selected"; } ?> >Student</option>
					<option value="Book Keeper" <?php if ($user_type == "Book Keeper") { echo "selected"; } ?> >Book Keeper</option>
				</select><br><br><br>
				
				<input type="email" name="user_Name" placeholder="User Name  >>  Email" <?php echo 'value="'.$user_Name.'"'; ?>><br><br><br>
				<input type="name" name="first_Name" placeholder="First Name" <?php echo 'value="'.$first_Name.'"'; ?>><br><br><br>
				<input type="name" name="last_Name" placeholder="Last Name" <?php echo 'value="'.$last_Name.'"'; ?>><br><br><br>

				<button type="submit" name="submit">Modify</button><br><br><br>
				<button type="submit" name="reset">Reset</button><br><br><br>

				<?php 
					if ($requirest_delete == 0) {
						echo '<button type="submit" name="delete">Delete Account</button><br><br><br>';
					} 
				?>

				<?php 
					if ($requirest_delete == 1) {
						echo '<button type="submit" name="cansel">Cansel Account Deletion Requrest</button>';
					} 
				?>

			</form>

		</main>

	</body>

</html>

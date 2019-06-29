<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!isset($_SESSION['user_id'])) {
		header('Location: index.php');
	}

	$errors = array();

	$user_type = '';
	$user_id = '';
	$user_Name = '';
	$first_Name = '';
	$last_Name = '';
	$password = '';
	$result = false;
	$requirest_delete = 0;

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

	if (isset($_POST['submit'])) {

		$user_id = $_SESSION['user_id'];
		$password = $_POST['password'];
		
		$req_fields = array('password');
		$errors = array_merge($errors, check_req_fields($req_fields));

		$max_len_fields = array('password' => 40);
		$errors = array_merge($errors, check_max_len($max_len_fields));

		if (empty($errors)) {

			$password = mysqli_real_escape_string($connection, $_POST['password']);

			$hashed_password = sha1($password);

			$query = "UPDATE user SET password = '{$hashed_password}' WHERE id = {$user_id} LIMIT 1";

			$result = mysqli_query($connection, $query);

			if ($result) {
				header('Location: logOut.php?user-password-modified=true');
			}

			if (!$result) {
				$errors[] = 'Failed to Modify the Password';
			}
		}
	}

	if (isset($_POST['delete'])) {
		$query = "UPDATE user SET require_delete_account = 1 WHERE id = {$user_id} LIMIT 1";

		$result = mysqli_query($connection, $query);

		if ($result) {
			header('Location: userPassword.php');
		}

		if (!$result) {
			$errors[] = 'Failed to Delete Account.';
		}
	}

	if (isset($_POST['cansel'])) {
		$query = "UPDATE user SET require_delete_account = 0 WHERE id = {$user_id} LIMIT 1";

		$result = mysqli_query($connection, $query);

		if ($result) {
			header('Location: userPassword.php');
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
		<link rel="stylesheet" type="text/css" href="../asserts/css/userPassword.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
	
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header>

		<main>

			<h2><< <a href="index.php"> Back</a></h2>

			<h1>Modifying Password</h1>

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

			<form action="userPassword.php" method="POST">

				<input type="hidden" name="user_id" value=" <?php echo $user_id; ?> ">

				<select name="user_type" disabled="true">
					<option value="">User Type</option>
					<option value="Librarian" <?php if ($user_type == "Librarian") { echo "selected"; } ?> >Librarian</option>
					<option value="Teacher" <?php if ($user_type == "Teacher") { echo "selected"; } ?> >Teacher</option>
					<option value="Student" <?php if ($user_type == "Student") { echo "selected"; } ?> >Student</option>
					<option value="Book Keeper" <?php if ($user_type == "Book Keeper") { echo "selected"; } ?> >Book Keeper</option>
				</select><br><br><br>
				
				<input type="email" name="user_Name" placeholder="User Name  >>  Email" <?php echo 'value="'.$user_Name.'"'; ?> disabled="true" ><br><br><br>
				<input type="name" name="first_Name" placeholder="First Name" <?php echo 'value="'.$first_Name.'"'; ?> disabled="true" ><br><br><br>
				<input type="name" name="last_Name" placeholder="Last Name" <?php echo 'value="'.$last_Name.'"'; ?> disabled="true" ><br><br><br>
				<input type="text" name="password" placeholder="Enter New Password" ><br><br><br>

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

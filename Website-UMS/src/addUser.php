<?php session_start(); ?>
<?php require_once('../inc/connection.php'); ?>
<?php require_once('../inc/functions.php') ?>

<?php 

	if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
		header('Location: index.php?err=cannot-access');
	}

	$errors = array();

	$user_type = '';
	$user_Name = '';
	$first_Name = '';
	$last_Name = '';
	$password = '';
	$result = false;

	if (isset($_POST['submit'])) {

		$user_type = $_POST['user_type'];
		$user_Name = $_POST['user_Name'];
		$first_Name = $_POST['first_Name'];
		$last_Name = $_POST['last_Name'];
		$password = $_POST['password'];
		
		$req_fields = array('user_type', 'user_Name', 'first_Name', 'last_Name', 'password');
		$errors = array_merge($errors, check_req_fields($req_fields));

		$max_len_fields = array('user_Name' => 100, 'first_Name' => 50, 'last_Name' => 100, 'password' => 40);
		$errors = array_merge($errors, check_max_len($max_len_fields));


		$email = mysqli_real_escape_string($connection, $_POST['user_Name']);
		$query = "SELECT * FROM user WHERE email = '{$email}' LIMIT 1";

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
			$password = mysqli_real_escape_string($connection, $_POST['password']);

			$hashed_password = sha1($password);

			$query = "INSERT INTO user ( user_type, first_name, last_name, email, password, is_deleted ) VALUES ( '{$user_type}', '{$first_Name}', '{$last_Name}', '{$email}', '{$hashed_password}', 0 )";

			$result = mysqli_query($connection, $query);

			if ($result) {
				header('Location: users.php?user_added=true');
			}

			if (!$result) {
				$errors[] = 'Failed to add the new record.';
			}
		}
	}
?> 

<!DOCTYPE html>
<html lang="en">

	<head>

		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" type="text/css" href="../asserts/css/addUser.css">
		<link rel="stylesheet" type="text/css" href="../asserts/css/common.css">
	
	</head>

	<body>

		<header>

			<?php topbar(); ?>
		
		</header>

		<main>

			<h2><< <a href="users.php"> Back</a></h2>

			<h1>Adding Users</h1>

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

			<form action="addUser.php" method="POST">

				<select name="user_type">
					<option value="">User Type</option>
					<option value="Librarian">Librarian</option>
					<option value="Teacher">Teacher</option>
					<option value="Student">Student</option>
					<option value="Book Keeper">Book Keeper</option>
				</select><br><br><br>
				
				<input type="email" name="user_Name" placeholder="User Name  >>  Email" <?php echo 'value="'.$user_Name.'"'; ?>><br><br><br>
				<input type="name" name="first_Name" placeholder="First Name" <?php echo 'value="'.$first_Name.'"'; ?>><br><br><br>
				<input type="name" name="last_Name" placeholder="Last Name" <?php echo 'value="'.$last_Name.'"'; ?>><br><br><br>
				<input type="text" name="password" placeholder="Password" ><br><br><br>

				<button type="submit" name="submit">Add</button><br><br><br>
				<button type="submit" name="reset">Reset</button>

			</form>

		</main>

	</body>

</html>

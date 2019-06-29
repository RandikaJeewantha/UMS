<?php session_start(); ?>
<?php require_once('inc/connection.php'); ?>
<?php require_once('inc/functions.php'); ?>

<?php 
	if(isset($_POST['submit'])) {

		$errors = array();

		if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1)  {
			$errors[] = "UserName is Missing / Invalid";
		}

		if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1)  {
			$errors[] = "Password is Missing / Invalid";
		}

		if (empty($errors)) {
			$email = mysqli_real_escape_string($connection, $_POST['email']);
			$password = mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password);

			$query = "SELECT * FROM user WHERE email = '{$email}' AND password = '{$hashed_password}' LIMIT 1";
			$result_set = mysqli_query($connection, $query);

			verify_query($result_set);

			if (mysqli_num_rows($result_set) == 1) {
				$user = mysqli_fetch_assoc($result_set);
				$_SESSION['user_id'] = $user['id'];
				$_SESSION['first_name'] = $user['first_name'];
				$_SESSION['user_type'] = $user['user_type'];

				$query = "UPDATE user SET last_login = NOW()";
				$query .= "WHERE id = {$_SESSION['user_id']} LIMIT 1";

				$result_set = mysqli_query($connection, $query);
				verify_query($result_set);

				if ($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin") {
					header('Location: src/users.php');
				}

				else {
					header('Location: src/userPassword.php');
				}
			}

			else {
				$errors[] = 'Invalid UserName / Password!';
			}
		}
	}	
?>


<!DOCTYPE html>
<html lang="en">
	
	<head>
		<meta charset="utf-8">
		<title>Log In</title>
		<link rel="stylesheet" type="text/css" href="asserts/css/index.css">
	</head>
	
	<body>
		<div class="middle">
			<form action="index.php" method="POST">

				<p class="error">
					<?php 
						if (isset($errors) && !empty($errors)) {
							foreach ($errors as $error) {
								echo "<< ".$error." >>"."<br>";
							}
						}
					?>
				</p>
				
				<h4>Sign into get start... </h4>

				<h3> User Name <input id ="userName" type="email" name="email" placeholder="Email"> </h3>
				<h3> User Password <input id ="password" type="password" name="password" placeholder="Password"> </h3>
				<button id ="signBtn" type="submit" name="submit">Sign in</button>
			</form>
			
		</div>

		<div id="register">
			<a id="link" href="src/register.php">
				<div id="button-div">
					<div id="button_text">
						Register or Signup
					</div>
				</div>
			</a>
		</div>

	</body>

</html>

<?php mysqli_close($connection); ?>

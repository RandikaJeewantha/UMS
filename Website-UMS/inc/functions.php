<?php

	function verify_query($result_set) {

		global $connection;

		if (!$result_set) {

			die("Database query failed!" . mysqli_error($connection));
		}
	}

	function check_req_fields($req_fields) {

		$errors = array();

		foreach ($req_fields as $field) {

			if (empty(trim($_POST[$field]))) {

				$errors[] = $field.' is required.';
			}
		}

		return $errors;
	}

	function check_max_len($max_len_fields) {

		$errors = array();

		foreach ($max_len_fields as $field => $max_len) {

			if (strlen(trim($_POST[$field])) > $max_len) {

				$errors[] = $field.' must be less than '.$max_len.' characters.';
			}
		}

		return $errors;
	}

	function topbar() {

		if (!($_SESSION['user_type'] == "Librarian" || $_SESSION['user_type'] == "Admin")) {
			echo '<div id="date">' .date("l - d . m . Y"). '</div>';
			echo '<div class="loggedin">Welcome &nbsp;&nbsp;&nbsp; <a href="userPassword.php">'.$_SESSION["first_name"].'</a> &nbsp;!&nbsp;&nbsp;&nbsp; <<&nbsp;&nbsp;&nbsp; <a href="logOut.php">Log Out</a> &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../index.php">Home</a>&nbsp;&nbsp;&nbsp;>></div>';
		}

		else {
			echo '<div id="date">' .date("l - d . m . Y"). '</div>';
			echo '<div class="loggedin">Welcome &nbsp;&nbsp;&nbsp; <a href="modifyUser.php">'.$_SESSION["first_name"].'</a> &nbsp;!&nbsp;&nbsp;&nbsp; <<&nbsp;&nbsp;&nbsp; <a href="logOut.php">Log Out</a> &nbsp;&nbsp;&nbsp;||&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="../index.php">Home</a>&nbsp;&nbsp;&nbsp;>></div>';
		}
	}

	function row_count($query) {

		global $connection;
		$num_row = array();
		
		$result_set = mysqli_query($connection, $query);

		if ($result_set) {
			$num_row = mysqli_num_rows($result_set);
		}

		return $num_row;
	}
?>
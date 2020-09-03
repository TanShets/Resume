<!DOCTYPE html>
<html>
<?php
	$error = array(
		"username" => "",
		"password" => "",
		"cpassword" => "",
		"name" => "",
		"email" => "",
		"age" => "",
		"number" => ""
	);
	$no_of_errors = 0;
	session_start();
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$mainServe = "localhost";
		$mainuser = "root";
		$mainpass = "";
		$dbname = "resume_login";
		$hasStarted = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);

		if($hasStarted == NULL || !$hasStarted){
			die("Failed: ".mysqli_connect_error());
		}
		$user1 = mysqli_real_escape_string($hasStarted, $_POST['username']);
		$pass1 = mysqli_real_escape_string($hasStarted, $_POST['password']);
		$cpass1 = mysqli_real_escape_string($hasStarted, $_POST['cpassword']);
		$name1 = mysqli_real_escape_string($hasStarted, $_POST['name']);
		$email1 = mysqli_real_escape_string($hasStarted, $_POST['email']);
		$age1 = mysqli_real_escape_string($hasStarted, $_POST['age']);
		$number1 = mysqli_real_escape_string($hasStarted, $_POST['number']);

		if(isset($_POST['isAdmin'])){
			$isAdmin1 = 1;
		}
		else{
			$isAdmin = 0;
		}
		$cmd1 = "SELECT* FROM users WHERE username = '$user1'";
		$cmd2 = "SELECT* FROM users WHERE email = '$email1'";
		$out_username = mysqli_query($hasStarted, $cmd1);
		$out_email = mysqli_query($hasStarted, $cmd2);

		$vals_username = mysqli_fetch_array($out_username);
		$vals_email = mysqli_fetch_array($out_email);
		$pattern = "[a-Z]";

		if(empty($_POST['username'])){
			$no_of_errors += 1;
			$error['username'] = "Please enter a username";
		}
		elseif(is_array($vals_username)){
			$no_of_errors += 1;
			$error['username'] = "Username already exists, try another one";
		}
		elseif(strlen($user1) < 4){
			$no_of_errors += 1;
			$error['username'] = "Invalid Username";
		}

		if(empty($_POST['email'])){
			$no_of_errors += 1;
			$error['email'] = "Please enter an email";
		}
		elseif(is_array($vals_email)){
			$no_of_errors += 1;
			$error['email'] = "Email already in use, try another one";
		}
		elseif(strlen($email1) < 6 || !filter_var($email1, FILTER_VALIDATE_EMAIL)){
			$error['email'] = "Invalid email";
			$no_of_errors += 1;
		}

		if(empty($_POST['password'])){
			$no_of_errors += 1;
			$error['password'] = "Please enter a password";
		}
		elseif(strlen($pass1) < 6){
			$no_of_errors += 1;
			$error['password'] = "Password too short, Please enter atleast 6 characters.";	
		}

		if(empty($_POST['cpassword'])){
			$no_of_errors += 1;
			$error['cpassword'] = "Please confirm password";
		}
		elseif($cpass1 != $pass1){
			$no_of_errors += 1;
			$error['cpassword'] = "Password and confirmation are not the same";	
		}

		if(empty($_POST['name']) || strlen($name1) < 3){
			$no_of_errors += 1;
			$error['name'] = "Please enter your name";
		}
		elseif(strlen($name1) < 3){
			$no_of_errors += 1;
			$error['name'] = "Name too short";
		}
		elseif(!preg_match("/[a-zA-Z]+/", $name1, $match)){
			$no_of_errors += 1;
			$error['name'] = "Please enter a proper name";
		}

		if(empty($_POST['age']) || $age1 < 15 || $age1 > 99){
			$no_of_errors += 1;
			$error['age'] = "Enter the appropriate age";
		}

		if(empty($_POST['number']) || strlen($number1) != 10){
			$no_of_errors += 1;
			$error['number'] = "Enter the appropriate number";
		}

		if($no_of_errors == 0){
			$cmd = "INSERT INTO Users(username, password, email, age, contact_no, name, isAdmin) VALUES('$user1', '$pass1', '$email1', '$age1', '$number1', '$name1', '$isAdmin1')";
			if($isAdmin1){
				$cmd2 = "INSERT INTO Admin(username) VALUES('$user1')";
				$out2 = mysqli_query($hasStarted, $cmd2);
			}
			else{
				$out2 = 1;
			}
			$out1 = mysqli_query($hasStarted, $cmd);
			if(!$out1 || !$out2){
				echo "ERROR: Could not execute $sql. " . mysqli_error($hasStarted);
			}
			$cmdx = "SELECT* FROM Users WHERE username = '$user1' AND password = '$pass1'";
			$out2 = mysqli_query($hasStarted, $cmdx);
			$new_val = mysqli_fetch_array($out2);

			if(is_array($new_val)){
				$SESSION['account'] = $new_val;
				header("Location: login.php");
				exit();
			}
		}
	}

	function gotoCreate($event){
		header('Location: Create.php');
		exit();
	}
?>
<head>
	<title>Create Account</title>
	<link rel = "stylesheet" type = "text/css" href = "interfacex.css">
</head>
<body>
	<div>
		<form action = "Create.php" method = "post" class = "Create">
			<center><div id = "Title-2">CREATE ACCOUNT</div></center>
			<div class = "details">
				<table>
					<td>Username: </td><td><div id = "tab"><input type="text"name="username" placeholder="Enter Username" class = "input-create"></div></td>
					<tr><td>Password: </td><td><div id = "tab"><input type="password"name="password"placeholder="Enter Password" class = "input-create"></div></td></tr>
					<tr><td>Confirm Password: </td><td><div id = "tab"><input type="password"name="cpassword"placeholder="Confirm Password" class = "input-create"></div></td></tr>
					<tr><td>Name: </td><td><div id = "tab"><input type="text" name="name"placeholder="Enter your name" class = "input-create"></div></td></tr>
					<tr><td>Email: </td><td><div id = "tab"><input type="email" name="email"placeholder="this.example@site.com" class = "input-create"></div></td></tr>
					<tr><td>Age: </td><td><div id = "tab"><input type="number" name="age"placeholder="Age: 15-99" class = "input-create"></div></td></tr>
					<tr><td>Contact No.: </td><td><div id = "tab"><input type="number" name="number"placeholder="Enter your number" class = "input-create"></div></td></tr>
				</table>
				<input type = "checkbox" name = "isAdmin" value = "1"><label for = "isAdmin">Are you an Admin?</label>
				<p></p>
				<button type = "submit" class = "submit" name = "submit">Create Account</button>
			</div>
		</form>
	</div>
	<div class = "Create-2">
		<table id = "gappy">
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['username']; ?></div>
			</div></td></tr>
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['password']; ?></div>
			</div></td></tr>
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['cpassword']; ?></div>
			</div></td></tr>
			<tr><td><div id = "gap">
				<div class="Error"><?php echo $error['name']; ?></div>
			</div></td></tr>
			<tr><td><div id= "gap"></div><div id = "gap">
				<div class="Error"><?php echo $error['email']; ?></div>
			</div></td></tr>
			<tr><td><div id= "gap"></div><div id = "gap">
				<div class="Error"><?php echo $error['age']; ?></div>
			</div></td></tr>
			<tr><td><div id= "gap"></div><div id = "gap">
				<div class="Error"><?php echo $error['number']; ?></div>
			</div></td></tr>
		</table>
	</div>
</body>
</html>
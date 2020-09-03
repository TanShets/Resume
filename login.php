<!DOCTYPE html>
<html>
<?php
	$error = "";
	session_start();
	
	if($_SERVER['REQUEST_METHOD'] == "POST"){
		$mainServe = "localhost";
		$mainuser = "root";
		$mainpass = "";
		$dbname = "resume_login";
		$user1 = $_POST['name'];
		$pass1 = $_POST['password'];
		$hasStarted = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);

		if(!$hasStarted){
			die("Failed: ".mysqli_connect_error());
		}

		$cmd = "SELECT* FROM Users WHERE username = '$user1' AND password = '$pass1'";

		$outcome = mysqli_query($hasStarted, $cmd);

		$vals = mysqli_fetch_array($outcome);
		if(is_array($vals) && isset($_POST['name']) && isset($_POST['password'])){
			//$_SESSION['username'] = $vals['username'];
			//$_SESSION['password'] = $vals['password'];
			$_SESSION['account'] = $vals;
			header("Location: Account.php");
				exit();
		}
		else{
			if(isset($_POST['name']) && isset($_POST['password'])){
				$error = "Incorrect Username or Password.";
			}
			elseif(isset($_POST['name'])){
				$error = "Enter the password first";
			}
			elseif (isset($_POST['password'])) {
				$error = "Enter the username";
			}
		}
	}

	function gotoCreate(){
		header('Location: Create.php');
		exit();
	}
?>
<head>
	<title>Login</title>
	<link rel = "stylesheet" type = "text/css" href = "interfacex.css">
</head>
<body>
	<div class = "Login">
		<form action = "login.php" method = "post" class = "login">
			<center><div id = "Title">LOGIN</div></center>
			<div class = "details">
				<table>
					<td>Username: </td><td><input type="text"name="name" placeholder="Enter Username" class = "input-login"></td>
					<tr><td>Password: </td><td><input type="password"name="password"placeholder="Enter Password" class = "input-login"></td></tr>
				</table>
				<br>
				<div class = "Error"><?php echo "$error"; ?></div>
				<button type = "submit" class = "submit" name = "submit">Login</button>
			</div>
		</form>
		<form id = "goto" action="Create.php">
			<p></p>
			<br>
			<button class = "submit" name = "Create">Create Account</button>
		</form>
	</div>
</body>
</html>
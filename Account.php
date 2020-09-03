<!DOCTYPE html>
<html>
<?php
	session_start();
	$mainServe = "localhost";
	$mainuser = "root";
	$mainpass = "";
	$dbname = "Users";
	$connection = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);
	if(!$connection){
		die("Failed: ".mysqli_connect_error());
	}
?>
<head>
	<title>Welcome</title>
	<link rel = "stylesheet" type = "text/css" href = "interfacex.css">
</head>
<body>
	<div class = "account">
		<div class = "details">
			<table>
				<tr><td>Name: </td><td><?php echo $_SESSION['account']['name']; ?></td></tr>
				<tr><td>Username: </td><td><?php echo $_SESSION['account']['username']; ?></td></tr>
				<tr><td>Email: </td><td><?php echo $_SESSION['account']['email']; ?></td></tr>
				<tr><td>Age: </td><td><?php echo $_SESSION['account']['age']; ?></td></tr>
				<tr><td>Number: </td><td><?php echo $_SESSION['account']['contact_no']; ?></td></tr>
				<tr><td>User Type: </td><td><?php 
				if($_SESSION['account']['isAdmin']){
					echo "Admin";
				}
				else{
					echo "Viewer";
				} ?></td></tr>
			</table>
			<form action = "logout.php">
				<button class = "submit" name = "logout">Logout</button>
			</form>
			<p></p>
			<form action = "view.php">
				<button class = "submit" name = "View">Go to View Page</button>
			</form>
		</div>
	</div>
</body>
</html>

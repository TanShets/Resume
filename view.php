<!DOCTYPE html>
<html>
	<?php
		session_start();
		$mainServe = "localhost";
		$mainuser = "root";
		$mainpass = "";
		$dbname = "resume_login";
		$connection = mysqli_connect($mainServe, $mainuser, $mainpass, $dbname);
		if(!$connection){
			die("Failed: ".mysqli_connect_error());
		}
		$info = array(
			"formtype" => "",
			"adname" => "",
			"username" => "",
			"college" => "",
			"c_board" => "",
			"c_degree" => "",
			"c_cgpa" => "",
			"school" => "",
			"s_board" => "",
			"s_percent" => "",
			"jcollege" => "",
			"jc_board" => "",
			"jc_percent" => "",
			"pcollege" => "",
			"pc_board" => "",
			"pc_degree" => "",
			"pc_cgpa" => "",
			"mname" => "",
			"fname" => "",
			"projects" => "",
			"acourse" => "",
			"age" => "",
			"email" => "",
			"contact_no" => "",
			"j_exp" => "",
			"j_desc" => ""
		);
		$new_val1 = "";
		$temp1 = "";
		$cmd = "SELECT name FROM Users WHERE isAdmin = 1";
		$out = mysqli_query($connection, $cmd);
		if(!$out){
			echo "ERROR: Could not execute $sql. " . mysqli_error($connection);
		}
		$new_val = mysqli_fetch_all($out);
		$_POST['formtype'] = "";
		$isDisabled = "";
		if($_SERVER['REQUEST_METHOD'] == "POST"){
			$info['adname'] = $_POST['adname'];
			$isDisabled = "";
			if(empty($_POST['adname']) || $info['adname'] != $_SESSION['account']['name']){
				$isDisabled = "disabled";
			}
			$info['formtype'] = $_POST['form1'];
			if(!empty($_POST['form1']) && $info['formtype'] == 'adname'){
				$temp = $info['adname'];
				$cmd1 = "SELECT * FROM Users WHERE name = '$temp'";
				$out1 = mysqli_query($connection, $cmd1);
				if(!$out1){
					echo "ERROR: Could not execute $sql. " . mysqli_error($connection);
				}
				$new_val1 = mysqli_fetch_array($out1);
				$info['adname'] = $new_val1['name'];
				$info['username'] = $new_val1['username'];
				$info['age'] = $new_val1['age'];
				$info['email'] = $new_val1['email'];
				$info['contact_no'] = $new_val1['contact_no'];
				$temp1 = $info['username'];
				$cmd2 = "SELECT * FROM Admin WHERE username = '$temp1'";
				$out2 = mysqli_query($connection, $cmd2);
				if(!$out2){
					echo "ERROR: Could not execute $sql. " . mysqli_error($connection);
				}
				$new_val2 = mysqli_fetch_array($out2);
				if(is_array($new_val2)){
					$info['college'] = $new_val2['college'];
					$info['c_board'] = $new_val2['c_board'];
					$info['c_degree'] = $new_val2['c_degree'];
					$info['c_cgpa'] = $new_val2['c_cgpa'];
					$info['school'] = $new_val2['school'];
					$info['s_board'] = $new_val2['s_board'];
					$info['s_percent'] = $new_val2['s_percent'];
					$info['jcollege'] = $new_val2['jcollege'];
					$info['jc_board'] = $new_val2['jc_board'];
					$info['jc_percent'] = $new_val2['jc_percent'];
					$info['pcollege'] = $new_val2['pcollege'];
					$info['pc_board'] = $new_val2['pc_board'];
					$info['pc_degree'] = $new_val2['pc_degree'];
					$info['pc_cgpa'] = $new_val2['pc_cgpa'];
					$info['mname'] = $new_val2['mname'];
					$info['fname'] = $new_val2['fname'];
					$info['acourse'] = $new_val2['acourse'];
					$info['projects'] = $new_val2['projects'];
					$info['j_exp'] = $new_val2['j_exp'];
					$info['j_desc'] = $new_val2['j_desc'];
				}
				$_POST['username'] = $info['username'];
			}
			elseif(!empty($_POST['form1']) && $info['formtype'] == 'proper'){
				$tempx = $_POST['username'];
				$tempem = $_POST['email'];
				$tempcon = $_POST['contact_no'];
				$tempage = $_POST['age'];
				$cmd3 = "UPDATE Users SET email = '$tempem', contact_no = '$tempcon', age = '$tempage' WHERE username = '$tempx'";
				$out3 = mysqli_query($connection, $cmd3);
				if(!$out3){
					echo "Failure";
				}
				$tempcol = $_POST['college'];
				$tempc_b = $_POST['c_board'];
				$tempc_d = $_POST['c_degree'];
				$tempc_c = $_POST['c_cgpa'];
				$tempsch = $_POST['school'];
				$temps_b = $_POST['s_board'];
				$temps_p = $_POST['s_percent'];
				$tempjcol = $_POST['jcollege'];
				$tempjc_b = $_POST['jc_board'];
				$tempjc_p = $_POST['jc_percent'];
				$temppcol = $_POST['pcollege'];
				$temppc_b = $_POST['pc_board'];
				$temppc_d = $_POST['pc_degree'];
				$temppc_c = $_POST['pc_cgpa'];
				$tempm = $_POST['mname'];
				$tempf = $_POST['fname'];
				$tempac = $_POST['acourse'];
				$temppro = $_POST['projects'];
				$tempj_exp = $_POST['j_exp'];
				$tempj_desc = $_POST['j_desc'];
				$cmd4 = "UPDATE Admin SET college = '$tempcol', c_board = '$tempc_b', c_degree = '$tempc_d', c_cgpa = '$tempc_c', school = '$tempsch', s_board = '$temps_b', s_percent = '$temps_p', jcollege = '$tempjcol', jc_board = '$tempjc_b', jc_percent = '$tempjc_p', pcollege = '$temppcol', pc_board = '$temppc_b', pc_degree = '$temppc_d', pc_cgpa = '$temppc_c', mname = '$tempm', fname = '$tempf', acourse = '$tempac', projects = '$temppro', j_exp = '$tempj_exp', j_desc = '$tempj_desc' WHERE username = '$tempx'";
				$out4 = mysqli_query($connection, $cmd4);
				if(!$out4){
					echo "Failure";
					$info['adname'] = 'Failure';
				}
			}
		}
	?>
	<head>
		<link rel = "stylesheet" type = "text/css" href = "interfacez.css">
		<title>View Resume <?php echo $_POST['formtype']; ?></title>
	</head>
	<body>
		<form action = "view.php" method = "post" class = "form1">
			<table id = "t1">
			<td><select name = "adname" class = "input-form">
				<?php
					for($i = 0; $i < count($new_val); $i++){
						echo "<option value = ".'"'.$new_val[$i][0].'"'.">".$new_val[$i][0]."</option>";
					}
				?>
			</select></td>
			<input type = "hidden" name = "form1" value = "adname">
			<td><button type = "submit" class = "submit">View</button></td>
			</table>
		</form>
		<form action = "logout.php" class = "logout">
			<button class = "submit" name = "logout">Logout</button>
		</form>
		<p></p>
		<br>
		<form action = "view.php" method = "post" class = "form2">
			<div class="title">Resume</div>
			<div class="details">
				<table>
					<tr><td>Name: </td><td><div id = "tab"><input type="text"name="adname" class = "input-form" value = <?php echo '"'.$info['adname'].'"'; echo $isDisabled;?>></div></td>
					<td>Age: </td><td><div id = "tab"><input type="number"name="age" class = "input-form" value = <?php echo '"'.$info['age'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Email: </td><td><div id = "tab"><input type="text"name="email" class = "input-form" value = <?php echo '"'.$info['email'].'"'; echo $isDisabled;?>></div></td>
					<td>Contact No.: </td><td><div id = "tab"><input type="number"name="contact_no" class = "input-form" value = <?php echo '"'.$info['contact_no'].'" '; echo $isDisabled; ?>></div></td></tr>
					<tr><td>College Name: </td><td><div id = "tab"><input type="text"name="college" class = "input-form" value = <?php echo '"'.$info['college'].'"'; echo $isDisabled;?>></div></td>
					<td>College Board: </td><td><div id = "tab"><input type="text"name="c_board" class = "input-form" value = <?php echo '"'.$info['c_board'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Degree: </td><td><div id = "tab"><input type="text"name="c_degree" class = "input-form" value = <?php echo '"'.$info['c_degree'].'"'; echo $isDisabled;?>></div></td>
					<td>CGPA: </td><td><div id = "tab"><input type="number" step = "0.01" name="c_cgpa" class = "input-form" value = <?php echo '"'.$info['c_cgpa'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Job Experience: </td><td><div id = "tab"><input type="number"name="j_exp" placeholder = "In years" class = "input-form" value = <?php echo '"'.$info['j_exp'].'"'; echo $isDisabled;?>></div></td>
					<td>Job Description: </td><td><div id = "tab"><textarea type="text"name="j_desc" class = "input-form" rows = "3" <?php echo $isDisabled; ?>><?php echo $info['j_desc']; ?></textarea></div></td></tr>
					<tr><td>Post-Grad College: </td><td><div id = "tab"><textarea type="text"name="pcollege" class = "input-form" <?php echo $isDisabled; ?>><?php echo $info['pcollege']; ?></textarea></div></td>
					<td>Post-Grad Board: </td><td><div id = "tab"><input type="text"name="pc_board" class = "input-form" value = <?php echo '"'.$info['pc_board'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Post-Grad Degree: </td><td><div id = "tab"><input type="text"name="pc_degree" class = "input-form" value = <?php echo '"'.$info['pc_degree'].'"'; echo $isDisabled;?>></div></td>
					<td>Post-Grad CGPA: </td><td><div id = "tab"><input type="number"name="pc_cgpa" step = "0.01" class = "input-form" value = <?php echo '"'.$info['pc_cgpa'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>School Name: </td><td><div id = "tab"><input type="text"name="school" class = "input-form" value = <?php echo '"'.$info['school'].'"'; echo $isDisabled;?>></div></td>
					<td>School Board: </td><td><div id = "tab"><input type="text"name="s_board" class = "input-form" value = <?php echo '"'.$info['s_board'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>10th Percentage: </td><td><div id = "tab"><input type="number" name="s_percent" step = "0.01" class = "input-form" value = <?php echo '"'.$info['s_percent'].'"'; echo $isDisabled;?>></div></td>
					<td>Junior College: </td><td><div id = "tab"><input type="text"name="jcollege" class = "input-form" value = <?php echo '"'.$info['jcollege'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>J.C. Board: </td><td><div id = "tab"><input type="text"name="jc_board" class = "input-form" value = <?php echo '"'.$info['jc_board'].'"'; echo $isDisabled;?>></div></td>
					<td>12th Percentage: </td><td><div id = "tab"><input type="number" name="jc_percent" step = "0.01" class = "input-form" value = <?php echo '"'.$info['jc_percent'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Mother's Name: </td><td><div id = "tab"><input type="text"name="mname" class = "input-form" value = <?php echo '"'.$info['mname'].'"'; echo $isDisabled;?>></div></td>
					<td>Father's Name: </td><td><div id = "tab"><input type="text"name="fname" class = "input-form" value = <?php echo '"'.$info['fname'].'"'; echo $isDisabled; ?>></div></td></tr>
					<tr><td>Additional Course: </td><td><div id = "tab"><textarea type="text"name="acourse" class = "input-form" rows = "5" <?php echo $isDisabled;?>><?php echo $info['acourse']; ?></textarea></div></td>
					<td>Projects: </td><td><div id = "tab"><textarea type="text"name="projects" class = "input-form" rows = "5" <?php echo $isDisabled; ?>><?php echo $info['projects']; ?></textarea></div></td></tr>
				</table>
				<input type = "hidden" name = "form1" value = "proper">
				<input type="hidden" name="username" value = <?php echo $info['username']; ?>>      
				<button class = "submit" type = "submit" <?php echo $isDisabled; ?>>Submit</button>
			</div>
		</form>
	</body>
</html>
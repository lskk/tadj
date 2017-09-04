<?php
	session_start();
	
	if(!isset($_SESSION["user"])) {
		header("Location: index.php");
	}
?>
<html>
<body>
<?php
	include "ldap_connect.php";
	
	if(isset($_POST["lname"])) {
		$insert_data['objectclass'][0] = 'inetOrgPerson';
		$insert_data['objectclass'][1] = "posixAccount";
		$insert_data['objectclass'][2] = "top";
		$insert_data['cn'] = $_POST["name"];
		$insert_data['gidNumber'] = $_POST["group"];
		$insert_data['givenName'] = $_POST["fname"];
		$insert_data['homeDirectory'] = $_POST["homepath"];
		$insert_data['userPassword'] = "{MD5}" . base64_encode(pack('H*',md5($_POST["password"])));
		$insert_data['sn'] = $_POST["lname"];
		$insert_data['uidNumber'] = $_POST["userid"];
		$insert_data['uid'] = $_POST["username"];
		
		if($ldap->addUser('cn=' . $insert_data['cn'], $insert_data)) {
			$ldap->close();
			header("Location: home.php");
		} else {
			unset($_POST["lname"]);
			unset($insert_data);
		}
	}
?>
	<button onclick="window.location.href='logout.php'">Logout</button> <button onclick="window.location.href='home.php'">Home</button>
	<form action="" method="post">
		<table>
			<tr>
				<td>First Name</td><td><input type="text" name="fname" id="fname" onkeyup="updateUsername();"></td>
			</tr>
			<tr>
				<td>Last Name</td><td><input type="text" name="lname" id="lname" onkeyup="updateUsername();" required></td>
			</tr>
			<tr>
				<td>User Name</td><td><input type="text" name="username" id="username" required></td>
			</tr>
			<tr>
				<td>Password</td><td><input type="password" name="password" id="password1" required></td>
			</tr>
			<tr>
				<td>Konfirmasi</td><td><input type="password" id="password2" onchange="detectPassword();" required></td>
			</tr>
			<tr>
				<td>Group</td><td><select name="group">
			<?php
				$group = $ldap->getUsers($objectGroup, null);
				
				for($x = 0; $x < (count($group) - 1); $x++) {
			?>
					<option value="<?php echo $group[$x]["gidnumber"][0]; ?>"><?php echo $group[$x]["cn"][0]; ?></option>
			<?php
				}
			?>
				</select></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Create"></td>
			</tr>
		</table>
		<?php
				$user = $ldap->getUsers($objectAccount, null);
				
				$last_id = $user[count($user) - 2]["uidnumber"][0];
		?>
		<input type="hidden" name="name" id="name"><input type="hidden" name="userid" value="<?php echo $last_id + 1; ?>"><input type="hidden" name="homepath" id="homepath">
<?php
	$ldap->close();
?>
	</form>
	<script>
		function updateUsername() {
			if(document.getElementById("fname").value != '') {
				document.getElementById("username").value = document.getElementById("fname").value[0] + document.getElementById("lname").value;
				document.getElementById("name").value = document.getElementById("fname").value + " " + document.getElementById("lname").value;
			} else {
				document.getElementById("username").value = document.getElementById("lname").value;
				document.getElementById("name").value = document.getElementById("lname").value;
			}
			document.getElementById("homepath").value = "/home/users/" + document.getElementById("username").value;
		}
		
		function detectPassword() {
			if(document.getElementById("password1").value != document.getElementById("password2").value) {
				alert("Password 2 must be match with password 1");
				document.getElementById("password2").value = "";
			}
		}
	</script>
</body>
</html>
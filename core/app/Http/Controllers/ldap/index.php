<html>
<body>
<?php
	include "ldap_connect.php";
	
	if(isset($_POST["name"])) {
		// Bind with LDAP instance
		if($ldap->auth('cn=' . $_POST['name'], $_POST['password'])) {
			session_start();
			$_SESSION["user"] = $_POST["name"];
			$ldap->close();
			header("Location: home.php");
		} else {
			echo "Name not found or password not correct<br>";
			unset($_POST["name"]);
		}
	}
	
	$ldap->close();
?>
	<form method="post" action="">
		<table>
			<tr>
				<td>Name</td><td><input type="text" name="name"></td>
			</tr>
			<tr>
				<td>Password</td><td><input type="password" name="password"></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Login"></td>
			</tr>
		</table>
	</form>
</body>
</html>
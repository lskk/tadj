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
	
	if(isset($_POST["group"])) {
		$insert_data['gidNumber'] = $_POST["group"];
		
		if($ldap->modifyUser('cn=' . $_POST['cn'], $insert_data)) {
			$ldap->close();
			header("Location: home.php");
		} else {
			unset($_POST["group"]);
			unset($insert_data);
		}
	}
?>
	<button onclick="window.location.href='logout.php'">Logout</button> <button onclick="window.location.href='home.php'">Home</button>
	<form action="" method="post">
		<table>
		<?php
			$user = $ldap->getUsers('uidnumber=' . $_GET["id"], null);
			
			if($user) {
			?>
			<tr>
				<td>Group</td><td><select name="group">
		<?php
			$group = $ldap->getUsers($objectGroup, null);
			
			for($x = 0; $x < (count($group) - 1); $x++) {
				if($group[$x]["gidnumber"][0] == $user[0]["gidnumber"][0]) {
		?>
					<option value="<?php echo $group[$x]["gidnumber"][0]; ?>" selected><?php echo $group[$x]["cn"][0]; ?></option>
		<?php
				} else {
		?>
					<option value="<?php echo $group[$x]["gidnumber"][0]; ?>"><?php echo $group[$x]["cn"][0]; ?></option>
		<?php
				}
			}
		?>
				</select></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" value="Edit"></td>
			</tr>
			<input type="hidden" name="cn" value="<?php echo $user[0]["cn"][0]; ?>">
			<?php
			} else {
				$ldap->close();
				header("Location: home.php");
			}
			
			$ldap->close();
		?>
		</table>
	</form>
</body>
</html>
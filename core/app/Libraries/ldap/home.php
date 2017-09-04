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
?>
	<button onclick="window.location.href='logout.php'">Logout</button> <button onclick="window.location.href='create.php'">Create User</button>
	<table>
		<tr>
			<th>Name<th>
		</tr>
	<?php
		$user = $ldap->getUsers($objectAccount, null);
		
		for($x = 0; $x < (count($user) - 1); $x++) {
		?>
		<tr><td>
		<?php
			echo $user[$x]["cn"][0];
		?>
		</td><td><button onclick="window.location.href='edit.php?id=<?php echo $user[$x]["uidnumber"][0]; ?>'">
		Edit
		</button></td><td><button onclick="deleteUser(<?php echo $user[$x]["uidnumber"][0]; ?>, '<?php echo $user[$x]["cn"][0]; ?>');">
		Delete
		</button></td></tr>
		<?php
		}
		
		$ldap->close();
	?>
	</table>
	<script>
		function deleteUser(idNumber, name) {
			var r = confirm("Are you sure you want to delete user " + name + "?\n(This cannot be undone)");
			if (r == true) {
				window.location.href = 'delete.php?id=' + idNumber;
			}
		}
	</script>
</body>
</html>
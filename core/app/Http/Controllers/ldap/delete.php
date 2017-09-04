<?php
	session_start();
	
	if(!isset($_SESSION["user"])) {
		header("Location: index.php");
	}
	
	include "ldap_connect.php";
	
	$user = $ldap->getUsers('uidnumber=' . $_GET["id"], null);
		
	if($user) {
		$ldap->removeUser('cn=' . $user[0]["cn"][0]);
	}
	
	$ldap->close();
	
	header("Location: home.php");
?>
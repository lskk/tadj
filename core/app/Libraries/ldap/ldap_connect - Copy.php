<?php
	require('SimpleLDAP.php');

	$statusDevelopment = true;
	ini_set('display_errors', $statusDevelopment);

	$ldap = new SimpleLDAP('127.0.0.1', 389, 3); // Host, port and server protocol (this one is optional)
	$ldap->dn = 'ou=Crayonpedia,dc=maxcrc,dc=com'; // The default DN (Distinguished Name)
	$ldap->adn = 'cn=Manager,dc=maxcrc,dc=com'; // The admin DN
	$ldap->apass = 'secret'; // The admin password
	
	$baseDN = 'dc=maxcrc,dc=com';
	$objectDN = 'ou=Crayonpedia,' . $baseDN;
	$objectAccount = '(objectClass=posixAccount)';
	$objectGroup = '(objectClass=posixGroup)';
?>
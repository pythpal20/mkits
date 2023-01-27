<?php
	// koneksi 1 mysqli object
	$DB_HOST 	= 'localhost';
	$DB_USER 	= 'root';
	$DB_PASS	= '';
	$DATABASE 	= 'horek940_salsys';
	$db1 		= new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DATABASE);
	// koneksi 2 mysqli
	$connect = mysqli_connect("localhost", "root", "", "horek940_salsys");
	
	// koneksi 3 PDO
	$host = 'localhost';
	$username = 'root';
	$password = ''; 
	$database = 'horek940_salsys'; 
	$pdo = new PDO('mysql:host='.$host.';dbname='.$database, $username, $password);
	


	// koneksi agil keepstock mysqli object
	$DB_HOST_AGIL 	= 'localhost';
	$DB_USER_AGIL 	= 'root';
	$DB_PASS_AGIL	= '';
	$DATABASE_AGIL 	= 'horek940_ngudang';
	$DB_AGIL 		= new mysqli($DB_HOST_AGIL, $DB_USER_AGIL, $DB_PASS_AGIL, $DATABASE_AGIL);

?>

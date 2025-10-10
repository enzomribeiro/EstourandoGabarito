<?php
	$host = 'localhost';
	$db_name = 'quizetec';
	
	$dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
	$username = "root";
	$pass = '';
	
	try{
		$pdo = new PDO($dsn, $username, $pass);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} catch (PDOException $e){
		echo "Falha ao conectar: " . $e->getMessage();
	}
?>

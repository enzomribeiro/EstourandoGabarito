<?php
	$host = 'localhost';
	$db_name = 'quizetec'; // nome original quizetec
	
	$dsn = "mysql:host=$host;dbname=$db_name;port=3306;charset=utf8mb4";
	$username = "root";
	$pass = '12345678';
	
	try{
		$pdo = new PDO($dsn, $username, $pass);

		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	} catch (PDOException $e){
		echo "Falha ao conectar: " . $e->getMessage();
	}
?>

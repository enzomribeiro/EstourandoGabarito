<?php
$host = "localhost";
$user = "root";   // padrão do Wamp
$pass = "";       // padrão do Wamp (senha vazia)
$db   = "quiztec";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Força UTF-8 na conexão
$conn->set_charset("utf8mb4");
?>

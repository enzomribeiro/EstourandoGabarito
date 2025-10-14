<?php 
    header('Content-Type: application/json; charset=utf-8');
    include "../conexao.php";

    // Consulta
    $stmt = $pdo->query("SELECT * FROM perguntas ORDER BY id DESC");
    $perguntas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($perguntas);
?>
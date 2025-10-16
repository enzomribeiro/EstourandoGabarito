<?php
session_start();
include "conexao.php"; // Certifique-se de que o PDO está sendo incluído corretamente
$erro = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $usuario = trim($_POST['usuario']);
    $senha = trim($_POST['senha']);

    // Alterando de $conn para $pdo
    $sql = "SELECT * FROM admins WHERE usuario = :usuario AND senha = SHA2(:senha, 256)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() == 1) {
        $_SESSION['admin'] = $usuario;
        header("Location: admin.php");
        exit;
    } else {
        $erro = "Usuário ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - QuizTec</title>
    <link rel="stylesheet" href="css/style_Admin.css">
</head>
<body>
<h1>Login Admin</h1>

<?php if ($erro) echo "<p style='color:red;'>$erro</p>"; ?>

<form method="post">
    <input type="text" name="usuario" placeholder="Usuário" required><br>
    <input type="password" name="senha" placeholder="Senha" required><br>
    <button type="submit">Entrar</button>
</form>
</body>
</html>

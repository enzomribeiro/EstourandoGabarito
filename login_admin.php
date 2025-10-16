<?php
session_start();
include "conexao.php"; // Certifique-se de que o PDO está sendo incluído corretamente
$erro = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $usuario = trim($_POST['usuario']);
    $senha   = trim($_POST['senha']);

    // Hash da senha em PHP para compatibilidade com SQLite
    $senhaHash = hash('sha256', $senha);

    // Consulta no MySQL
    $sql = "SELECT * FROM admins WHERE usuario = :usuario AND senha = SHA2(:senha, 256)";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $stmt->bindParam(':senha', $senha, PDO::PARAM_STR); // SHA2 será aplicado no MySQL
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $_SESSION['admin'] = $usuario;
            header("Location: admin.php");
            exit;
        } else {
            $erro = "Usuário ou senha incorretos!";
        }
    } catch (PDOException $e) {
        error_log(date('[Y-m-d H:i:s]') . " Erro MySQL login: " . $e->getMessage());

        // Fallback para SQLite (usando senha já criptografada em PHP)
        $sql_sqlite = "SELECT * FROM admins WHERE usuario = :usuario AND senha = :senha";
        try {
            $stmt = $db->prepare($sql_sqlite);
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->bindParam(':senha', $senhaHash, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() == 1) {
                $_SESSION['admin'] = $usuario;
                header("Location: admin.php");
                exit;
            } else {
                $erro = "Usuário ou senha incorretos!";
            }
        } catch (PDOException $e) {
            error_log(date('[Y-m-d H:i:s]') . " Erro SQLite login: " . $e->getMessage());
            $erro = "Erro ao tentar autenticar. Tente novamente.";
        }
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

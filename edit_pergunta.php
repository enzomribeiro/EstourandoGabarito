<?php
include "conexao.php";

// Se não tiver ID, volta para admin
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = (int)$_GET['id'];
$sql = "SELECT * FROM perguntas WHERE id = :id";

try {
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $pergunta = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log(date('[Y-m-d H:i:s]') . " Erro MySQL SELECT: " . $e->getMessage() . " | ID: $id");

    try {
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $pergunta = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log(date('[Y-m-d H:i:s]') . " Erro SQLite SELECT: " . $e->getMessage() . " | ID: $id");
        $pergunta = false;
    }
}

if (!$pergunta) {
    echo "<p>Pergunta não encontrada!</p>";
    echo "<a href='admin.php'>Voltar</a>";
    exit;
}

// Se enviar atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE perguntas SET 
        enunciado = :enunciado,
        alternativa_a = :a,
        alternativa_b = :b,
        alternativa_c = :c,
        alternativa_d = :d,
        correta = :correta,
        categoria = :categoria
        WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':enunciado', $_POST['enunciado']);
        $stmt->bindParam(':a', $_POST['a']);
        $stmt->bindParam(':b', $_POST['b']);
        $stmt->bindParam(':c', $_POST['c']);
        $stmt->bindParam(':d', $_POST['d']);
        $stmt->bindParam(':correta', $_POST['correta']);
        $stmt->bindParam(':categoria', $_POST['categoria']);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    } catch (PDOException $e) {
        error_log(date('[Y-m-d H:i:s]') . " Erro MySQL UPDATE: " . $e->getMessage() . " | ID: $id");

        try {
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':enunciado', $_POST['enunciado']);
            $stmt->bindParam(':a', $_POST['a']);
            $stmt->bindParam(':b', $_POST['b']);
            $stmt->bindParam(':c', $_POST['c']);
            $stmt->bindParam(':d', $_POST['d']);
            $stmt->bindParam(':correta', $_POST['correta']);
            $stmt->bindParam(':categoria', $_POST['categoria']);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            error_log(date('[Y-m-d H:i:s]') . " Erro SQLite UPDATE: " . $e->getMessage() . " | ID: $id");
        }
    }

    header("Location: admin.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Pergunta - QuizTec</title>
    <link rel="stylesheet" href="css/style_Admin.css">
</head>
<body>
<h1>Editar Pergunta</h1>

<div class="form-box">
    <form method="post">
        <input type="text" name="enunciado" value="<?= htmlspecialchars($pergunta['enunciado']) ?>" required><br>
        <input type="text" name="a" value="<?= htmlspecialchars($pergunta['alternativa_a']) ?>" required><br>
        <input type="text" name="b" value="<?= htmlspecialchars($pergunta['alternativa_b']) ?>" required><br>
        <input type="text" name="c" value="<?= htmlspecialchars($pergunta['alternativa_c']) ?>" required><br>
        <input type="text" name="d" value="<?= htmlspecialchars($pergunta['alternativa_d']) ?>" required><br>
        <input type="text" name="correta" value="<?= htmlspecialchars($pergunta['correta']) ?>" required><br>

        <label>Categoria:</label>
        <select name="categoria" required>
            <option value="Geral"   <?= ($pergunta['categoria']=="Geral"?"selected":"") ?>>Geral</option>
            <option value="Filmes"  <?= ($pergunta['categoria']=="Filmes"?"selected":"") ?>>Filmes</option>
            <option value="Esportes"<?= ($pergunta['categoria']=="Esportes"?"selected":"") ?>>Esportes</option>
            <option value="Ciência" <?= ($pergunta['categoria']=="Ciência"?"selected":"") ?>>Ciência</option>
            <option value="Biologia" <?= ($pergunta['categoria']=="Biologia"?"selected":"") ?>>Biologia</option>
            <option value="Games"   <?= ($pergunta['categoria']=="Games"?"selected":"") ?>>Games</option>
            <option value="História"<?= ($pergunta['categoria']=="História"?"selected":"") ?>>História</option>
        </select><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>
</div>

<div class="button">
    <a href="admin.php">Voltar</a>
</div>
</body>
</html>

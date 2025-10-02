<?php
include "conexao.php";

// Se não tiver ID, volta para admin
if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = (int)$_GET['id'];

// Buscar a pergunta pelo ID
$res = $conn->query("SELECT * FROM perguntas WHERE id=$id");
$pergunta = $res->fetch_assoc();

if (!$pergunta) {
    echo "<p>Pergunta não encontrada!</p>";
    echo "<a href='admin.php'>Voltar</a>";
    exit;
}

// Se enviar atualização
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE perguntas SET 
                enunciado='{$_POST['enunciado']}',
                alternativa_a='{$_POST['a']}',
                alternativa_b='{$_POST['b']}',
                alternativa_c='{$_POST['c']}',
                alternativa_d='{$_POST['d']}',
                correta='{$_POST['correta']}',
                categoria='{$_POST['categoria']}'
            WHERE id=$id";

    if ($conn->query($sql)) {
        header("Location: admin.php");
        exit;
    } else {
        echo "Erro: " . $conn->error;
    }
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

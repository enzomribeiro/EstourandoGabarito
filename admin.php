<?php 
session_start();
include "conexao.php";

// Verifica se o admin está logado
if (!isset($_SESSION['admin'])) {
    header("Location: login_admin.php");
    exit;
}

// Função para deletar pergunta
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM perguntas WHERE id=$id");
    header("Location: admin.php");
    exit;
}

// Função para atualizar pergunta
if (isset($_POST['update_id'])) {
    $id = (int)$_POST['update_id'];

    $enunciado = $conn->real_escape_string($_POST['enunciado']);
    $a = $conn->real_escape_string($_POST['a']);
    $b = $conn->real_escape_string($_POST['b']);
    $c = $conn->real_escape_string($_POST['c']);
    $d = $conn->real_escape_string($_POST['d']);
    $correta = strtoupper($conn->real_escape_string($_POST['correta']));
    $categoria = $conn->real_escape_string($_POST['categoria']);

    $conn->query("UPDATE perguntas SET 
        enunciado='$enunciado', 
        alternativa_a='$a', 
        alternativa_b='$b', 
        alternativa_c='$c', 
        alternativa_d='$d', 
        correta='$correta', 
        categoria='$categoria' 
        WHERE id=$id");

    header("Location: admin.php");
    exit;
}

// Cadastro de nova pergunta
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update_id'])) {
    $enunciado = $conn->real_escape_string($_POST['enunciado']);
    $a = $conn->real_escape_string($_POST['a']);
    $b = $conn->real_escape_string($_POST['b']);
    $c = $conn->real_escape_string($_POST['c']);
    $d = $conn->real_escape_string($_POST['d']);
    $correta = strtoupper($conn->real_escape_string($_POST['correta']));
    $categoria = $conn->real_escape_string($_POST['categoria']);

    $sql = "INSERT INTO perguntas (enunciado, alternativa_a, alternativa_b, alternativa_c, alternativa_d, correta, categoria) 
            VALUES ('$enunciado', '$a', '$b', '$c', '$d', '$correta', '$categoria')";
    $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Admin - QuizTec</title>
    <link rel="stylesheet" href="css/style_Admin.css">
</head>
<body>
<h1>Admin - Gerenciar Perguntas</h1>
<p>Logado como: <?php echo htmlspecialchars($_SESSION['admin']); ?> | <a href="logout_admin.php">Logout</a></p>

<div class="form-box">
    <h2>Cadastrar Nova Pergunta</h2>
    <form method="post">
        <input type="text" name="enunciado" placeholder="Pergunta" required><br>
        <input type="text" name="a" placeholder="Alternativa A" required><br>
        <input type="text" name="b" placeholder="Alternativa B" required><br>
        <input type="text" name="c" placeholder="Alternativa C" required><br>
        <input type="text" name="d" placeholder="Alternativa D" required><br>
        <input type="text" name="correta" placeholder="Letra correta (A/B/C/D)" required><br>
        <label>Categoria:</label>
        <select name="categoria" required>
            <option value="Geral">Geral</option>
            <option value="Filmes">Filmes</option>
            <option value="Esportes">Esportes</option>
            <option value="Ciência">Ciência</option>
            <option value="Games">Games</option>
            <option value="História">História</option>
        </select><br><br>
        <button type="submit">Cadastrar</button>
    </form>
</div>

<div class="table-container">
    <h2>Perguntas Cadastradas</h2>
    <div class="button"><a href="index.php">HOME</a></div>
    <table>
        <tr>
            <th>ID</th>
            <th>Pergunta</th>
            <th>A</th>
            <th>B</th>
            <th>C</th>
            <th>D</th>
            <th>Correta</th>
            <th>Categoria</th>
            <th>Ações</th>
        </tr>
        <?php
        $perguntas = $conn->query("SELECT * FROM perguntas ORDER BY id DESC");
        while($p = $perguntas->fetch_assoc()):
        ?>
        <tr>
            <td><?php echo $p['id']; ?></td>
            <td><?php echo htmlspecialchars($p['enunciado']); ?></td>
            <td><?php echo htmlspecialchars($p['alternativa_a']); ?></td>
            <td><?php echo htmlspecialchars($p['alternativa_b']); ?></td>
            <td><?php echo htmlspecialchars($p['alternativa_c']); ?></td>
            <td><?php echo htmlspecialchars($p['alternativa_d']); ?></td>
            <td><?php echo strtoupper($p['correta']); ?></td>
            <td><?php echo htmlspecialchars($p['categoria']); ?></td>
            <td>
                <a class="edit" href="edit_pergunta.php?id=<?php echo $p['id']; ?>">Editar</a> | 
                <a class="delete" href="admin.php?delete=<?php echo $p['id']; ?>" onclick="return confirm('Tem certeza?')">Excluir</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>

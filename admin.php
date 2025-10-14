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
    
    $sql = "DELETE FROM perguntas WHERE id=$id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    header("Location: admin.php");
    exit;
}

// Função para atualizar pergunta
if (isset($_POST['update_id'])) {
    $id = (int)$_POST['update_id'];

    $enunciado = $_POST['enunciado'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $correta = strtoupper($_POST['correta']);
    $categoria = $_POST['categoria'];


    $sql = "UPDATE perguntas SET enunciado=':enunciado', alternativa_a=':a', alternativa_b=':b', alternativa_c=':c', alternativa_d=':d', correta=':correta', categoria=':categoria' WHERE id=':id'";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(":enunciado", $enunciado);
    $stmt->bindParam(":id", $id);
    $stmt->bindParam(":a", $a);
    $stmt->bindParam(":b", $b);
    $stmt->bindParam(":c", $c);
    $stmt->bindParam(":d", $d);
    $stmt->bindParam(":correta", $correta);
    $stmt->bindParam(":correta", $categoria);
    header("Location: admin.php");
    exit;
}

// Cadastro de nova pergunta
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['update_id'])) {


    $enunciado = $_POST['enunciado'];
    $a = $_POST['a'];
    $b = $_POST['b'];
    $c = $_POST['c'];
    $d = $_POST['d'];
    $correta = strtoupper($_POST['correta']);
    $categoria = $_POST['categoria'];

    $sql = "INSERT INTO perguntas (enunciado, alternativa_a, alternativa_b, alternativa_c, alternativa_d, correta, categoria) 
            VALUES (:enunciado, :a, :b, :c, :d, :correta, :categoria)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":enunciado", $enunciado);
    $stmt->bindParam(":a", $a);
    $stmt->bindParam(":b", $b);
    $stmt->bindParam(":c", $c);
    $stmt->bindParam(":d", $d);
    $stmt->bindParam(":correta", $correta);
    $stmt->bindParam(":categoria", $categoria);
    $stmt->execute();
    header("Location: admin.php");
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
                <option value="Biologia">Biologia</option>
                <option value="Games">Games</option>
                <option value="História">História</option>
            </select><br><br>
            <button type="submit">Cadastrar</button>
        </form>
    </div>

    <!---Sistema de tabela (Otimizada)--->
    <div class="table-container">
        <h2>Perguntas Cadastradas</h2>
        <div class="button"><a href="index.php">HOME</a></div>
        <table id="tabela">
            <thead>
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
            </thead>            
            
            <tbody>
                <tr>
                    <tr><td colspan="9">Carregando...</td></tr>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        async function carregarPerguntas() {
        try {
            const resposta = await fetch('./dates/get_perguntas.php');
            console.log(`resultado de resposta: ${resposta}`);
            const perguntas = await resposta.json();
            console.log(`resultado de perguntas: ${perguntas}`);

            const tbody = document.querySelector('#tabela tbody');
            tbody.innerHTML = ""; // limpa o "Carregando..."

            perguntas.forEach(p => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${p.id}</td>
                <td>${p.enunciado}</td>
                <td>${p.alternativa_a}</td>
                <td>${p.alternativa_b}</td>
                <td>${p.alternativa_c}</td>
                <td>${p.alternativa_d}</td>
                <td>${p.correta}</td>
                <td>${p.categoria}</td>
                <td>
                    <a class="edit" href="./edit_pergunta.php?id=${p.id}">Editar</a> | 
                    <a class="delete" href="./admin.php?delete=${p.id}" onclick="return confirm('Tem certeza?')">Excluir</a>
                </td>
            `;
            tbody.appendChild(tr);
            });
        } catch (erro) {
            console.error('Erro ao carregar perguntas:', erro);
        }
        }

        // Carrega automaticamente ao abrir a página
        carregarPerguntas();
  </script>
</body>
</html>

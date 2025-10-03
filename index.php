<?php
session_start();
include "conexao.php";

$error = "";
$codigo_val = "";
$nome_val = "";
$categoria_val = "Geral";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo    = trim($_POST['codigo'] ?? "");
    $nome      = trim($_POST['nome'] ?? "");
    $categoria = $_POST['categoria'] ?? "Geral";

    // guarda para reapresentar em caso de erro
    $codigo_val = htmlspecialchars($codigo, ENT_QUOTES);
    $nome_val = htmlspecialchars($nome, ENT_QUOTES);
    $categoria_val = $categoria;

    // salva a categoria na sessão
    $_SESSION['categoria'] = $categoria;

    // Validações básicas
    if ($codigo === "" || $nome === "") {
        $error = "Preencha código e nome corretamente.";
    } else {
        // 1) Verifica se já existe jogador com esse código
        $stmt = $conn->prepare("SELECT id, nome FROM jogadores WHERE codigo = ? LIMIT 1");
        $stmt->bind_param("s", $codigo);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($res && $res->num_rows > 0) {
            // Código já existe -> faz login (usa o jogador existente)
            $jogador = $res->fetch_assoc();
            $_SESSION['jogador_id'] = $jogador['id'];
            // opcional: atualizar nome no session
            $_SESSION['jogador_nome'] = $jogador['nome'];
            $stmt->close();
            header("Location: jogo.php");
            exit;
        }
        $stmt->close();

        // 2) Verifica se já existe jogador com esse NOME (case-insensitive)
        $stmt = $conn->prepare("SELECT id, codigo FROM jogadores WHERE LOWER(nome) = LOWER(?) LIMIT 1");
        $stmt->bind_param("s", $nome);
        $stmt->execute();
        $res_nome = $stmt->get_result();

        if ($res_nome && $res_nome->num_rows > 0) {
            // Nome já existe -> não permite cadastrar
            $error = "⚠️ Este nome já está em uso. Escolha outro nome.";
            $stmt->close();
        } else {
            $stmt->close();
            // 3) Insere novo jogador (nome e código são únicos aqui)
            $stmt = $conn->prepare("INSERT INTO jogadores (codigo, nome) VALUES (?, ?)");
            $stmt->bind_param("ss", $codigo, $nome);
            if ($stmt->execute()) {
                $_SESSION['jogador_id'] = $conn->insert_id;
                $_SESSION['jogador_nome'] = $nome;
                $stmt->close();
                header("Location: jogo.php");
                exit;
            } else {
                $error = "Erro ao registrar jogador. Tente novamente.";
                $stmt->close();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Estourando o Gabarito - Login</title>
    <link rel="stylesheet" href="css/style_Home.css">
</head>
<body>
    <h1>Bem-vindo ao Estourando o Gabarito</h1>

    <!-- Container com imagens e formulário central -->
    <div class="img-container">
        <img src="int.png" class="img-left">
        
        <div class="form-box">
            <h2>Entrar no Jogo</h2>

            <!-- mostra mensagem de erro, se houver -->
            <?php if ($error): ?>
                <p style="color: #b00020; font-weight:bold; text-align:center;"><?= $error ?></p>
            <?php endif; ?>

            <form method="post">
                <input type="text" name="codigo" placeholder="Seu código (Jogar/Cadastrar)" required value="<?= $codigo_val ?>"><br>
                <input type="text" name="nome" placeholder="Seu nome (Cadastrar)" required value="<?= $nome_val ?>"><br>

                <label>Escolha o Tema:</label><br>
                <select name="categoria" required>
                    <option value="Geral"   <?= $categoria_val === "Geral" ? "selected" : "" ?>>Geral</option>
                    <option value="Filmes"  <?= $categoria_val === "Filmes" ? "selected" : "" ?>>Filmes</option>
                    <option value="Esportes"<?= $categoria_val === "Esportes" ? "selected" : "" ?>>Esportes</option>
                    <option value="Games"   <?= $categoria_val === "Games" ? "selected" : "" ?>>Games</option>
                    <option value="Ciência" <?= $categoria_val === "Ciência" ? "selected" : "" ?>>Ciência</option>
                    <option value="Biologia"<?= $categoria_val === "Biologia" ? "selected" : "" ?>>Biologia</option>
                    <option value="História"<?= $categoria_val === "História" ? "selected" : "" ?>>História</option>
                </select><br><br>

                <button type="submit">Entrar</button>
            </form>
        </div>

        <img src="int.png" class="img-right">
    </div>

    <!-- Menu -->
    <div class="menu">
        <a href="ranking.php">🏆 Ver Ranking</a>
        <a href="admin.php">⚙️ Área do Admin</a>
    </div>
</body>
</html>

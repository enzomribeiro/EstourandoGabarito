<?php
    session_start();
    session_regenerate_id(true);
    include "conexao.php";
    include "./VAMGLibsPHP/VAMGFile.php";

    $error = "";
    $codigo_val = "";
    $nome_val = "";
    $categoria_val = "Geral";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $codigo    = trim($_POST['codigo'] ?? "");
        $nome      = trim($_POST['nome'] ?? "");
        $categoria = $_POST['categoria'] ?? "Geral";

        // Guarda para reapresentar em caso de erro
        $codigo_val = htmlspecialchars($codigo, ENT_QUOTES);
        $nome_val   = htmlspecialchars($nome, ENT_QUOTES);
        $categoria_val = $categoria;

        // Validações básicas
        if ($codigo === "" || $nome === "") {
            $error = "Preencha código e nome corretamente.";
        } else {
            // 1) Verifica se já existe jogador com esse código
            $sql = "SELECT id, nome FROM jogadores WHERE codigo = :codigo LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                // Código já existe -> faz login
                session_regenerate_id(true); // Gera novo ID de sessão
                $_SESSION['jogador_id'] = $resultado['id'];
                $_SESSION['jogador_nome'] = $resultado['nome'];
                $_SESSION['categoria'] = $categoria;
                header("Location: jogo.php");
                exit;
            }

            // 2) Verifica se já existe jogador com esse NOME (case-insensitive)
            $sql_nome = "SELECT id, codigo FROM jogadores WHERE LOWER(nome) = LOWER(:nome) LIMIT 1";
            $stmt_nome = $pdo->prepare($sql_nome);
            $stmt_nome->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt_nome->execute();
            $res_nome = $stmt_nome->fetch(PDO::FETCH_ASSOC);

            if ($res_nome) {
                $error = "⚠️ Este nome já está em uso. Escolha outro nome.";
            } else {
                // 3) Insere novo jogador
                $sql_insert = "INSERT INTO jogadores (codigo, nome, categoria) VALUES (:codigo, :nome, :categoria)";
                $stmt_insert = $pdo->prepare($sql_insert);
                $stmt_insert->bindParam(':codigo', $codigo, PDO::PARAM_STR);
                $stmt_insert->bindParam(':nome', $nome, PDO::PARAM_STR);
                $stmt_insert->bindParam(':categoria', $categoria, PDO::PARAM_STR);

                if ($stmt_insert->execute()) {
                    session_regenerate_id(true); // Novo ID de sessão
                    $_SESSION['jogador_id'] = $pdo->lastInsertId();
                    $_SESSION['jogador_nome'] = $nome;
                    $_SESSION['categoria'] = $categoria;

                    // Registra localmente no banco de dados
                    $backup = new BackupBD();
                    $backup->adicionar_player($codigo, $nome);

                    header("Location: jogo.php");
                    exit;
                } else {
                    $error = "Erro ao registrar jogador. Tente novamente.";
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
    <link rel="stylesheet" href="./css/style_Home.css">
</head>
<body>
    <h1>Bem-vindo ao Estourando o Gabarito</h1>

    <div class="img-container">
        <div class="form-box">
            <h2>Entrar no Jogo</h2>
            <?php if ($error): ?>
                <p style="color: #ff3b3b; font-weight:bold;"><?= $error ?></p>
            <?php endif; ?>

            <form method="post">
                <input type="text" name="codigo" placeholder="Seu código (Jogar/Cadastrar)" required value="<?= $codigo_val ?>"><br>
                <input type="text" name="nome" placeholder="Seu nome (Cadastrar)" required value="<?= $nome_val ?>"><br>

                <label>Escolha o Tema:</label><br>
                <select name="categoria" required>
                    <?php
                    $categorias = ["Geral","Filmes","Esportes","Games","Ciência","Biologia","História"];
                    foreach($categorias as $cat) {
                        $sel = $categoria_val === $cat ? "selected" : "";
                        echo "<option value='$cat' $sel>$cat</option>";
                    }
                    ?>
                </select><br><br>

                <button type="submit">Entrar</button>
            </form>
        </div>

        <div class="img-right">
            <img src="int.png" alt="Interrogação girando">
        </div>
    </div>

    <div class="menu">
        <a href="ranking.php">🏆 Ver Ranking</a>
        <a href="admin.php">⚙️ Área do Admin</a>
    </div>
</body>
</html>

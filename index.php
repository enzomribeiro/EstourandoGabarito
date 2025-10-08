<?php include "conexao.php"; ?>
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
            <form method="post">
                <input type="text" name="codigo" placeholder="Digite seu código" required><br>
                <input type="text" name="nome" placeholder="Digite seu nome (opcional)"><br>

                <label>Escolha o Tema:</label><br>
                <select name="categoria" required>
                    <option value="Geral">Geral</option>
                    <option value="Filmes">Filmes</option>
                    <option value="Esportes">Esportes</option>
                    <option value="Games">Games</option>
                    <option value="Ciência">Ciência</option>
                    <option value="Biologia">Biologia</option>
                    <option value="História">História</option>
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

<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $codigo = $_POST['codigo'];
    $nome   = $_POST['nome'];
    $categoria = $_POST['categoria'];

    $_SESSION['categoria'] = $categoria;

    $sql = "SELECT * FROM jogadores WHERE codigo='$codigo'";
    $res = $conn->query($sql);

    if ($res->num_rows > 0) {
        $jogador = $res->fetch_assoc();
        $_SESSION['jogador_id'] = $jogador['id'];
        header("Location: jogo.php");
        exit;
    } else {
        $sql = "INSERT INTO jogadores (codigo, nome) VALUES ('$codigo', '$nome')";
        if ($conn->query($sql)) {
            $_SESSION['jogador_id'] = $conn->insert_id;
            header("Location: jogo.php");
            exit;
        } else {
            echo "Erro ao registrar jogador.";
        }
    }
}
?>

</body>
</html>

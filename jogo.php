<?php
include "conexao.php";
session_start();

if (!isset($_SESSION['jogador_id']) || !isset($_SESSION['categoria'])) {
    header("Location: index.php");
    exit;
}

$jogador_id = $_SESSION['jogador_id'];
$categoria  = $_SESSION['categoria'];

$dados_jogador = $conn->query("SELECT nome, pontos FROM jogadores WHERE id=$jogador_id")->fetch_assoc();
$pontos = $dados_jogador['pontos'];
$nome_jogador = $dados_jogador['nome'];

$feedback = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pergunta = $conn->query("SELECT * FROM perguntas 
        WHERE categoria='$categoria' 
        AND id NOT IN (SELECT pergunta_id FROM respostas WHERE jogador_id=$jogador_id) 
        LIMIT 1")->fetch_assoc();

    if ($pergunta) {
        $timeout = isset($_POST['timeout']) ? true : false;
        $resp = $timeout ? null : $_POST['resp'];
        $correta = ($resp && $resp == $pergunta['correta']) ? 1 : 0;

        $conn->query("INSERT INTO respostas (jogador_id, pergunta_id, resposta, correta) 
                      VALUES ($jogador_id, {$pergunta['id']}, ".($resp ? "'$resp'" : "NULL").", $correta)");

        if (!$timeout && $correta) {
            $conn->query("UPDATE jogadores SET pontos = pontos + 100 WHERE id=$jogador_id");
            $pontos += 100;
            $feedback = "✅ Acertou! +100 pontos.";
        } elseif ($timeout) {
            $feedback = "⏰ Tempo esgotado! Você não respondeu a pergunta.";
        } else {
            $feedback = "❌ Errou! A resposta correta era: " . $pergunta['correta'];
        }

        header("Refresh:1; url=jogo.php");
    }
}

$pergunta = $conn->query("SELECT * FROM perguntas 
    WHERE categoria='$categoria' 
    AND id NOT IN (SELECT pergunta_id FROM respostas WHERE jogador_id=$jogador_id) 
    LIMIT 1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>QuizTec - Jogo</title>
    <link rel="stylesheet" href="css/style_Jogo.css">
</head>
<body>
    <h1>🎯 QuizTec - Categoria: <?= htmlspecialchars($categoria) ?></h1>
    <p>👤 Jogador: <?= htmlspecialchars($nome_jogador) ?> | 💰 Pontos: <?= $pontos ?></p>

    <?php if ($feedback): ?>
        <p class="feedback <?= strpos($feedback,'Acertou') !== false ? 'acerto' : 'erro' ?>">
            <?= htmlspecialchars($feedback) ?>
        </p>
    <?php endif; ?>

    <?php if ($pergunta): ?>
        <form method="post" id="quizForm">
            <p><b><?= htmlspecialchars($pergunta['enunciado']) ?></b></p>
            <p>⏱ Tempo restante: <span id="timer">20</span>s</p>

            <label><input type="radio" name="resp" value="A" required> <?= htmlspecialchars($pergunta['alternativa_a']) ?></label>
            <label><input type="radio" name="resp" value="B"> <?= htmlspecialchars($pergunta['alternativa_b']) ?></label>
            <label><input type="radio" name="resp" value="C"> <?= htmlspecialchars($pergunta['alternativa_c']) ?></label>
            <label><input type="radio" name="resp" value="D"> <?= htmlspecialchars($pergunta['alternativa_d']) ?></label><br>
            <button type="submit">Responder</button>
        </form>

        <script>
            let timeLeft = 20;
            const timerEl = document.getElementById('timer');
            const form = document.getElementById('quizForm');

            const countdown = setInterval(() => {
                timeLeft--;
                timerEl.textContent = timeLeft;

                if(timeLeft <= 0) {
                    clearInterval(countdown);

                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'timeout';
                    input.value = '1';
                    form.appendChild(input);

                    form.submit(); // envia automaticamente quando o tempo acabar
                }
            }, 1000);
        </script>
    <?php else: ?>
        <p>🏁 Você respondeu todas as perguntas dessa categoria!</p>
        <p>Veja o <a href="ranking.php">Ranking ao vivo</a>.</p>
        <p><a href="index.php">🔄 Jogar novamente em outra categoria</a></p>
    <?php endif; ?>
</body>
</html>

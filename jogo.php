<?php
include "conexao.php";
session_start();

// Verifica se jogador e categoria estão definidos
if (!isset($_SESSION['jogador_id']) || !isset($_SESSION['categoria'])) {
    header("Location: index.php");
    exit;
}

$jogador_id = (int)$_SESSION['jogador_id'];
$categoria  = $_SESSION['categoria'];

<<<<<<< HEAD
// Pega dados do jogador
$result = $conn->query("SELECT nome, pontos FROM jogadores WHERE id=$jogador_id");
if (!$result) die("Erro na query: " . $conn->error);
if ($result->num_rows == 0) die("Jogador não encontrado.");
$dados_jogador = $result->fetch_assoc();
$pontos = $dados_jogador['pontos'];
$nome_jogador = $dados_jogador['nome'];

// Constantes
define('TEMPO_QUESTAO', 20);
define('TEMPO_FEEDBACK', 6);

// Inicializa sessão de controle de jogo
=======
try {
    $sql = "SELECT nome, pontos FROM jogadores WHERE id = :jogador_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':jogador_id', $jogador_id, PDO::PARAM_INT);
    $stmt->execute();

    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$dados) die("Jogador não encontrado.");

    $pontos = $dados['pontos'];
    $nome_jogador = $dados['nome'];
} catch (PDOException $e) {
    die("Erro na query: " . $e->getMessage());
}

define('TEMPO_QUESTAO', 20);
define('TEMPO_FEEDBACK', 6);

>>>>>>> Pronto
if (!isset($_SESSION['jogo'])) {
    $_SESSION['jogo'] = [
        'pergunta_atual_id' => null,
        'inicio_questao' => null,
        'feedback' => null,
        'inicio_feedback' => null,
        'resposta_usuario' => null,
        'resposta_correta' => null,
    ];
}

<<<<<<< HEAD
// Função para pegar próxima pergunta não respondida
function proximaPergunta($conn, $categoria, $jogador_id) {
    return $conn->query("SELECT * FROM perguntas 
        WHERE categoria='$categoria' 
        AND id NOT IN (SELECT pergunta_id FROM respostas WHERE jogador_id=$jogador_id) 
        ORDER BY id ASC
        LIMIT 1")->fetch_assoc();
}

// Processa POST de resposta se não estiver em feedback
if ($_SERVER["REQUEST_METHOD"] == "POST" && !$_SESSION['jogo']['feedback']) {
    $resposta_usuario = $_POST['resp'] ?? null;

    // Busca a pergunta atual
    if ($_SESSION['jogo']['pergunta_atual_id']) {
        $pergunta = $conn->query("SELECT * FROM perguntas WHERE id={$_SESSION['jogo']['pergunta_atual_id']}")->fetch_assoc();
    } else {
        $pergunta = proximaPergunta($conn, $categoria, $jogador_id);
=======
function proximaPergunta($pdo, $categoria, $jogador_id) {
    $sql = "SELECT * FROM perguntas WHERE categoria = :categoria AND id NOT IN (
                SELECT pergunta_id FROM respostas WHERE jogador_id = :jogador_id
            ) ORDER BY id ASC LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':categoria', $categoria);
    $stmt->bindParam(':jogador_id', $jogador_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && !$_SESSION['jogo']['feedback']) {
    $resposta_usuario = $_POST['resp'] ?? null;

    if ($_SESSION['jogo']['pergunta_atual_id']) {
        $sql = "SELECT * FROM perguntas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $_SESSION['jogo']['pergunta_atual_id'], PDO::PARAM_INT);
        $stmt->execute();
        $pergunta = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $pergunta = proximaPergunta($pdo, $categoria, $jogador_id);
>>>>>>> Pronto
    }

    if ($pergunta) {
        $resposta_correta = $pergunta['correta'];
        $correta = ($resposta_usuario == $resposta_correta) ? 1 : 0;

<<<<<<< HEAD
        // Salva resposta no banco
        $conn->query("INSERT INTO respostas (jogador_id, pergunta_id, resposta, correta) 
                      VALUES ($jogador_id, {$pergunta['id']}, ".($resposta_usuario ? "'$resposta_usuario'" : "NULL").", $correta)");

        // Atualiza pontos se acertou
        if ($correta) {
            $conn->query("UPDATE jogadores SET pontos = pontos + 100 WHERE id=$jogador_id");
            $pontos += 100;
        }

        // Define feedback na sessão
=======
        $sql = "INSERT INTO respostas (jogador_id, pergunta_id, resposta, correta)
                VALUES (:jogador_id, :pergunta_id, :resposta, :correta)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':jogador_id', $jogador_id);
        $stmt->bindParam(':pergunta_id', $pergunta['id']);
        $stmt->bindParam(':resposta', $resposta_usuario);
        $stmt->bindParam(':correta', $correta);
        $stmt->execute();

        if ($correta) {
            $sql = "UPDATE jogadores SET pontos = pontos + 100 WHERE id = :jogador_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':jogador_id', $jogador_id);
            $stmt->execute();
            $pontos += 100;
        }

>>>>>>> Pronto
        $_SESSION['jogo']['feedback'] = [
            'resposta_usuario' => $resposta_usuario,
            'resposta_correta' => $resposta_correta,
            'mensagem' => $correta ? "✅ Acertou" : "❌ Errou"
        ];
        $_SESSION['jogo']['inicio_feedback'] = time();
    }
}

<<<<<<< HEAD
// Define a pergunta atual se não estiver em feedback
if (!$_SESSION['jogo']['feedback']) {
    $pergunta = proximaPergunta($conn, $categoria, $jogador_id);
=======
if (!$_SESSION['jogo']['feedback']) {
    $pergunta = proximaPergunta($pdo, $categoria, $jogador_id);
>>>>>>> Pronto
    if ($pergunta) {
        $_SESSION['jogo']['pergunta_atual_id'] = $pergunta['id'];
        $_SESSION['jogo']['inicio_questao'] = $_SESSION['jogo']['inicio_questao'] ?? time();
    }
} else {
<<<<<<< HEAD
    $pergunta = $conn->query("SELECT * FROM perguntas WHERE id={$_SESSION['jogo']['pergunta_atual_id']}")->fetch_assoc();
}

// Calcula tempo restante
=======
    $sql = "SELECT * FROM perguntas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $_SESSION['jogo']['pergunta_atual_id'], PDO::PARAM_INT);
    $stmt->execute();
    $pergunta = $stmt->fetch(PDO::FETCH_ASSOC);
}

>>>>>>> Pronto
if ($_SESSION['jogo']['feedback']) {
    $tempo_passado = time() - $_SESSION['jogo']['inicio_feedback'];
    $tempo_restante = TEMPO_FEEDBACK - $tempo_passado;
    if ($tempo_restante <= 0) {
<<<<<<< HEAD
        // Limpa feedback e vai para próxima pergunta
        $_SESSION['jogo']['feedback'] = null;
        $_SESSION['jogo']['inicio_feedback'] = null;
        $_SESSION['jogo']['resposta_usuario'] = null;
        $_SESSION['jogo']['resposta_correta'] = null;
        $_SESSION['jogo']['pergunta_atual_id'] = null;
        $_SESSION['jogo']['inicio_questao'] = null;
=======
        $_SESSION['jogo'] = [
            'pergunta_atual_id' => null,
            'inicio_questao' => null,
            'feedback' => null,
            'inicio_feedback' => null,
            'resposta_usuario' => null,
            'resposta_correta' => null,
        ];
>>>>>>> Pronto
        header("Location: jogo.php");
        exit;
    }
} else if ($pergunta) {
    $tempo_passado = time() - $_SESSION['jogo']['inicio_questao'];
    $tempo_restante = TEMPO_QUESTAO - $tempo_passado;
    if ($tempo_restante <= 0) {
<<<<<<< HEAD
        // Timeout automático
=======
>>>>>>> Pronto
        $_POST['timeout'] = 1;
        $_POST['resp'] = null;
        header("Location: jogo.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>QuizTec - Jogo</title>
    <link rel="stylesheet" href="css/style_Jogo.css">
    <style>
        .alternativa { display:block; margin:5px 0; padding:5px; border-radius:5px; }
        .correta { background-color: #4CAF50; color:white; }
        .errada { background-color: #f44336; color:white; }
    </style>
    <script>
        // Bloqueia F5 manualmente
        document.addEventListener("keydown", function(e) {
            if ((e.which || e.keyCode) == 116) e.preventDefault();
        });
    </script>
</head>
<body>
<h1>🎯 QuizTec - Categoria: <?= htmlspecialchars($categoria) ?></h1>
<p>👤 Jogador: <?= htmlspecialchars($nome_jogador) ?> | 💰 Pontos: <?= $pontos ?></p>

<?php if ($pergunta): ?>
    <form method="post" id="quizForm">
        <p><b><?= htmlspecialchars($pergunta['enunciado']) ?></b></p>
        <?php
        $alternativas = ['A' => 'alternativa_a', 'B' => 'alternativa_b', 'C' => 'alternativa_c', 'D' => 'alternativa_d'];
        foreach ($alternativas as $letra => $campo):
            $classe = "";
            if ($_SESSION['jogo']['feedback']) {
                if ($letra == $_SESSION['jogo']['feedback']['resposta_correta']) $classe = "correta";
                elseif ($letra == $_SESSION['jogo']['feedback']['resposta_usuario']) $classe = "errada";
            }
        ?>
        <label class="alternativa <?= $classe ?>">
            <input type="radio" name="resp" value="<?= $letra ?>" <?= $_SESSION['jogo']['feedback'] ? "disabled" : "required" ?>>
            <?= htmlspecialchars($pergunta[$campo]) ?>
        </label>
        <?php endforeach; ?>
<?php if (!$_SESSION['jogo']['feedback']): ?>
    <p>⏱ Tempo restante: <span id="timer"><?= $tempo_restante ?></span>s</p>
    <button type="submit">Responder</button>
<?php else: ?>
    <p><b><?= $_SESSION['jogo']['feedback']['mensagem'] ?></b></p>
    <script>
        // Depois de X segundos, avança sozinho
        setTimeout(() => {
            window.location.reload();
        }, <?= TEMPO_FEEDBACK * 1000 ?>);
    </script>
<?php endif; ?>

    </form>

    <script>
    <?php if (!$_SESSION['jogo']['feedback']): ?>
    let timeLeft = <?= $tempo_restante ?>;
    const timerEl = document.getElementById('timer');
    const form = document.getElementById('quizForm');

    const countdown = setInterval(() => {
        timeLeft--;
        timerEl.textContent = timeLeft;
        if(timeLeft <= 0){
            clearInterval(countdown);
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'timeout';
            input.value = '1';
            form.appendChild(input);
            form.submit();
        }
    }, 1000);
    <?php endif; ?>
    </script>

<?php else: ?>
    <p>🏁 Você respondeu todas as perguntas dessa categoria!</p>
    <p>Veja o <a href="ranking.php">Ranking ao vivo</a>.</p>
    <p><a href="index.php">🔄 Jogar novamente em outra categoria</a></p>
<?php endif; ?>
</body>
</html>

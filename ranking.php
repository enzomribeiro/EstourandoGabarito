<?php
// ranking.php
include 'conexao.php'; // garante que puxa o arquivo da mesma pasta

// Pegar jogadores ordenados por pontos
$sql = 'SELECT * FROM jogadores ORDER BY pontos DESC';
$stmt = $pdo->prepare($sql);
$rows = [];
while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)){
    $rows[] = $row;
}

// Separar top3 e resto
$top3 = array_slice($rows, 0, 3);
$resto = array_slice($rows, 3);

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Ranking - QuizTec</title>
    <link rel="stylesheet" href="css/style_Rank.css">
    <meta http-equiv="refresh" content="5">
</head>
<body>
    <h1>🏆 Ranking ao vivo</h1>

    <!-- Troféus dos 3 primeiros -->
    <div class="trofeus">
        <?php if (!empty($top3[0])): ?>
            <div class="trofeu primeiro">
                <span>🥇</span>
                <p><?= htmlspecialchars($top3[0]['nome']) ?> - <?= $top3[0]['pontos'] ?> pts</p>
            </div>
        <?php endif; ?>
        <?php if (!empty($top3[1])): ?>
            <div class="trofeu segundo">
                <span>🥈</span>
                <p><?= htmlspecialchars($top3[1]['nome']) ?> - <?= $top3[1]['pontos'] ?> pts</p>
            </div>
        <?php endif; ?>
        <?php if (!empty($top3[2])): ?>
            <div class="trofeu terceiro">
                <span>🥉</span>
                <p><?= htmlspecialchars($top3[2]['nome']) ?> - <?= $top3[2]['pontos'] ?> pts</p>
            </div>
        <?php endif; ?>
    </div>

    <!-- Tabela dos demais -->
    <table>
        <tr><th>Posição</th><th>Jogador</th><th>Pontos</th></tr>
        <?php 
        $pos = 1;
        foreach ($rows as $row) {
            echo "<tr>
                    <td>$pos</td>
                    <td>" . htmlspecialchars($row['nome']) . "</td>
                    <td>" . $row['pontos'] . "</td>
                  </tr>";
            $pos++;
        }
        ?>
    </table>

    <div class="button"><a href="index.php">HOME</a></div>
</body>
</html>

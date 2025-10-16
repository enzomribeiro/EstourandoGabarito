<?php
    include "./conexao.php";

    // Conecta ao banco SQLite (Cria o arquivo se não existir)
    try {
        $db = new PDO("sqlite:" . __DIR__ . "./quiztecSQLite.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
    } catch (PDOException $th) {
        die("Erro de conexão com SQLite: " . $th->getMessage());
    }

    function UploadSQL($db){
        $sqlFile = __DIR__ . "./quiztecSQLite.sql";
        //  Se o banco foi recém-criado ou está vazio, executa o script
        if(file_exists($sqlFile)){
            $sql = file_get_contents($sqlFile);
            $db->exec($sql);
        }
    }

    function Registro_Backup($sql){

    }

    // Adiciona jogador no bando de dados SQLite
    function adicionar_player($db, $cod, $nome) {
        try {
            $sql = "INSERT INTO jogadores (codigo, nome) VALUES (:cod, :nome)";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':cod', $cod);
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();

            echo "Jogador inserido com sucesso!<br>";

        } catch (PDOException $e) {
            echo "Erro ao inserir jogador: " . $e->getMessage();
        }
    }

    function listarPerguntas($db) {
        try {
            $sql = "SELECT * FROM perguntas";
            $stmt = $db->prepare($sql);
            while ($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
                echo $row['enunciado'] . "<br>";
            }
        } catch (PDOException $e) {
            echo "Erro ao listar perguntas: " . $e->getMessage();
        }
    }

        // Adiciona usuário administrador no server MySQL
        function AddUserMySQL($newUser, $newPass){
            $host = 'localhost';
            $db_name = 'quizetec';
            $username = "root";
            $pass = '12345678';
            $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";

            try {
                $pdo = new PDO($dsn, $username, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "INSERT INTO admins (usuario, senha) VALUES (:newUser, SHA2(:newPass, 256))";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':newUser', $newUser, PDO::PARAM_STR);
                $stmt->bindParam(':newPass', $newPass, PDO::PARAM_STR);
                $stmt->execute();
                echo "Admin inserido com sucesso";
            } catch (PDOException $e) {
                echo "Erro ao adicionar usuário: " . $e->getMessage();
            }
        }
?>

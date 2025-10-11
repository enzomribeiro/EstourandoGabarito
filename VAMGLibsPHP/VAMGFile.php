<?php
    class BackupBD {
        protected $db;

        public function __construct() {
            try {
                $this->db = new PDO("sqlite:" . __DIR__ . "./quiztecSQLite.db");
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $th) {
                die("Erro de conexão com SQLite: " . $th->getMessage());
            }
        }

        public function adicionar_player($cod, $nome) {
            try {
                $stmt = $this->db->prepare("INSERT INTO jogadores (codigo, nome) VALUES (:cod, :nome)");
                $stmt->bindParam(':cod', $cod);
                $stmt->bindParam(':nome', $nome);
                $stmt->execute();

                echo "Jogador inserido com sucesso!<br>";

            } catch (PDOException $e) {
                echo "Erro ao inserir jogador: " . $e->getMessage();

            } catch (Exception $e){
                echo "Erro ao gerar número";

            }
        }


        public function listarPerguntas() {
            try {
                $stmt = $this->db->query("SELECT * FROM perguntas");
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo $row['enunciado'] . "<br>";
                }
            } catch (PDOException $e) {
                echo "Erro ao listar perguntas: " . $e->getMessage();
            }
        }

        function AddUserMySQL($newUser, $newPass){
            $host = 'localhost';
            $db_name = 'quizetec';
            $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
            $username = "root";
            $pass = '12345678';

            try {
                $pdo = new PDO($dsn, $username, $pass);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                $sql = "INSERT INTO admins (usuario, senha) VALUES (:newUser, SHA2(:newPass, 256))";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':newUser', $newUser, PDO::PARAM_STR);
                $stmt->bindParam(':newPass', $newPass, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $e) {
                echo "Erro ao adicionar usuário: " . $e->getMessage();
            }
        }
    }

    // Faz teste
    $backup = new BackupBD();
    // $backup->AddUserMySQL("Victor Alex", "");
?>

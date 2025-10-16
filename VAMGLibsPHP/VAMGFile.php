<?php
    class BackupBD {
        protected $db;

        public function __construct() {
            try {
                // Conecta ao banco SQLite (Cria o arquivo se não existir)
                $this->db = new PDO("sqlite:" . __DIR__ . "./quiztecSQLite.db");
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
            } catch (PDOException $th) {
                die("Erro de conexão com SQLite: " . $th->getMessage());
            }
        }
        
        public function UploadSQL(){
            $sqlFile = __DIR__ . "./quiztecSQLite.sql";
            //  Se o banco foi recém-criado ou está vazio, executa o script
            if(file_exists($sqlFile)){
                $sql = file_get_contents($sqlFile);
                $this->db->exec($sql);
            }
        }

        // Adiciona jogador no bando de dados SQLite
        public function adicionar_player($cod, $nome) {
            try {
                $sql = "INSERT INTO jogadores (codigo, nome) VALUES (:cod, :nome)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(':cod', $cod);
                $stmt->bindParam(':nome', $nome);
                $stmt->execute();

                echo "Jogador inserido com sucesso!<br>";

            } catch (PDOException $e) {
                echo "Erro ao inserir jogador: " . $e->getMessage();
            }
        }

        public function listarPerguntas() {
            try {
                $sql = "SELECT * FROM perguntas";
                $stmt = $this->db->prepare($sql);
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
            $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
            $username = "root";
            $pass = '';

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
?>

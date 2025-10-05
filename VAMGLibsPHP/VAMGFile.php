<?php
    class BackupBD {
        protected $db;

        public function __construct() {
            try {
                $this->db = new PDO('sqlite:quiztecSQLite.db');
                $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $th) {
                die("Erro de conexão com SQLite: " . $th->getMessage());
            }
        }

        public function addJogador($cod, $nome, $pontos) {
            try {
                // Verifica se já existe um jogador com esse código
                $stmt = $this->db->prepare("SELECT COUNT(*) FROM jogadores WHERE codigo = :cod");
                $stmt->bindParam(':cod', $cod);
                $stmt->execute();
                $existe = $stmt->fetchColumn();

                if ($existe > 0) {
                    echo "Jogador com código $cod já existe.<br>";
                    return;
                }

                // Se não existe, insere
                $stmt = $this->db->prepare("INSERT INTO jogadores (codigo, nome, pontos) VALUES (:cod, :nome, :pontos)");
                $stmt->bindParam(':cod', $cod);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':pontos', $pontos);
                $stmt->execute();

                echo "Jogador inserido com sucesso!<br>";
            } catch (PDOException $e) {
                echo "Erro ao inserir jogador: " . $e->getMessage();
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
    }

    /*Acessando os dados do index.php*/
    session_start();

    // Verifica se os dados estão disponiveis
    if(isset($_SESSION['categoria']) && isset($_SESSION['codigo']) && isset($_SESSION['nome'])){
        
        $categoria = $_SESSION['categoria'];
        $codi = $_SESSION['codigo'];
        $nome = $_SESSION['nome'];

        /* Decidir o que fazer com os dados do usuário do formulario*/

        // Somar os pontos caso o usuário já exista
        // Verifica se o usuário já existe


    } else {
        echo "Dados não foram encontrados. Volte para o início";

    }

    // Exemplo de uso
    // $backup = new BackupBD();
    // $backup->listarPerguntas();


?>

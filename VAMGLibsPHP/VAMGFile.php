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
                $stmt->bindParam(':cod', $gen_num);
                $stmt->execute();
                $existe = $stmt->fetchColumn();

                if ($existe > 0) {
                    echo "Jogador com código $cod já existe.<br>";
                    return;
                }

                // Se não existe, insere
                $stmt = $this->db->prepare("INSERT INTO jogadores (codigo, nome, pontos) VALUES (:cod, :nome, :pontos)");
                $stmt->bindParam(':cod', $gen_num);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':pontos', $pontos);
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
    }

?>

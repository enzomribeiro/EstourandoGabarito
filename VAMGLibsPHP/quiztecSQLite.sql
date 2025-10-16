-- SQLite Dump Adaptado

-- Tabela: admins
DROP TABLE IF EXISTS admins;
CREATE TABLE admins (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  usuario TEXT NOT NULL UNIQUE,
  senha TEXT NOT NULL
);

INSERT INTO admins (id, usuario, senha) VALUES
(1, 'admin', '0cc6297150ce07731cd98bb3e25f73a874c8e1f6fb5c1be4dfc20c6887585ca3'),
(2, "VAMG", "51:0c:c6:2c:47:4b:14:f2:cb:21:84:b1:9d:78:0d:2c:25:30:c0:01:81:f6:01:09:f5:02:7f:e0:c3:44:95:bc");

-- Tabela: jogadores
DROP TABLE IF EXISTS jogadores;
CREATE TABLE jogadores (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  codigo TEXT NOT NULL UNIQUE,
  nome TEXT,
  pontos INTEGER DEFAULT 0
);

-- Tabela: perguntas
DROP TABLE IF EXISTS perguntas;
CREATE TABLE perguntas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  enunciado TEXT NOT NULL,
  alternativa_a TEXT,
  alternativa_b TEXT,
  alternativa_c TEXT,
  alternativa_d TEXT,
  correta TEXT NOT NULL,
  categoria TEXT DEFAULT 'Geral'
);

-- Tabela: respostas
DROP TABLE IF EXISTS respostas;
CREATE TABLE respostas (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  jogador_id INTEGER,
  pergunta_id INTEGER,
  resposta TEXT,
  correta INTEGER,
  FOREIGN KEY (jogador_id) REFERENCES jogadores(id),
  FOREIGN KEY (pergunta_id) REFERENCES perguntas(id)
);

INSERT INTO perguntas (id, enunciado, alternativa_a, alternativa_b, alternativa_c, alternativa_d, correta, categoria) VALUES
  (1, 'Quem dirigiu o filme Jurassic Park (1993)?', 'James Cameron', 'Steven Spielberg', 'George Lucas', 'Ridley Scott', 'B', 'Geral'),
  (2, 'Em O Senhor dos Anéis, qual é o nome da montanha onde o Anel deve ser destruído?', 'Montanha da Perdição', 'Montanha Sombria', 'Colina de Mordor', 'Monte Cinzento', 'A', 'Filmes'),
  (4, 'Qual o maior planeta do sistema solar?', 'Terra', 'Jupiter', 'Saturno', 'Netuno', 'B', 'Geral'),
  (5, 'Qual é o maior oceano do mundo ?', 'Atlântico', 'Pacífico', 'índico', 'Àrtico', 'B', 'Geral'),
  (6, 'Em que ano o homem pisou na Lua pela primeira vez?', '2009', '1969', '1988', '1500', 'B', 'Ciência'),
  (7, 'Quanto é 8 x 7 ?', '54', '56', '60', '58', 'B', 'Geral'),
  (8, 'Em que continente fica o egito ?', 'ásia', 'Europa', 'áfrica', 'América', 'C', 'História'),
  (9, 'Em Harry Potter, qual é o feitiço usado para desarmar o oponente?', 'Expelliarmus', 'Lumos', 'Wingardium Leviosa', 'Avada Kedrava', 'A', 'Filmes'),
  (10, 'Quem interpretou o personagem "Jack" em Titanic (1997) ?', 'Brad Pitt', 'Johnny Depp', 'Leonardo DiCaprio', 'Tom cruise', 'C', 'Filmes'),
  (11, 'Qual é o país mais populoso do mundo?', 'Índia', 'China', 'EUA', 'Indonésia', 'A', 'Geral'),
  (12, 'Qual é o nome do vilão principal em Vingadores:Guerra infinita ?', 'Loki', 'Thanos', 'Ultron', 'Magneto', 'B', 'Filmes'),
  (13, 'Qual o nome do brinquedo astronauta em Toy Story ?', 'Buzz Lightyear', 'Woody', 'Rex', 'Sr. Cabeça de Batata', 'A', 'Filmes'),
  (14, 'Em de volta para o futuro,qual é o nome do cientista maluco ?', 'Dr.Brown', 'Dr.Who', 'Dr.Evil', 'Dr.Doom', 'A', 'Filmes'),
  (15, 'Quem interpreta o Coringa no filme Coringa (2019) ?', 'Jared Leto', 'Heath Ledger', 'Joaquin Phoenix', 'Christian Bale', 'C', 'Filmes'),
  (16, 'Em qual filme da Disney aparece a música Let it Go ?', 'Moana', 'A Bela e a Fera', 'Frozen ', 'Encanto', 'C', 'Filmes'),
  (17, 'O Rei Leão,qual é o nome do pai de Simba ?', 'Scar', 'Timão', 'Mufasa', 'Rafiki', 'C', 'Filmes'),
  (18, 'Qual filme ganhou o Oscar de melhor filme em 2020 ?', '1917', 'Coringa', 'Parasita', 'Era uma vez em....Hollywood', 'C', 'Filmes'),
  (19, 'Quem foi o primeiro presidente do Brasil?', 'Prudente de Moraes', 'Costa e Silva', 'Deodoro da Fonseca', 'Juscelino Kubitschek', 'C', 'Geral'),
  (20, 'Qual a capital da França?', 'Berlim', 'Roma', 'Madri', 'Paris', 'D', 'Geral'),
  (21, 'Qual é o idioma mais falado no mundo?', 'Inglês', 'Espanhol', 'Mandarim', 'Árabe', 'C', 'Geral'),
  (22, 'Qual é a moeda oficial Japão?', 'Yuan', 'Dólar', 'Iene', 'Won', 'C', 'Geral'),
  (23, 'Quantos continentes existem na Terra?', '5', '6', '7', '8', 'C', 'Geral'),
  (24, 'Qual é o gás mais abundante na atmosfera da Terra?', ' Oxigênio', ' Dióxido de carbono ', 'Nitrogênio ', ' Hélio', 'C', 'Ciência'),
  (25, 'Qual é a unidade básica da vida?', 'Célula', 'Molécula', 'Tecido', 'Átomo', 'A', 'Ciência'),
  (26, 'Qual órgão do corpo humano é responsável por bombear o sangue?', 'Pulmão', 'Estômago', 'Coração', 'Fígado', 'C', 'Ciência'),
  (27, 'Como se chama a mudança do estado gasoso para o líquido?', 'Fusão', 'Sublimação', 'Vaporização', 'Condensação', 'D', 'Ciência'),
  (28, 'Qual cientista propôs a teoria da gravidade após observar uma maçã cair?', 'Albert Einstein', 'Galileu Galilei', 'Nikola Tesla', 'Isaac Newton', 'D', 'Ciência'),
  (29, 'A fotossíntese é um processo realizado por:', 'Animais', 'Plantas', 'Vírus', 'Fungos', 'B', 'Ciência'),
  (30, 'Qual é o maior osso do corpo humano?', 'Fêmur', 'Úmero', 'Tíbia', 'Coluna', 'A', 'Ciência'),
  (31, 'O que é H₂O?', 'Hidrogênio puro', 'Água', 'Gás oxigênio', 'Peróxido de hidrogênio', 'B', 'Ciência'),
  (32, '. Quantos planetas existem no sistema solar (desde 2006)?', '8', '5', '7', '4', 'A', 'Ciência'),
  (33, 'Qual foi a missão que levou o homem a Lua?', 'Apollo 13', 'Sputnik 1', 'Vostok 1', 'Apollo 11', 'D', 'História'),
  (34, 'Em que ano foi abolida a escravidão no Brasil?', '1945', '1888', '1873', '1920', 'B', 'História'),
  (35, 'Qual dos países não participou da guerra do Paraguai?', 'Brasil', 'Uruguai', 'Bolivia', 'Argentina', 'C', 'História'),
  (36, 'Qual é a marca do primeiro carro que usamos no inicio de Need for Speed Monst Wanted (PS2)?', 'BMW', 'Audi', 'Mustang', 'Volkswagen', 'A', 'Games'),
  (37, 'Qual dessas cidades já foi uma capital brasileira?', 'Belo Horizonte (MG)', 'Salvador (BA)', 'São Paulo (SP)', 'João Pessoa (PB)', 'B', 'História'),
  (38, 'Na serie de games Devil May Cry há uma quantidade fixa de fases, quantas são?', '15', '10', '30', '20', 'D', 'Games'),
  (39, 'Quem era o presidente do Brasil no periodo do estado novo? (1937-1945)', 'Prudente de Moraes', 'Campos Sales', 'Getulio Vargas', 'Nilo Peçanha', 'C', 'História'),
  (40, 'Resident Evil serviu de inspiração para qual dos games há baixo?:', 'Castlevania', 'Diablo', 'Devil May Cry ', 'Silent Hill', 'C', 'Games'),
  (41, 'Qual dos eventos abaixo não aconteceu na Guerra Fria?', 'Dia D', 'Crise dos Mísseis', 'Guerra do Vietnã', 'Guerra das Coréias', 'A', 'História'),
  (42, 'Quantos jogos foram produzidos para o PlayStation 2?', '1.500', 'mais de 8.000', 'Mais de 4.000', 'Aproximadamente 2.500', 'C', 'Games'),
  (43, 'Qual dos filósofos abaixo fundou "A Academia" na Grécia Antiga?', 'Sócrates', 'Pitágoras', 'Aristóteles', 'Platão', 'D', 'História'),
  (44, 'Qual foi a frase que D.Pedro l gritou as margens do Rio Ipiranga?', '"Pelo bem de Portugal, ficaremos unidos!"', '"É chegada a hora da liberdade brasileira!"', '"O Brasil será livre, com ou sem a coroa!"', '"Independência ou morte!"', 'D', 'História'),
  (45, 'O game DOOM de 1993 para MS-DOS pertence a qual gênero de game?', 'FPS ', 'Rancking Slash', 'Luta', 'RPG', 'A', 'Games'),
  (46, 'No GTA San Andreas qual é o nome do protagonista?', ' Niko Bellic', 'Tommy Vercetti', 'Franklin Clinton', 'Carl Johnson V', 'D', 'Games'),
  (47, 'Qual é o nome do dinossauro verde presente nos games do Mario', 'Yoshi', 'Donkey Kong', 'Bowser', 'T-Rex', 'A', 'Games'),
  (48, 'Das causas abaixo, qual não tem relação com a ploriferação da Peste Negra?', 'Ratos', 'Pulgas', 'Partículas no ar', 'Falta de higiene', 'C', 'História'),
  (49, 'Em The Last Of Us como que surgio a infecçao ?', 'Uma droga', 'Experimento governamental com fungos', 'Evolução natural do humano', 'Uma guerra nuclear', 'B', 'Games'),
  (50, 'Os satélites naturais são astros que circulam em torno de um planeta principal. Qual é o nome do satélite natural da Terra?', 'Sol', 'Cometas', 'Lua', 'Estrela', 'C', 'Ciência'),
  (51, 'Qual é o nome do protagonista de assassins creed 2', 'Lorenzo di Firenze', 'Giovanni Rossi', 'Ezio Auditore', 'Mardos Venturi', 'C', 'Games'),
  (52, 'O que matou Alexandre o Grande?', 'Doença que desenvolveu na Babilônia', 'Batalha na região da atual Rússia', 'Suicídio após isolamento', 'Revolta da plebe francesa', 'A', 'História'),
  (53, 'No jogo Days Gone qual é o ojetivo do Deacon no inicio do jogo?', 'Achar a cura para os Freakers', 'Se vingar da facção dos Mongrels', 'Ajudar seu amigo Boozer a se tornar lider de um acampamento', 'Sobreviver e encontrar sua esposa, Sarah ', 'D', 'Games'),
  (54, 'Em Red Death Redeption 1, qual é a motivação pessoal mais forte que leva John Marston a aceitar o acordo do governo para caçar seus antigos parceireiros?', 'Vingança', 'Garantir a liberdade de sua família', 'Dinheiro', 'Recuperar sua honra', 'B', 'Games'),
  (55, 'Quais os três estados físicos da água durante seu ciclo?', 'Liquido, Difuso e Gasoso', 'Liquido, Gasoso e Condensado', 'Solido, Gasoso e Liquefação', 'Liquido, Solido e Gasoso', 'D', 'Ciência'),
  (56, 'Na franquia God of War qual foi o mais vendido?', 'God of War 2018', 'God of War Ragnarok', 'God of War II', 'God of War', 'A', 'Games'),
  (57, 'Quem criou o primeiro computador?', 'Alan Turing', 'Albert Einstein', 'Robert Oppenheimer', 'Donald Bayley', 'A', 'História'),
  (58, 'Qual foi a funcionalidade da picina de bolinha na pizzaria em Fnaf Into the Pit?', 'Revelar memórias esquecidas do Oswald', 'Apenas um elemento decorativo', 'Transportar para o passado ', 'Revelar onde os animatrônicos se escondem', 'C', 'Games'),
  (59, 'Quem foi que substituiu o pai de Oswald em Fnaf Into The Pit?', 'Uma versão distorcida do Oswald', 'Freddy Fazbear', 'Springtrap', 'Coelho dourado (Spring Bonnie)', 'D', 'Games'),
  (60, 'Como fazer o craft do cristal do end no minecraft?', '4 obsidian, 2 diamante, 1 livro', '7 Vidros, 1 lagrima de gast, 1 olho do end', ' 8 Obsidian, 1 olho do end', '3 Obsidian, 5 vidros, 1 estrela do nether', 'B', 'Games'),
  (61, 'Em Hollow Knight qual é o amuleto que revela sua localização do mapa?', 'Devorador de Almas (Soul Eater)', 'Pedra do Xamã (Shaman Stone)', 'Mestre da Corrida (Sprintmaster)', 'Bússola Caprichosa ((Wayward Compass)', 'D', 'Games'),
  (63, 'No jogo Cavaleiro dos Zodiacos Alma dos soldados quantas sagas estão presentes', ' 4 Sagas', '12 Sagas', '6 Sagas', '1 Saga', 'A', 'Games'),
  (64, 'Qual das seguintes opções é um exemplo de um mamífero?', 'Morcego', 'Tubarão', 'Pinguim', 'Jacaré', 'A', 'Ciência'),
  (65, 'Qual a empresa desenvolveu a franquia Uncharted?', 'Square Enix', 'Ubisoft', 'Naughty Dog', 'Rockstar Games', 'C', 'Games'),
  (66, 'Quem guia o jogador como kaioshin do tempo em Dragon Ball Xenoverse 2?', 'Vados', 'Chronoa', 'Whis', 'Bulma', 'B', 'Games'),
  (67, 'Qual a alternativa apresenta seis biomas brasileiros?', 'Floresta Amazônica, Mata Atlântica, Cerrado, Caatinga, Pantanal e Pampas.', 'Acre, Bahia, Pará, Pernambuco, Sergipe e Manaus.', 'Areia, barro, pedra, argila, palha e seixo.', 'Rio, igarapé, praia, riacho, cachoeira e nascente.', 'A', 'Ciência'),
  (68, 'Qual destas doenças NÃO são causadas por bactérias ?', 'Tuberculose', 'Dengue', ' Botulismo', 'Leptospirose', 'B', 'Biologia'),
  (69, 'Uma campanha destinada a evitar a proliferação de mosquitos que transmitem a DENGUE, extinguiria ao mesmo tempo os transmissores da:', 'Doença de Chagas', 'Esquistossomose', 'Febre Amarela', 'Poliomielite', 'C', 'Biologia'),
  (70, 'O uso de drogas injetáveis com o compartilhamento de seringas e agulhas não esterilizadas e um grave fator de risco para a transmissão de diversas soenças exceto:', 'Sifilis', 'Hepatite A', 'Hepatite B', 'AIDS', 'A', 'Biologia'),
  (71, 'Para não se contraírem doenças como Cisticercose e Teníase devem se evitar:', 'Nadar em lagoas desconhecidas', 'Andar descalço', 'Comer carne Suína e Bovina malpassada', 'Comer verduras mal lavadas', 'C', 'Biologia'),
  (72, 'Assinale a alternativa que apresenta parasitas que NÃO envolvem mosquito como agente transmissor', 'Elefantíase', 'Leishmaniose', 'Malária', 'Esquistossomose', 'D', 'Biologia'),
  (73, '(Fuvest) Uma pessoa tem alergia a moluscos. Em um restaurante onde são servidos "Frutos Do Mar", ela pode comer, sem problemas, pratos que contenham:', 'Lula e Camarão', 'Polvo e Caranguejo', 'Mexilhão e Lagosta', 'Lula e Polvo', 'D', 'Biologia'),
  (74, 'Qual é o vetor da Doença de Chagas?', 'Mosquito', 'Barbeiro', 'Carrapato', 'Mosca', 'B', 'Biologia');
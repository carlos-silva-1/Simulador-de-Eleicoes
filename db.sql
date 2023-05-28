DROP TABLE IF EXISTS Vereador, Prefeito, Vice;

CREATE TABLE Vereador (
    numeros VARCHAR(5) NOT NULL,
    nome VARCHAR(255),
    partido VARCHAR(255),
    foto VARCHAR(255),
    votos INT DEFAULT 0,
    PRIMARY KEY (numeros)
);

CREATE TABLE Prefeito (
    numeros VARCHAR(2) NOT NULL,
    nome VARCHAR(255),
    partido VARCHAR(255),
    foto VARCHAR(255),
    votos INT DEFAULT 0,
    PRIMARY KEY (numeros)
);

CREATE TABLE Vice (
    numeros VARCHAR(2),
    nome VARCHAR(255),
    partido VARCHAR(255),
    foto VARCHAR(255),
    FOREIGN KEY (numeros) REFERENCES Prefeito(numeros)
);

INSERT INTO Vereador (numeros, nome, partido, foto) VALUES
("51222", "Christianne Varão", "PEN", "cv1.jpg"),
("55555", "Homero do Zé Filho", "PSL", "cv2.jpg"),
("43333", "Dandor", "PV", "cv3.jpg"),
("15123", "Filho", "MDB", "cv4.jpg"),
("27222", "Joel Varão", "PSDC", "cv5.jpg"),
("45000", "Professor Clebson Almeida", "PSDB", "cv6.jpg");

INSERT INTO Prefeito (numeros, nome, partido, foto) VALUES
("12", "Chiquinho do Adbon", "PDT", "cp3.jpg"),
("15", "Malrinete Gralhada", "MDB", "cp2.jpg"),
("45", "Dr. Francisco", "PSC", "cp1.jpg"),
("54", "Zé Lopes", "PPL", "cp4.jpg"),
("65", "Lindomar Pescador", "PC do B", "cp5.jpg");

INSERT INTO Vice (numeros, nome, partido, foto) VALUES
("12", "Arão", "PRP", "v3.jpg"),
("15", "Biga", "MDB", "v2.jpg"),
("45", "João Rodrigues", "PV", "v1.jpg"),
("54", "Francisca Ferreira Ramos", "PPL", "v4.jpg"),
("65", "Malú", "PC do B", "v5.jpg");

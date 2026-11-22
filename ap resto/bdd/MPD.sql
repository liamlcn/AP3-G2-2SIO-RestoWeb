-- Création --

CREATE DATABASE IF NOT EXISTS apresto;
USE apresto;

CREATE TABLE utilisateur(
   idUTIL BIGINT AUTO_INCREMENT,
   emailUtil VARCHAR(100),
   loginUtil VARCHAR(100),
   mdpUtil VARCHAR(255),
   PRIMARY KEY(idUTIL)
);

CREATE TABLE commande(
   idCOM       BIGINT AUTO_INCREMENT,
   etatCOM VARCHAR(30),
   date_horaireCOM DATETIME,
   valeurTTC DECIMAL(13,3),
   typeCOM VARCHAR(50),
   TVA TINYINT UNSIGNED,
   idUTIL BIGINT NOT NULL,
   PRIMARY KEY(idCOM),
   FOREIGN KEY(idUTIL) REFERENCES utilisateur(idUTIL)
);

CREATE TABLE produit(
   idPROD BIGINT AUTO_INCREMENT,
   libellePROD VARCHAR(100),
   prixHT DECIMAL(13,3),
   PRIMARY KEY(idPROD)
);

CREATE TABLE ligne_de_commande(
   idLIGNCOM   BIGINT AUTO_INCREMENT,
   quantiteProduit INT,
   totalHT DECIMAL(13,3),
   idCOM BIGINT NOT NULL,
   idPROD BIGINT NOT NULL,
   PRIMARY KEY(idLIGNCOM),
   FOREIGN KEY(idCOM) REFERENCES commande(idCOM),
   FOREIGN KEY(idPROD) REFERENCES produit(idPROD)
);

ALTER TABLE commande MODIFY TVA DECIMAL(5,2);

--ALTER TABLE commande            MODIFY idCOM       BIGINT AUTO_INCREMENT;
--ALTER TABLE ligne_de_commande   MODIFY idLIGNCOM   BIGINT AUTO_INCREMENT;

-- =================================================================================================
-- =================================================================================================
-- Remplissage --

INSERT INTO `produit`(`libellePROD`, `prixHT`)
VALUES ('Pizza 5 fromages','13'),
('Tacos 3 viandes','11'),
('Poulet roti (2kg)','20'),
('Nouiles sautées','10'),
('Sachet de frites','6'),
('Salade César','10'),
('Magret de canard','20'),
('Foie gras (pot)','8'),
('Coeurs de canards (0,5kg)','7'),
('Pizza Margerita','10'),
('Eau plate (bouteille 33cl)','4'),
('Coca Cola (canette 33cl)','4'),
('Perrier (bouteille 0,5L)','5');


INSERT INTO `utilisateur` (`idUTIL`, `emailUtil`, `loginUtil`, `mdpUtil`) VALUES
(1, 'test.test@test.test', 'test test', '$2y$10$ENyMAlql1ixrosKtA8bVLuIx7gcAPT9cgXqV48jOT628.BsPONbRK'), -- oublier
(2, 'admin@foodexpress.fr', 'admin foodexpress', '$2y$10$o4x9W1nXqUJB1lV6.95qN.cTpadK5CBMy871EpgYPtLWwvs6YMyHe'), -- adm1234
(3, 'jean.dupont@email.com', 'jean dupont', '$2y$10$e1JyP.H6QA6cb/LK./4JVO90jBC12LdfwaY4R.Fot9JAOIH8iqUWi'), -- mdp1234
(4, 'marie.cerise@email.com', 'marie cerise', '$2y$10$3Ov2kB.1CkvnUlVPucD2KelSgdtS43dzwm6pZlooiM/zSdVohGwIy'), -- mdp1234
(5, 'paul.martin@email.com', 'paul martin', '$2y$10$R84WUwEJf3omzmZaMATgOeGiXKYzl9ChFHTLJ2GK.JVZCIDNYxyQS'), -- mdp1234
(6, 'sophie.bernard@email.com', 'sophie bernard', '$2y$10$kY9o7kqBvmhlXeaUQLzrjO.asLmvOR5k1UvjUZW79MIVoqLLMcq7O'), -- mdp1234
(7, 'lucas.petit@email.com', 'lucas petit', '$2y$10$Qx0yNUa6xrEEv9QP5XKWdu/sLoi5Pe11FBxkExSiZzTzbZlE1Bdqi'), -- mdp1234
(8, 'emma.robert@email.com', 'emma robert', '$2y$10$iTpXeRQmftoVzcGX5ZfWeuHr21it0KeQM0SBaC1YDWbnbbZL64CGC'), -- mdp1234
(9, 'thomas.richard@email.com', 'thomas richard', '$2y$10$bugfME.vsoO3EwcwN9xXR.UCmOJOSuyuOVAda1iUH3R7.lHQDTKN6'), -- mdp1234
(10, 'chloe.durand@email.com', 'chloe durand', '$2y$10$VHvv6w16Canta/rZ4INCXup3VowGilN5cwIBgskS1KSK83uAHehf6'), -- mdp1234
(11, 'hugo.moreau@email.com', 'hugo moreau', '$2y$10$bhUM2FYtLbf8O455TXv/ZelKtDLXEDt32odNuuyl8JPLQkWrTJc.i'); -- mdp1234

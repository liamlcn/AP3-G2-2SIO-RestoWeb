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
('Perrier (bouteille 0,5L)','5')

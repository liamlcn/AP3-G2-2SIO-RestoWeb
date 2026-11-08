DELIMITER |

-- Trigger BEFORE INSERT
DROP TRIGGER IF EXISTS before_ligne_insert |
CREATE TRIGGER before_ligne_insert
BEFORE INSERT ON ligne_de_commande
FOR EACH ROW
BEGIN
    DECLARE v_prixHT DECIMAL(10,2);
    
    -- Récupération du prix HT du produit
    SELECT prixHT INTO v_prixHT
    FROM produit
    WHERE idPROD = NEW.idPROD;
    
    -- Affectation du total HT de la ligne
    SET NEW.totalHT = NEW.quantiteProduit * v_prixHT;
END |

-- Trigger BEFORE UPDATE
DROP TRIGGER IF EXISTS before_ligne_update |
CREATE TRIGGER before_ligne_update
BEFORE UPDATE ON ligne_de_commande
FOR EACH ROW
BEGIN
    DECLARE v_prixHT DECIMAL(10,2);
    
    -- Récupération du prix HT du produit
    SELECT prixHT INTO v_prixHT
    FROM produit
    WHERE idPROD = NEW.idPROD;
    
    -- Mise à jour du total HT de la ligne
    SET NEW.totalHT = NEW.quantiteProduit * v_prixHT;
END |

DELIMITER ;

DELIMITER |

-- Trigger AFTER INSERT
DROP TRIGGER IF EXISTS after_ligne_insert |
CREATE TRIGGER after_ligne_insert
AFTER INSERT ON ligne_de_commande
FOR EACH ROW
BEGIN
    DECLARE v_sommeHT DECIMAL(10,2);
    DECLARE v_tva TINYINT;
    
    -- Somme de tous les totaux HT pour cette commande
    SELECT IFNULL(SUM(totalHT), 0) INTO v_sommeHT
    FROM ligne_de_commande
    WHERE idCOM = NEW.idCOM;
    
    -- Récupération du taux de TVA de la commande
    SELECT TVA INTO v_tva
    FROM commande
    WHERE idCOM = NEW.idCOM;
    
    -- Calcul et mise à jour de la valeur TTC de la commande
    UPDATE commande
    SET valeurTTC = v_sommeHT * (1 + (v_tva / 100))
    WHERE idCOM = NEW.idCOM;
END |

-- Trigger AFTER UPDATE
DROP TRIGGER IF EXISTS after_ligne_update |
CREATE TRIGGER after_ligne_update
AFTER UPDATE ON ligne_de_commande
FOR EACH ROW
BEGIN
    DECLARE v_sommeHT DECIMAL(10,2);
    DECLARE v_tva TINYINT;
    
    -- Somme de tous les totaux HT pour cette commande
    SELECT IFNULL(SUM(totalHT), 0) INTO v_sommeHT
    FROM ligne_de_commande
    WHERE idCOM = NEW.idCOM;
    
    -- Récupération du taux de TVA de la commande
    SELECT TVA INTO v_tva
    FROM commande
    WHERE idCOM = NEW.idCOM;
    
    -- Calcul et mise à jour de la valeur TTC de la commande
    UPDATE commande
    SET valeurTTC = v_sommeHT * (1 + (v_tva / 100))
    WHERE idCOM = NEW.idCOM;
END |

DELIMITER ;
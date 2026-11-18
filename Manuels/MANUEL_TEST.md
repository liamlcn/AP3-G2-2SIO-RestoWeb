# Manuel de test — Food Express (RestoWeb)

> Projet AP3 — BTS SIO 2ᵉ année SLAM — Institut LIMAYRAC
> Dépôt : <https://github.com/liamlcn/AP3-G2-2SIO-RestoWeb>
> Prérequis : application installée selon le [Manuel d'installation](MANUEL_INSTALLATION.md).

## Sommaire

1. [Objectif et périmètre](#1-objectif-et-périmètre)
2. [Environnement et conventions](#2-environnement-et-conventions)
3. [Jeu de données de test](#3-jeu-de-données-de-test)
4. [Plan de tests](#4-plan-de-tests)
   - [A. Base de données](#a-base-de-données-bdd)
   - [B. Inscription](#b-inscription-ins)
   - [C. Connexion et déconnexion](#c-connexion-et-déconnexion-con)
   - [D. Carte](#d-carte-men)
   - [E. Panier et TVA](#e-panier-et-tva-pan)
   - [F. Paiement et création de commande](#f-paiement-et-création-de-commande-pai)
   - [G. Confirmation et suivi](#g-confirmation-et-suivi-cnf)
   - [H. API RestoSwing](#h-api-restoswing-api)
5. [Scénario d'intégration de bout en bout](#5-scénario-dintégration-de-bout-en-bout)
6. [Fiche de recette](#6-fiche-de-recette)
7. [Registre des anomalies connues](#7-registre-des-anomalies-connues)
8. [Annexes](#8-annexes)

---

## 1. Objectif et périmètre

Ce manuel décrit le **jeu de test** permettant de valider que l'application répond au besoin :

| Fonction (README du projet) | Couvert par |
|---|---|
| Gestion des utilisateurs (inscription, connexion, déconnexion) | B, C |
| Affichage et sélection des produits | D |
| Commande sur place / à emporter, TVA 10 % / 5,5 % | E, F |
| Paiement fictif par carte bancaire | F |
| Suivi de commande côté client | G |
| Gestion des commandes côté restaurateur (accepter, refuser, terminer) via l'API | H |
| Cohérence site ⇄ API | 5 |

**Hors périmètre** (non développé à ce jour d'après le README) : notification par e-mail, tableau de bord web du restaurateur, application Java RestoSwing (Lot 7, testée avec sa propre documentation).

Chaque test a un identifiant (`INS-03`, `API-07`…), des **étapes**, un **résultat attendu** et une case de **verdict** (☐ → ✅ OK / ❌ KO). Quand le comportement actuel du dépôt s'écarte du résultat attendu, le test renvoie vers une fiche du [registre des anomalies](#7-registre-des-anomalies-connues) (`⚠ ANO-xx`) : le résultat attendu reste la **spécification**, pas le comportement défectueux.

---

## 2. Environnement et conventions

| Élément | Valeur |
|---|---|
| Adresse de base `<BASE>` | `http://localhost/apresto` |
| Navigateur | Chrome ou Firefox récent (tester aussi en **navigation privée** pour avoir une session vierge) |
| Outil d'administration BDD | phpMyAdmin — `http://localhost/phpmyadmin/` |
| Ligne de commande (optionnel) | `curl` (sous Windows PowerShell : `curl.exe`) |
| État initial | Base `apresto` fraîchement importée depuis `bdd/MPD.sql` (13 produits, aucun utilisateur, aucune commande) |

**Notations :** `[Navigateur]` = test manuel à l'écran ; `[curl]` = commande à lancer dans un terminal ; `[SQL]` = vérification dans phpMyAdmin (onglet SQL ; requêtes d'aide en [annexe 8.1](#81-requêtes-sql-de-contrôle)) ; `[API]` = appel d'une URL de l'API, dans le navigateur ou avec `curl` ([annexe 8.3](#83-récapitulatif-des-appels-api-pour-copier-coller)).

> ⚠️ Le paiement est **fictif**. Ne **jamais** saisir un vrai numéro de carte : n'utiliser que les valeurs du §3.3.

---

## 3. Jeu de données de test

### 3.1 Comptes à créer (test INS-01 puis INS-09)

| Compte | Prénom | Nom | E-mail | Mot de passe | `loginUtil` obtenu |
|---|---|---|---|---|---|
| **Client A** | Alice | Martin | `alice.martin@test.local` | `Test1234` | `Alice Martin` |
| **Client B** | Bob | Durand | `bob.durand@test.local` | `Test5678` | `Bob Durand` |

### 3.2 Paniers de référence et montants attendus

Identifiants produits après import de `MPD.sql` : 1 Pizza 5 fromages (13 €), 2 Tacos 3 viandes (11 €), 3 Poulet rôti (20 €), 4 Nouilles sautées (10 €), 5 Sachet de frites (6 €), 6 Salade César (10 €), 7 Magret de canard (20 €), 8 Foie gras (8 €), 9 Cœurs de canards (7 €), 10 Pizza Margherita (10 €), 11 Eau plate (4 €), 12 Coca-Cola (4 €), 13 Perrier (5 €). **Les prix de la carte sont hors taxes.**

| Panier | Contenu | Total HT | Sur place (TVA 10 %) | À emporter (TVA 5,5 %) |
|---|---|---:|---:|---:|
| **P1** | Magret de canard × 8 | 160,00 € | TVA 16,00 € → **176,00 €** TTC | TVA 8,80 € → **168,80 €** TTC |
| **P2** | Pizza 5 fromages × 2 + Sachet de frites × 3 | 26 + 18 = 44,00 € | TVA 4,40 € → **48,40 €** TTC | TVA 2,42 € → **46,42 €** TTC |
| **P3** | Eau plate × 1 + Coca-Cola × 1 | 8,00 € | TVA 0,80 € → **8,80 €** TTC | TVA 0,44 € → **8,44 €** TTC |

### 3.3 Données de paiement fictives

| Usage | Numéro | Expiration | CVC |
|---|---|---|---|
| **Valides** | `4970 1012 3456 7890` | `12/30` | `123` |
| Numéro trop court | `1234` | `12/30` | `123` |
| Expiration invalide | `4970 1012 3456 7890` | `13/30` (ou `1230`) | `123` |
| CVC invalide | `4970 1012 3456 7890` | `12/30` | `12` |

---

## 4. Plan de tests

### A. Base de données (BDD)

| ID | Objectif | Étapes | Résultat attendu | ✔ |
|---|---|---|---|:-:|
| BDD-01 | Les 4 tables existent | `[SQL]` `SHOW TABLES;` sur `apresto` | `commande`, `ligne_de_commande`, `produit`, `utilisateur` | ☐ |
| BDD-02 | Identifiants auto-incrémentés | phpMyAdmin ▸ table ▸ *Structure* (ou `SHOW CREATE TABLE utilisateur;`) pour les 4 tables | `idUTIL`, `idCOM`, `idPROD`, `idLIGNCOM` ont `AUTO_INCREMENT` | ☐ |
| BDD-03 | Données de la carte | `[SQL]` `SELECT idPROD, libellePROD, prixHT FROM produit;` | 13 lignes, conformes au §3.2 | ☐ |
| BDD-04 | Intégrité référentielle | `[SQL]` `INSERT INTO commande (etatCOM, idUTIL) VALUES ('en_attente', 99999);` | Erreur **1452** (clé étrangère) ; aucune ligne créée | ☐ |
| BDD-05 | Type de la TVA | `[SQL]` `SHOW COLUMNS FROM commande LIKE 'TVA';` | Type capable de stocker **5,5** (ex. `decimal(4,1)`). `⚠ ANO-01` : actuellement `tinyint unsigned` | ☐ |

### B. Inscription (INS)

Page : `<BASE>/pages/inscription.php`. Les contrôles « champ vide » et « e-mail invalide » sont aussi faits par le navigateur (`required`, `type=email`) ; les commandes `[curl]` vérifient la **validation côté serveur**, qui ne doit jamais dépendre du navigateur.

| ID | Objectif | Étapes | Résultat attendu | ✔ |
|---|---|---|---|:-:|
| INS-01 | Inscription nominale (Client A) | `[Navigateur]` Saisir Alice / Martin / `alice.martin@test.local` / `Test1234` ×2 ▸ *S'inscrire* | Redirection vers `connexion.php?inscription=ok` ; bandeau vert « Votre compte a bien été créé… » | ☐ |
| INS-02 | Enregistrement en base | `[SQL]` `SELECT idUTIL, emailUtil, loginUtil, LEFT(mdpUtil,7) FROM utilisateur;` | 1 ligne : `loginUtil = Alice Martin` ; mot de passe **haché** (`$2y$10$…`), jamais `Test1234` | ☐ |
| INS-03 | Champs vides (serveur) | `[curl]` `curl -s -X POST -d "prenom=&nom=&email=&password=&confirm_password=" <BASE>/pages/inscription.php` | La réponse contient « Merci de remplir tous les champs. » ; aucune ligne créée | ☐ |
| INS-04 | E-mail invalide | `[curl]` même commande avec `prenom=A&nom=B&email=abc&password=Test1234&confirm_password=Test1234` | « Adresse e-mail invalide. » | ☐ |
| INS-05 | Mot de passe trop court | `[Navigateur]` mot de passe `12345` ×2 | « Le mot de passe doit contenir au moins 6 caractères. » | ☐ |
| INS-06 | Confirmation différente | `[Navigateur]` `Test1234` / `Test12345` | « Les mots de passe ne correspondent pas. » | ☐ |
| INS-07 | E-mail déjà utilisé | `[Navigateur]` Réinscrire `alice.martin@test.local` | « Un compte existe déjà avec cette adresse e-mail. » ; toujours 1 seul compte en base | ☐ |
| INS-08 | Conservation de la saisie | Après l'erreur INS-06 | Prénom, nom et e-mail restent pré-remplis ; les **mots de passe sont vidés** | ☐ |
| INS-09 | Inscription du Client B | Bob / Durand / `bob.durand@test.local` / `Test5678` | Comme INS-01 ; 2 comptes en base | ☐ |
| INS-10 | Injection HTML (XSS) | Inscrire Prénom `<b>Eve</b>`, Nom `<script>alert(1)</script>`, e-mail `eve@test.local`. Se connecter avec ce compte, ouvrir `index.php` | Le nom s'affiche **littéralement** (balises visibles comme du texte) ; aucune fenêtre `alert` ; (puis supprimer ce compte dans phpMyAdmin) | ☐ |

### C. Connexion et déconnexion (CON)

Page : `<BASE>/pages/connexion.php`.

| ID | Objectif | Étapes | Résultat attendu | ✔ |
|---|---|---|---|:-:|
| CON-01 | Connexion par e-mail | `alice.martin@test.local` / `Test1234` | Redirection vers `pages/menu.php` | ☐ |
| CON-02 | Connexion par identifiant | `Alice Martin` / `Test1234` | Redirection vers `pages/menu.php` | ☐ |
| CON-03 | Mauvais mot de passe | `alice.martin@test.local` / `faux` | « Email/identifiant ou mot de passe incorrect. » ; reste sur la page ; identifiant conservé | ☐ |
| CON-04 | Compte inexistant | `inconnu@test.local` / `Test1234` | **Même message** que CON-03 (on ne révèle pas si le compte existe) | ☐ |
| CON-05 | Champs vides (serveur) | `[curl]` `curl -s -X POST -d "login=&password=" <BASE>/pages/connexion.php` | « Merci de remplir tous les champs. » | ☐ |
| CON-06 | Injection SQL | Identifiant `' OR '1'='1` / mot de passe `' OR '1'='1` | Connexion **refusée** (message de CON-03) | ☐ |
| CON-07 | Accueil connecté | Après CON-01, ouvrir `<BASE>/index.php` | En-tête : « 👋 Alice Martin » + bouton *Se déconnecter* ; carte « Content de vous revoir ! » ; plus de bouton *S'inscrire* | ☐ |
| CON-08 | Déconnexion | Ouvrir `<BASE>/pages/deconnexion.php` | Message « Vous êtes déconnecté » ; **redirection automatique vers l'accueil après 3 s** (`⚠ ANO-03` : cible `main.php` inexistante) | ☐ |
| CON-09 | Session réellement fermée | Après CON-08, ouvrir `<BASE>/pages/panier.php` | Redirection vers `connexion.php` | ☐ |
| CON-10 | Bouton *Se déconnecter* de la carte | Connecté, cliquer sur *Se déconnecter* en haut de `menu.php` | Mène à `deconnexion.php` et ferme la session (`⚠ ANO-02` : pointe vers `../main.php`, inexistante, sans fermer la session) | ☐ |
| CON-11 | Lien *← Accueil* | Sur `connexion.php` puis `inscription.php`, cliquer *← Accueil* | Affiche `index.php` (`⚠ ANO-03`) | ☐ |
| CON-12 | Nom affiché dans la carte | Connecté en tant qu'Alice, regarder l'en-tête de `menu.php` | « Bienvenue, **Alice Martin** » (`⚠ ANO-02` : texte fixe « M le prof ») | ☐ |

### D. Carte (MEN)

Page : `<BASE>/pages/menu.php`.

| ID | Objectif | Étapes | Résultat attendu | ✔ |
|---|---|---|---|:-:|
| MEN-01 | Affichage des produits | Ouvrir la page | 13 cartes avec libellé et prix au format `13,00 €`, conformes à la base | ☐ |
| MEN-02 | Compteur initial | Panier vide, session neuve | « 🛒 Voir le Panier (0 articles) » | ☐ |
| MEN-03 | Boutons `+` / `-` | Cliquer 3× sur `+` d'un produit, puis 5× sur `-` | La quantité monte à 4 puis **ne descend jamais sous 1** ; la page ne se recharge pas | ☐ |
| MEN-04 | Ajout au panier | Magret : quantité 8 ▸ *Ajouter au panier* | La page se recharge ; compteur « (8 articles) » ; la quantité des cartes revient à 1 | ☐ |
| MEN-05 | Compteur = somme des quantités | Ajouter Pizza 5 fromages × 2 puis Frites × 3 en plus | Compteur « (13 articles) » (8 + 2 + 3), et non 3 | ☐ |
| MEN-06 | Cumul sur un même produit | Ajouter à nouveau Frites × 1 | Compteur 14 ; dans le panier, Frites = **4** sur **une seule ligne** | ☐ |
| MEN-07 | Rechargement après ajout | Juste après MEN-04, appuyer sur **F5** | Aucun message de renvoi de formulaire ; le compteur ne change pas (redirection POST→GET) | ☐ |
| MEN-08 | Carte vide | Sur une base de test **sans aucune commande** et après sauvegarde : `[SQL]` `DELETE FROM produit;` puis recharger | « Aucun produit disponible pour le moment. » (puis réimporter `MPD.sql`) | ☐ |

### E. Panier et TVA (PAN)

Page : `<BASE>/pages/panier.php`. Pour chaque test, repartir d'un panier propre (déconnexion/reconnexion, cf. `⚠ ANO-09`).

| ID | Objectif | Étapes | Résultat attendu | ✔ |
|---|---|---|---|:-:|
| PAN-01 | Accès sans connexion | Session neuve, ouvrir `<BASE>/pages/panier.php` | Redirection vers `connexion.php` | ☐ |
| PAN-02 | Panier vide | Connecté, sans rien ajouter | « Votre panier est vide. Retourner à la carte. » ; pas de formulaire de paiement | ☐ |
| PAN-03 | Contenu P1 | Ajouter le panier **P1** | Tableau : Magret de canard / 8 / 20,00 € / 160,00 € ; mode *Manger sur place* présélectionné ; Total HT 160,00 € — TVA (10 %) 16,00 € — **Total TTC 176,00 €** ; bouton « Payer 176,00 € TTC » | ☐ |
| PAN-04 | Bascule de TVA **sans rechargement** | Cliquer *À emporter* | Affichage immédiat : TVA (5,5 %) 8,80 € — **Total TTC 168,80 €** ; bouton « Payer 168,80 € TTC » ; revenir sur *Manger sur place* rétablit 176,00 € | ☐ |
| PAN-05 | Panier multi-lignes P2 | Ajouter le panier **P2** | 2 lignes (26,00 € et 18,00 €) ; HT 44,00 € ; sur place **48,40 €** ; à emporter **46,42 €** | ☐ |
| PAN-06 | Panier P3 | Ajouter le panier **P3** | HT 8,00 € ; sur place **8,80 €** ; à emporter **8,44 €** | ☐ |
| PAN-07 | Lien de retour | Cliquer *← Retour à la carte* | Retour sur `menu.php` ; le compteur est conservé | ☐ |

### F. Paiement et création de commande (PAI)

| ID | Objectif | Étapes | Résultat attendu | ✔ |
|---|---|---|---|:-:|
| PAI-01 | Numéro de carte invalide | Panier **P1**, numéro `1234`, reste valide ▸ *Payer* | « Numéro de carte invalide. » ; **aucune** commande en base ; panier conservé | ☐ |
| PAI-02 | Expiration invalide | `13/30` | « Date d'expiration invalide (format MM/AA). » | ☐ |
| PAI-03 | CVC invalide | `12` | « Code CVC invalide. » | ☐ |
| PAI-04 | Plusieurs erreurs | Les 3 champs invalides en même temps | Les 3 messages s'affichent ensemble | ☐ |
| PAI-05 | Paiement **sur place** | Panier **P1**, *Manger sur place*, données valides ▸ *Payer* | Redirection vers `confirmation.php?id=N`. `[SQL]` : 1 ligne `commande` avec `etatCOM = en_attente`, `typeCOM = Manger sur place`, **`valeurTTC = 176.000`**, taux de TVA = 10 %, `idUTIL` = Alice ; 1 ligne `ligne_de_commande` (Magret, quantité 8, `totalHT = 160.000`) (`⚠ ANO-01` : TVA stockée à 0) | ☐ |
| PAI-06 | Paiement **à emporter** | Panier **P2**, *À emporter* ▸ *Payer* | `typeCOM = À emporter`, **`valeurTTC = 46.420`**, taux de TVA = 5,5 % ; 2 lignes de commande (`totalHT` 26 et 18) (`⚠ ANO-01`) | ☐ |
| PAI-07 | Panier vidé après paiement | Retourner sur `menu.php` | Compteur « (0 articles) » ; `panier.php` affiche « Votre panier est vide » | ☐ |
| PAI-08 | Pas de double commande | Après PAI-05, bouton **Retour** du navigateur puis nouvelle soumission | Aucune seconde commande créée (panier vide ⇒ « Votre panier est vide ») ; `[SQL]` : le nombre de commandes n'a pas augmenté | ☐ |
| PAI-09 | Mode falsifié | `[Navigateur]` outils de développement : changer la valeur du radio en `hack`, payer P3 | Traité comme *sur place* : `typeCOM = Manger sur place`, TVA 10 %, TTC 8,80 € | ☐ |
| PAI-10 | Données de carte non conservées | `[SQL]` `SHOW COLUMNS FROM commande;` + parcourir les tables | Aucune colonne ni donnée contenant numéro de carte, expiration ou CVC | ☐ |
| PAI-11 | Pas de fuite d'erreur technique | Sur une base de test, provoquer une erreur SQL à l'enregistrement : `[SQL]` `ALTER TABLE commande CHANGE typeCOM typeCOM_x VARCHAR(50);`, puis payer un panier valide ; **rétablir** ensuite avec `ALTER TABLE commande CHANGE typeCOM_x typeCOM VARCHAR(50);` | Message **générique** pour l'utilisateur, jamais le texte SQL (`⚠ ANO-05`) | ☐ |

### G. Confirmation et suivi (CNF)

Page : `<BASE>/pages/confirmation.php`. Les tests CNF-05 à CNF-07 utilisent l'API (section H) pour faire évoluer l'état.

| ID | Objectif | Étapes | Résultat attendu | ✔ |
|---|---|---|---|:-:|
| CNF-01 | Contenu | Juste après PAI-05 | « ✅ Commande Validée ! » ; « Merci **Alice Martin**, votre paiement de **176,00 € TTC** a été accepté » ; N° `#CDE-<id>` ; Mode « Manger sur place » ; date/heure du jour ; badge « ⏳ Statut : En attente d'acceptation par le restaurant… » | ☐ |
| CNF-02 | Reprise sans paramètre | Ouvrir `<BASE>/pages/confirmation.php` (sans `?id=`) | Affiche la **dernière** commande de la session | ☐ |
| CNF-03 | Isolation entre clients | Connecté en **Bob**, ouvrir `confirmation.php?id=<id d'une commande d'Alice>` | Redirection vers l'accueil ; aucune donnée d'Alice affichée | ☐ |
| CNF-04 | Accès sans connexion | Session neuve, `confirmation.php?id=1` | Redirection vers `connexion.php` | ☐ |
| CNF-05 | Statut « en préparation » | `[API]` `commande_accepter.php?id_commande=<id>` puis recharger la confirmation | Badge vert « ✅ Statut : Commande acceptée, en préparation » (`⚠ ANO-04` : `pages/confirmation.php` affiche le code brut `en_preparation`) | ☐ |
| CNF-06 | Statut « prête » | `commande_terminer.php?id_commande=<id>` | Badge « 🍽️ Statut : Commande prête ! » | ☐ |
| CNF-07 | Statut « refusée » | Sur une autre commande en attente : `commande_refuser.php?id_commande=<id>` | Badge rouge « ❌ Statut : Commande refusée par le restaurant » (`⚠ ANO-04`) | ☐ |
| CNF-08 | Lien de retour | Cliquer *Retour au menu* | Ouvre `menu.php` | ☐ |

### H. API RestoSwing (API)

Rappels du contrat (voir `restoswing/Documentation JSON API.md`) : toutes les requêtes sont en **GET**, les réponses en **JSON** (liste) ou **vides** (actions), et **aucun message d'erreur** ne doit jamais s'afficher. Cycle des états :

```
en_attente ──accepter──► en_preparation ──terminer──► prete
    └───────────────refuser (depuis l'un ou l'autre)──► abandonnee
```

`<API>` = `<BASE>/restoswing`. Préparer **3 commandes en attente** (A1, A2, A3) à l'aide des tests PAI-05/PAI-06 (Client A ou B) et noter leurs numéros `idCOM`.

| ID | Objectif | Étapes | Résultat attendu | ✔ |
|---|---|---|---|:-:|
| API-01 | Liste vide | Base sans commande. `[curl]` `curl -i <API>/commandes_en_attente.php` | HTTP **200**, en-tête `Content-Type: application/json; charset=utf-8`, corps **`[]`** | ☐ |
| API-02 | Structure de la liste | Avec A1, A2, A3 : `curl -s <API>/commandes_en_attente.php` | Tableau JSON valide (à contrôler avec jsonlint.com) ; chaque objet a **exactement** : `id_commande`, `date_heure`, `montant_ttc`, `tva`, `mode`, `client`, `produits[]` | ☐ |
| API-03 | Types des champs | Lire la réponse d'API-02 | `id_commande` entier ; `montant_ttc` nombre ; `date_heure` « AAAA-MM-JJ HH:MM:SS » ; `produits[]` = `libelle` (texte), `quantite` (entier), `total_ht` (nombre) ; accents corrects (« À emporter ») | ☐ |
| API-04 | Exactitude des données | Comparer l'objet de P1 aux valeurs de PAI-05 | `montant_ttc` = 176 ; `mode` = « Manger sur place » ; `client` = « Alice Martin » ; `produits` = Magret / 8 / 160 ; `tva` cohérente avec le taux (10 %) (`⚠ ANO-01`) | ☐ |
| API-05 | Tri chronologique | Lire l'ordre des objets | Du plus **ancien** au plus récent (`date_heure` croissante) | ☐ |
| API-06 | Accepter | `curl -i "<API>/commande_accepter.php?id_commande=<A1>"` | HTTP 200, **corps vide** ; `[SQL]` `etatCOM = en_preparation` | ☐ |
| API-07 | La commande acceptée quitte la liste | Relancer API-02 | A1 a **disparu** ; A2 et A3 restent | ☐ |
| API-08 | Accepter deux fois | Rappeler la même URL qu'API-06 | Sans effet, sans erreur ; l'état reste `en_preparation` | ☐ |
| API-09 | Terminer sans avoir accepté | `commande_terminer.php?id_commande=<A2>` (A2 encore `en_attente`) | **Sans effet** : A2 reste `en_attente` | ☐ |
| API-10 | Terminer | `commande_terminer.php?id_commande=<A1>` | `etatCOM = prete` | ☐ |
| API-11 | Refuser depuis « en attente » | `commande_refuser.php?id_commande=<A2>` | `etatCOM = abandonnee` | ☐ |
| API-12 | Refuser depuis « en préparation » | Accepter A3, puis `commande_refuser.php?id_commande=<A3>` | `etatCOM = abandonnee` | ☐ |
| API-13 | Refuser une commande terminée | `commande_refuser.php?id_commande=<A1>` (A1 est `prete`) | **Sans effet** : A1 reste `prete` | ☐ |
| API-14 | Paramètre absent | `curl -i <API>/commande_accepter.php` | HTTP 200, corps vide, aucun message ; aucune commande modifiée | ☐ |
| API-15 | Paramètres invalides | `?id_commande=abc`, `=0`, `=-5`, `=999999` pour les 3 actions | HTTP 200, corps vide, aucun message ; aucune commande modifiée | ☐ |
| API-16 | Injection SQL | `?id_commande=1;DROP%20TABLE%20commande` | La valeur est convertie en entier `1` ; la table `commande` existe toujours | ☐ |
| API-17 | Silence en cas de panne BDD | **Arrêter MySQL**, puis `curl -i <API>/commandes_en_attente.php` | Réponse **`[]`** ou vide, **aucun texte d'erreur** (`⚠ ANO-07` : le texte « Erreur de connexion à la base de données… » s'affiche) ; redémarrer MySQL ensuite | ☐ |
| API-18 | Aucune commande autre qu'« en attente » dans la liste | Après API-06 → API-13 | La liste est `[]` (aucune commande `en_attente`) | ☐ |

---

## 5. Scénario d'intégration de bout en bout

Ce scénario reproduit une journée type et valide **site ⇄ base ⇄ API**. Partir d'une base vide (annexe 8.2), `<API>` = `<BASE>/restoswing`.

| Étape | Acteur | Action | Résultat attendu | ✔ |
|:-:|---|---|---|:-:|
| 1 | Client A | S'inscrire, se connecter | Arrivée sur la carte | ☐ |
| 2 | Client A | Ajouter **P2** (Pizza 5 fromages ×2 + Frites ×3) | Compteur « (5 articles) » | ☐ |
| 3 | Client A | Panier ▸ *À emporter* ▸ payer | Confirmation « 46,42 € TTC », statut **en attente** | ☐ |
| 4 | Client B | Dans un **autre navigateur/fenêtre privée**, s'inscrire, ajouter **P3**, *Manger sur place*, payer | Confirmation « 8,80 € TTC » | ☐ |
| 5 | Cuisine | `GET <API>/commandes_en_attente.php` | 2 commandes, la plus ancienne (Client A) en premier, `mode` « À emporter » puis « Manger sur place », montants 46,42 et 8,80 | ☐ |
| 6 | Cuisine | Accepter la commande du Client A | Corps vide | ☐ |
| 7 | Client A | Rafraîchir sa confirmation | « Commande acceptée, en préparation » | ☐ |
| 8 | Cuisine | Refuser la commande du Client B | Corps vide | ☐ |
| 9 | Client B | Rafraîchir sa confirmation | « Commande refusée par le restaurant » | ☐ |
| 10 | Cuisine | `GET <API>/commandes_en_attente.php` | `[]` | ☐ |
| 11 | Cuisine | Terminer la commande du Client A | Corps vide | ☐ |
| 12 | Client A | Rafraîchir | « Commande prête ! » | ☐ |
| 13 | Client A | Se déconnecter, puis tenter d'ouvrir sa confirmation | Redirection vers la connexion | ☐ |
| 14 | Contrôle BDD | `[SQL]` états des deux commandes | A = `prete`, B = `abandonnee` ; 3 lignes de commande au total ; montants TTC cohérents avec le §3.2 | ☐ |

---

## 6. Fiche de recette

| | |
|---|---|
| Testeur | |
| Date | |
| Version testée (n° de commit Git) | |
| Environnement (OS / XAMPP / PHP / MariaDB / navigateur) | |

| Section | Nombre de tests | ✅ OK | ❌ KO | Anomalies liées |
|---|:-:|:-:|:-:|---|
| A. Base de données | 5 | | | |
| B. Inscription | 10 | | | |
| C. Connexion / déconnexion | 12 | | | |
| D. Carte | 8 | | | |
| E. Panier et TVA | 7 | | | |
| F. Paiement | 11 | | | |
| G. Confirmation | 8 | | | |
| H. API | 18 | | | |
| 5. Intégration | 14 | | | |
| **Total** | **93** | | | |

**Critère d'acceptation proposé :** 100 % des tests des sections B à H et 5 en ✅, hors anomalies du registre ci-dessous explicitement acceptées par l'équipe.

---

## 7. Registre des anomalies connues

Ces écarts ont été relevés par **analyse du code du dépôt** (et, pour ANO-01, confirmés par l'export `bdd/secour/apresto(secour).sql`, où la commande n° 2 a `TVA = 0` pour un montant TTC de 176 €). Ils sont à **confirmer en exécutant les tests** ci-dessus, puis à corriger ; les verdicts ❌ des tests concernés doivent renvoyer à la fiche correspondante.

| ID | Gravité | Description | Tests concernés | Correction proposée |
|---|:-:|---|---|---|
| **ANO-01** | Majeure | **TVA incohérente.** `commande.TVA` est `TINYINT UNSIGNED` (entier) ; `panier.php` y enregistre `0.10` / `0.055` → valeur arrondie à **0**, et 5,5 % est de toute façon inexprimable. Les triggers de `bdd/all trigger.sql` attendent un pourcentage entier (`valeurTTC = HT × (1 + TVA/100)`) : installés tels quels, ils **écraseraient le TTC par le HT**. L'API renvoie ce `tva` faux. | BDD-05, PAI-05, PAI-06, API-04 | Choisir **une** unité (conseillé : pourcentage, `DECIMAL(4,1)` → 10.0 / 5.5) ; adapter `MPD.sql`, `panier.php` (10 / 5.5), les triggers (`v_tva DECIMAL(4,1)`) et `Documentation JSON API.md` / `exemple_commande.json` | 
| **ANO-02** | Moyenne | `pages/menu.php` : nom affiché **en dur** (« Bienvenue, M le prof ») ; le bouton *Se déconnecter* pointe vers `../main.php` (inexistant) et **ne ferme pas la session**. | CON-10, CON-12 | Afficher `$_SESSION['loginUtil']` (via `htmlspecialchars`) ; lien vers `deconnexion.php` ; masquer si non connecté |
| **ANO-03** | Moyenne | **Liens cassés** vers `main.php` (renommé `index.php`) : `inscription.php` (l. 68), `connexion.php` (l. 47), redirection automatique de `deconnexion.php` (l. 12). | CON-08, CON-11 | Remplacer par `../index.php` |
| **ANO-04** | Majeure | `pages/confirmation.php` utilise les **anciens états** (`acceptee`, `refusee`) alors que l'API écrit `en_preparation` / `abandonnee` : le client voit le code brut au lieu du libellé. La version à jour est dans `restoswing/confirmation.php`, **mal placée** (doublon). | CNF-05, CNF-07 | Remplacer `pages/confirmation.php` par la version à jour, supprimer `restoswing/confirmation.php` |
| **ANO-05** | Moyenne | `pages/panier.php` : le bloc « DEBUG TEMPORAIRE » affiche le message SQL brut (structure de la base) à l'utilisateur en cas d'erreur d'enregistrement. | PAI-11 | Remettre le message générique « Une erreur est survenue lors de l'enregistrement de la commande. » (consigner l'erreur côté serveur avec `error_log`) |
| **ANO-06** | Mineure | Documentation : l'API est annoncée sous `/api/` mais le dossier est `restoswing/` ; `exemple_commande.json` indiquait `46.11` pour la commande n° 102 alors que 44 € HT à 5,5 % font **46,42 €** (corrigé dans le fichier joint à ce manuel). | — | Mettre à jour `Documentation JSON API.md` et `exemple_commande.json` |
| **ANO-07** | Moyenne | **L'API n'est pas silencieuse si la base est injoignable** : `function_db/db.php` fait un `die("Erreur de connexion…")` **avant** le `try/catch` des scripts ; le texte (parfois avec nom d'utilisateur et d'hôte) est renvoyé à RestoSwing, contraire au cahier des charges. | API-17 | Dans les 4 scripts de `restoswing/`, englober aussi l'inclusion/connexion dans un `try/catch` renvoyant `[]` (ou rien), ou faire lancer une exception à `db.php` au lieu de `die` |
| **ANO-08** | À vérifier | `bdd/MPD.sql` : les deux lignes `--ALTER TABLE …` n'ont pas d'espace après `--` ; MySQL peut les rejeter (erreur 1064) à l'import. | Installation §5 | Supprimer ces deux lignes ou écrire `-- ALTER …` |
| **ANO-09** | Limite fonctionnelle | Le panier **ne peut pas être modifié** depuis `panier.php` (ni suppression de ligne, ni changement de quantité) ; il ne se vide qu'au paiement ou à la déconnexion. | PAN-* | Ajouter des boutons *Retirer* / *Vider le panier* (`unset($_SESSION['panier'][$id])`) |
| **ANO-10** | Mineure | `loginUtil` (= prénom + nom) n'est pas unique : deux homonymes ⇒ seul le premier peut se connecter **par identifiant** ; la connexion par e-mail reste fiable. | CON-02 | Contrainte d'unicité sur `emailUtil`, ne proposer que l'e-mail comme identifiant de connexion |

---

## 8. Annexes

### 8.1 Requêtes SQL de contrôle

```sql
-- Dernières commandes
SELECT idCOM, etatCOM, typeCOM, TVA, valeurTTC, date_horaireCOM, idUTIL
FROM commande ORDER BY idCOM DESC;

-- Lignes d'une commande (remplacer 1 par l'identifiant)
SELECT l.idLIGNCOM, p.libellePROD, l.quantiteProduit, l.totalHT
FROM ligne_de_commande l JOIN produit p ON p.idPROD = l.idPROD
WHERE l.idCOM = 1;

-- Comptes (sans exposer le hash en entier)
SELECT idUTIL, emailUtil, loginUtil, LEFT(mdpUtil, 7) AS debut_hash FROM utilisateur;

-- Comptage rapide
SELECT (SELECT COUNT(*) FROM utilisateur) AS nb_utilisateurs,
       (SELECT COUNT(*) FROM commande)    AS nb_commandes,
       (SELECT COUNT(*) FROM ligne_de_commande) AS nb_lignes;
```

### 8.2 Remise à zéro entre deux campagnes de test

```sql
DELETE FROM ligne_de_commande;
DELETE FROM commande;
DELETE FROM utilisateur;
-- Optionnel : repartir des identifiants 1, 2, 3…
ALTER TABLE ligne_de_commande AUTO_INCREMENT = 1;
ALTER TABLE commande          AUTO_INCREMENT = 1;
ALTER TABLE utilisateur       AUTO_INCREMENT = 1;
```

Supprimer **dans cet ordre** (lignes → commandes → utilisateurs) à cause des clés étrangères. Penser aussi à fermer les sessions des navigateurs (déconnexion ou fenêtre privée) pour éviter l'erreur de clé étrangère sur `idUTIL` (cf. [Manuel d'installation §9](MANUEL_INSTALLATION.md#9-dépannage)).

### 8.3 Récapitulatif des appels API (pour copier-coller)

```bash
BASE=http://localhost/apresto/restoswing

curl -i  $BASE/commandes_en_attente.php
curl -i "$BASE/commande_accepter.php?id_commande=1"
curl -i "$BASE/commande_refuser.php?id_commande=1"
curl -i "$BASE/commande_terminer.php?id_commande=1"
```

Sous PowerShell : remplacer `curl` par `curl.exe` et `BASE=…` par `$BASE = "http://localhost/apresto/restoswing"` (puis `$BASE/…` dans les URL entre guillemets).

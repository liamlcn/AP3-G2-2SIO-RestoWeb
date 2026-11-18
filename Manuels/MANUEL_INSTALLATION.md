# Manuel d'installation — Food Express (RestoWeb)

> Projet AP3 — BTS SIO 2ᵉ année SLAM — Institut LIMAYRAC
> Dépôt : <https://github.com/liamlcn/AP3-G2-2SIO-RestoWeb>

## Sommaire

1. [Présentation et architecture](#1-présentation-et-architecture)
2. [Prérequis](#2-prérequis)
3. [Récupérer le projet](#3-récupérer-le-projet)
4. [Déployer les fichiers](#4-déployer-les-fichiers)
5. [Créer la base de données](#5-créer-la-base-de-données)
6. [Configurer la connexion à la base](#6-configurer-la-connexion-à-la-base)
7. [Vérifier l'installation](#7-vérifier-linstallation)
8. [Mettre en place l'API pour RestoSwing](#8-mettre-en-place-lapi-pour-restoswing)
9. [Dépannage](#9-dépannage)
10. [Réinitialiser ou désinstaller](#10-réinitialiser-ou-désinstaller)

---

## 1. Présentation et architecture

**Food Express** est une application web de commande de repas :

- le **client** s'inscrit, choisit des produits, commande (sur place ou à emporter) et paie (paiement fictif) ;
- la **cuisine** traite les commandes à travers une **API HTTP/JSON** consommée par l'application Java **RestoSwing** (Lot 7).

```
┌──────────────┐  HTTP   ┌───────────────────────────┐  PDO   ┌──────────────┐
│  Navigateur  │ ──────► │  Apache + PHP             │ ─────► │ MySQL/MariaDB│
│  (client)    │         │  pages/*.php, index.php   │        │  base apresto│
└──────────────┘         │                           │        └──────────────┘
┌──────────────┐  HTTP   │  restoswing/*.php (API)   │
│  RestoSwing  │ ──────► │  réponses en JSON         │
│  (Java)      │         └───────────────────────────┘
└──────────────┘
```

### Contenu du dépôt

```
AP3-G2-2SIO-RestoWeb/
├── README.md                    Présentation du projet et lotissement
├── BDD/                         Modèles de conception (MCD, MLD, MPD)
├── DCU + DA/                    Diagrammes de cas d'utilisation et d'activités
├── Sitemap + IHM/               Plan du site et maquettes
└── ap resto/                    ◄── L'APPLICATION (c'est ce dossier qu'on déploie)
    ├── index.php                Page d'accueil
    ├── css/maincss.css          Feuille de style unique
    ├── function_db/db.php       Connexion PDO à la base (à configurer)
    ├── pages/                   connexion, inscription, deconnexion,
    │                            menu, panier, confirmation
    ├── restoswing/              API pour RestoSwing (4 scripts PHP + documentation)
    └── bdd/
        ├── MPD.sql              Script de création de la base + produits  ◄ À importer
        ├── all trigger.sql      Triggers (optionnels — voir §5.4)
        └── secour/              Export de secours (base + données de test)
```

---

## 2. Prérequis

| Composant | Version | Remarque |
|---|---|---|
| Serveur web | Apache 2.4 | Fourni par XAMPP / WAMP / Laragon |
| PHP | **≥ 7.4** (développé avec **8.2**) | Extension **`pdo_mysql`** obligatoire (activée par défaut dans XAMPP) |
| Base de données | MySQL 5.7+ ou **MariaDB 10.4+** | Le projet a été développé sur MariaDB 10.4.32 |
| Outil d'administration | phpMyAdmin (conseillé) | Fourni avec XAMPP/WAMP |
| Git (optionnel) | toute version récente | Pour cloner le dépôt |
| Java (RestoSwing) | voir la documentation du Lot 7 | Non nécessaire pour le site web |

> **Environnement de référence.** L'export phpMyAdmin du projet (`bdd/secour/apresto(secour).sql`) indique PHP 8.2.12, MariaDB 10.4.32 et phpMyAdmin 5.2.1, ce qui correspond à **XAMPP 8.2.12**. Les instructions ci-dessous prennent XAMPP comme exemple ; elles sont identiques avec WAMP ou Laragon (seul le dossier de publication change).

### Installer XAMPP (si absent)

1. Télécharger XAMPP sur <https://www.apachefriends.org/> (version PHP 8.2).
2. L'installer (composants requis : **Apache**, **MySQL**, **PHP**, **phpMyAdmin**).
3. Ouvrir le *XAMPP Control Panel* et démarrer **Apache** et **MySQL** (voyants verts).

---

## 3. Récupérer le projet

**Avec Git :**

```bash
git clone https://github.com/liamlcn/AP3-G2-2SIO-RestoWeb.git
```

**Sans Git :** sur la page GitHub du dépôt, cliquer sur **Code ▸ Download ZIP**, puis extraire l'archive.

---

## 4. Déployer les fichiers

Le serveur web ne sert que le contenu de son dossier de publication :

| Environnement | Dossier de publication |
|---|---|
| XAMPP (Windows) | `C:\xampp\htdocs\` |
| WAMP | `C:\wamp64\www\` |
| Laragon | `C:\laragon\www\` |
| Linux (Apache) | `/var/www/html/` |

1. Copier le dossier **`ap resto`** (et uniquement lui) dans le dossier de publication.
2. **Le renommer `apresto`** (sans espace). Un espace dans un nom de dossier fonctionne mais oblige à écrire `ap%20resto` dans les URL.

Résultat attendu (XAMPP) :

```
C:\xampp\htdocs\apresto\
├── index.php
├── css\
├── function_db\
├── pages\
├── restoswing\
└── bdd\
```

L'adresse de base de l'application devient **`http://localhost/apresto/`**. Dans la suite de ce document, elle est notée `<BASE>`.

> ⚠️ **Conserver l'arborescence.** Les pages utilisent des chemins relatifs (`../function_db/db.php`, `../css/maincss.css`). Déplacer un fichier hors de son dossier casse la page.

---

## 5. Créer la base de données

### 5.1 Méthode recommandée — import de `MPD.sql` via phpMyAdmin

1. Ouvrir <http://localhost/phpmyadmin/>.
2. Cliquer sur l'onglet **Importer**.
3. **Choisir un fichier** : `apresto/bdd/MPD.sql`.
4. Laisser les options par défaut (encodage **utf-8**) puis cliquer sur **Importer**.

Le script :

- crée la base **`apresto`** si elle n'existe pas (`CREATE DATABASE IF NOT EXISTS`) ;
- crée les 4 tables `utilisateur`, `commande`, `produit`, `ligne_de_commande` (clés primaires en **`AUTO_INCREMENT`**) ;
- insère les **13 produits** de la carte.

### 5.2 Variante en ligne de commande

```bash
mysql -u root -p < "apresto/bdd/MPD.sql"
```

(Sous XAMPP/Windows : `C:\xampp\mysql\bin\mysql.exe -u root < "C:\xampp\htdocs\apresto\bdd\MPD.sql"`.)

### 5.3 Vérifier le résultat

Dans phpMyAdmin, la base `apresto` doit contenir :

| Table | Contenu initial |
|---|---|
| `utilisateur` | vide |
| `commande` | vide |
| `produit` | **13 lignes** (Pizza 5 fromages 13 €, Tacos 3 viandes 11 €, … Perrier 5 €) |
| `ligne_de_commande` | vide |

Et pour chaque table, la colonne identifiant (`idUTIL`, `idCOM`, `idPROD`, `idLIGNCOM`) doit avoir **A_I** (auto-incrément) coché dans l'onglet *Structure*.

### 5.4 Triggers (`bdd/all trigger.sql`) — **optionnels, ne pas installer en l'état**

Ce script crée quatre triggers qui recalculent `totalHT` (ligne) et `valeurTTC` (commande) dans la base. Il suppose que la colonne `commande.TVA` contient un **pourcentage entier** (10 ou 5), alors que `panier.php` enregistre actuellement un **taux décimal** (`0.10` / `0.055`) dans une colonne `TINYINT UNSIGNED`. Voir l'anomalie **ANO-01** dans le [Manuel de test](MANUEL_TEST.md#7-registre-des-anomalies-connues) : installés en l'état, ces triggers écraseraient le montant TTC par le montant HT.

> Le site fonctionne **sans** ces triggers : les montants sont calculés par `panier.php`. N'installer ce script qu'après avoir harmonisé le type et l'unité de la TVA.

### 5.5 Autre méthode — export de secours

`bdd/secour/apresto(secour).sql` est un export phpMyAdmin contenant la structure, les 13 produits, **un compte de test et une commande d'exemple**. À utiliser seulement pour retrouver un état connu :

1. Dans phpMyAdmin, **créer manuellement** une base vide nommée `apresto` (cet export ne contient pas de `CREATE DATABASE`), interclassement `utf8mb4_general_ci` ou `utf8_general_ci`.
2. La sélectionner, puis **Importer** le fichier.

---

## 6. Configurer la connexion à la base

Éditer **`apresto/function_db/db.php`** :

```php
$host     = "localhost";   // serveur MySQL
$dbname   = "apresto";     // nom de la base (ne pas changer si MPD.sql importé tel quel)
$dbUser   = "root";        // utilisateur MySQL
$dbPass   = "";            // mot de passe ('' par défaut sous XAMPP)
```

Les valeurs par défaut conviennent à une installation XAMPP standard. Ce fichier est inclus par toutes les pages ; c'est le **seul** à modifier.

### Recommandé hors poste de développement : un utilisateur dédié

Ne pas utiliser `root` sans mot de passe sur un serveur accessible par d'autres. Dans phpMyAdmin ▸ onglet **SQL** :

```sql
CREATE USER 'apresto_user'@'localhost' IDENTIFIED BY 'UnMotDePasseSolide!';
GRANT SELECT, INSERT, UPDATE ON apresto.* TO 'apresto_user'@'localhost';
FLUSH PRIVILEGES;
```

puis reporter `apresto_user` et son mot de passe dans `db.php`. L'application n'effectue ni `DELETE` ni modification de structure.

---

## 7. Vérifier l'installation

Ouvrir les adresses suivantes dans un navigateur (`<BASE>` = `http://localhost/apresto`) :

| # | Adresse | Résultat attendu |
|---|---|---|
| 1 | `<BASE>/index.php` | Page d'accueil « Commandez votre repas en quelques clics » avec boutons *Se connecter* / *S'inscrire*, mise en forme appliquée |
| 2 | `<BASE>/pages/menu.php` | Grille des **13 produits** avec prix et boutons `-` / `+` |
| 3 | `<BASE>/pages/inscription.php` | Formulaire d'inscription |
| 4 | `<BASE>/restoswing/commandes_en_attente.php` | `[]` (tableau JSON vide si aucune commande) |

- Si la page 1 s'affiche **sans mise en forme**, le CSS n'est pas trouvé : vérifier que le dossier `css/` est bien à côté de `index.php`.
- Si la page 2 affiche « *Erreur de connexion à la base de données* », reprendre le §6.
- Si la page 2 affiche « *Aucun produit disponible* », la table `produit` est vide : réimporter `MPD.sql`.

Une fois ces 4 contrôles passés, l'installation est terminée ; poursuivre avec le [Manuel de test](MANUEL_TEST.md) pour la validation fonctionnelle complète.

---

## 8. Mettre en place l'API pour RestoSwing

L'API est constituée des scripts du dossier `restoswing/`. Elle ne demande **aucune installation supplémentaire** : elle est servie par le même Apache et utilise la même base.

| Action | Adresse (GET) |
|---|---|
| Lister les commandes en attente | `<BASE>/restoswing/commandes_en_attente.php` |
| Accepter une commande | `<BASE>/restoswing/commande_accepter.php?id_commande=XX` |
| Refuser une commande | `<BASE>/restoswing/commande_refuser.php?id_commande=XX` |
| Terminer une commande | `<BASE>/restoswing/commande_terminer.php?id_commande=XX` |

À communiquer à l'équipe RestoSwing : l'**adresse de base** du serveur. Si RestoSwing tourne sur une autre machine :

1. Utiliser l'adresse IP (ou le nom) du serveur, par exemple `http://192.168.1.20/apresto/restoswing/…`, et non `localhost`.
2. Autoriser le port **80** dans le pare-feu du serveur (Windows : *Pare-feu ▸ Règles de trafic entrant*).
3. Sous XAMPP, Apache écoute par défaut toutes les interfaces ; aucun changement de `httpd.conf` n'est normalement nécessaire.

> **Sécurité.** Conformément au cahier des charges, l'API n'a **pas d'authentification** et la liaison RestoWeb ⇄ RestoSwing est supposée sûre. Ne pas exposer ces scripts sur Internet : n'autoriser que le réseau de la cuisine. Les scripts répondent toujours sans message d'erreur visible (réponse vide ou `[]`) — voir `restoswing/Documentation JSON API.md`.

> Le dossier s'appelle `restoswing/` dans le dépôt, alors que `Documentation JSON API.md` mentionne `/api/`. Les adresses valides sont celles du tableau ci-dessus.

---

## 9. Dépannage

| Symptôme | Cause probable | Solution |
|---|---|---|
| `Erreur de connexion à la base de données : SQLSTATE[HY000] [1049] Unknown database 'apresto'` | `MPD.sql` non importé | Refaire le §5 |
| `… [1045] Access denied for user …` | Identifiants erronés dans `db.php` | Corriger `$dbUser` / `$dbPass` |
| `… [2002] Connection refused` | MySQL arrêté | Démarrer MySQL dans le Control Panel XAMPP |
| `Field 'idUTIL' doesn't have a default value` à l'inscription (idem `idCOM`, `idLIGNCOM`) | Table créée **sans** `AUTO_INCREMENT` | Réimporter `MPD.sql`, ou : `ALTER TABLE utilisateur MODIFY idUTIL BIGINT AUTO_INCREMENT;` (idem pour les 3 autres tables) |
| Import de `MPD.sql` refusé : `#1064 … near '--ALTER TABLE commande …'` | MySQL exige une **espace** après `--` pour qu'une ligne soit un commentaire ; les deux lignes `--ALTER TABLE …` de `MPD.sql` n'en ont pas | Dans `MPD.sql`, supprimer ces deux lignes (elles sont inutiles : les `AUTO_INCREMENT` sont déjà dans les `CREATE TABLE`) ou écrire `-- ALTER …`, puis réimporter |
| `Incorrect integer value: 'Manger sur place' for column typeCOM` au paiement | Colonne `commande.typeCOM` en entier | `ALTER TABLE commande MODIFY typeCOM VARCHAR(50);` |
| `Cannot add or update a child row: a foreign key constraint fails (… idUTIL …)` au paiement | La session pointe vers un utilisateur supprimé/recréé | Se déconnecter (`pages/deconnexion.php`), puis se reconnecter |
| Page blanche | Erreur PHP masquée | Activer `display_errors=On` dans `php.ini` (poste de développement uniquement), relancer Apache |
| `Call to undefined function password_hash()` / `could not find driver` | PHP trop ancien ou `pdo_mysql` absent | Utiliser PHP ≥ 7.4 ; activer `extension=pdo_mysql` dans `php.ini` |
| Port 80 ou 3306 déjà utilisé au démarrage de XAMPP | Skype, IIS, autre MySQL… | Arrêter le service en conflit, ou changer le port dans la configuration Apache/MySQL |
| Caractères accentués illisibles | Mauvais encodage à l'import | Réimporter en choisissant l'encodage **utf-8** ; `db.php` impose déjà `utf8mb4` |
| URL en `ap%20resto` introuvable | Dossier non renommé / mal placé | Renommer en `apresto` (§4) |

---

## 10. Réinitialiser ou désinstaller

**Remettre la base à zéro** (supprime utilisateurs et commandes) — phpMyAdmin ▸ SQL :

```sql
DROP DATABASE apresto;
```

puis refaire le §5.

**Vider seulement les commandes** (conserve comptes et produits) :

```sql
DELETE FROM ligne_de_commande;
DELETE FROM commande;
```

(Supprimer d'abord les lignes, puis les commandes : contraintes de clés étrangères.)

**Désinstaller :** supprimer le dossier `apresto` du dossier de publication, puis la base avec `DROP DATABASE apresto;`.

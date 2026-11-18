# 🍔 Food Express (RestoWeb) – Application web de restauration

> Application web permettant à un client de commander des plats auprès d'un restaurateur, avec suivi de la commande des deux côtés. Projet AP3 – Groupe 2 – BTS SIO 2ème année (SLAM).

---

## 📖 Description détaillée

Le projet **AppResto / RestoWeb** (nom affiché sur le site : **Food Express**) est une application web développée dans le cadre du module **Ateliers de Professionnalisation (AP.SLAM)** en **BTS SIO 2ème année** à l'Institut LIMAYRAC, année scolaire 2026/2027.

- 🧑‍💻 **Côté client** : inscription, connexion, consultation de la carte, choix des quantités, commande sur place ou à emporter, paiement fictif par carte bancaire, suivi de l'état de la commande.
- 👨‍🍳 **Côté restaurateur** : gestion des commandes (accepter, refuser, terminer) depuis l'application Java **RestoSwing**, qui dialogue avec RestoWeb via une API HTTP/JSON.
- 🔔 **Notification** : alerte par e-mail au client lorsque la commande est prête *(prévu, non encore implémenté)*.

**Technologies** : PHP 7.4+ (PDO), MySQL / MariaDB, HTML/CSS, API JSON, Java Swing (RestoSwing). Environnement de développement : XAMPP/WAMP.

---

## 🔑 Comptes prédéfinis

Le script `MPD.sql` ne crée **aucun compte** : les utilisateurs s'inscrivent via `pages/inscription.php`. Le mot de passe est haché (`password_hash`).

| Source | Login | E-mail | Mot de passe |
|--------|-------|--------|--------------|
| Export de secours (`bdd/secour/apresto(secour).sql`) | `test test` | `test.test@test.test` | `<à compléter>` |
| Compte de recette (cf. `Manuels/MANUEL_TEST.md`, à créer par inscription) | `Alice Martin` | `alice.martin@test.local` | `Test1234` |

La connexion se fait avec l'**e-mail** (recommandé) ou le login (« Prénom Nom »).
Il n'existe pas de compte restaurateur : l'API utilisée par RestoSwing n'a **pas d'authentification** (cahier des charges).

---

## 🗂️ Arborescence du projet

```
.
├── BDD/                              # Documents de conception de la base
│   ├── MCD.png
│   ├── MLD.png
│   ├── MLD Textuel
│   └── MPD.sql                       # (copie du script de ap resto/bdd/)
├── DCU + DA/
│   ├── DCU_Restoweb.png              # Diagramme de cas d'utilisation
│   └── DA_Restoweb.png               # Diagramme d'activités
├── Manuels/
│   ├── MANUEL_INSTALLATION.md
│   ├── MANUEL_TEST.md                # Jeu de tests + registre des anomalies
│   └── MANUEL_UTILISATION.md
├── Sitemap + IHM/
│   ├── IHM.jpg
│   └── Sitemap.txt
├── README.md
└── ap resto/                         # Code source de l'application
    ├── index.php                     # Page d'accueil
    ├── bdd/
    │   ├── MPD.sql                   # Création + peuplement (13 produits)
    │   ├── all trigger.sql           # 4 triggers (optionnels, voir plus bas)
    │   └── secour/
    │       └── apresto(secour).sql   # Export phpMyAdmin de secours
    ├── css/
    │   └── maincss.css               # Style des pages
    ├── function_db/
    │   └── db.php                    # Connexion PDO à la base « apresto »
    ├── pages/
    │   ├── connexion.php
    │   ├── deconnexion.php
    │   ├── inscription.php
    │   ├── menu.php                  # Carte : plats et boissons
    │   ├── panier.php                # Récapitulatif, calcul TVA, paiement
    │   └── confirmation.php          # Résumé et état de la commande
    └── restoswing/                   # API HTTP/JSON pour RestoSwing
        ├── commandes_en_attente.php
        ├── commande_accepter.php
        ├── commande_refuser.php
        ├── commande_terminer.php
        ├── confirmation.php          # Version à jour de l'affichage des états (doublon, voir anomalies)
        ├── exemple_commande.json     # Exemple de réponse JSON
        └── Documentation JSON API.md
```

---

## ⚙️ Fonctionnalités

Détail : diagramme de cas d'utilisation dans [`DCU + DA`](./DCU%20%2B%20DA/DCU_Restoweb.png).

| Fonctionnalité | État |
|----------------|------|
| Inscription, connexion, déconnexion | ✅ |
| Affichage de la carte et ajout au panier | ✅ |
| Choix sur place / à emporter et calcul du TTC | ✅ |
| Paiement fictif par carte bancaire | ✅ |
| Suivi de l'état de la commande côté client | ✅ |
| API RestoSwing (lister, accepter, refuser, terminer) | ✅ |
| Notification e-mail « commande prête » | ⏳ non implémentée |
| Modification / vidage du panier | ⏳ non implémentée |
| Application Java RestoSwing (lot 7) | ⏳ hors de ce dépôt |

### Lotissement

| Lot | Thème | Livrables |
|-----|-------|-----------|
| **1** | Conception initiale | Diagrammes (cas d'utilisation, activités), MCD/MLD, IHM & Sitemap |
| **2** | Développement initial (statique) | MPD au format SQL, pages HTML/CSS statiques, Trello |
| **3** | PHP & sessions | `index.php`, `inscription.php`, `connexion.php`, `deconnexion.php`, `menu.php` |
| **4** | Processus de commande | `panier.php` (commande + paiement), `confirmation.php` |
| **5** | API REST (RestoWeb / RestoSwing) | `commandes_en_attente.php`, `commande_accepter.php`, `commande_refuser.php`, `commande_terminer.php` |
| **6** | Documentation | MCD/MLD/MPD/IHM/Sitemap/DCU à jour, valeurs (états, types de conso), maquette JSON, manuels |
| **7** | Application Java RestoSwing | Application Swing consommant l'API RestoWeb |

---

## 🗄️ Base de données `apresto`

### Tables SQL

| Table | Rôle | Colonnes principales |
|-------|------|----------------------|
| `utilisateur` | Clients inscrits | `idUTIL`, `emailUtil`, `loginUtil`, `mdpUtil` (haché) |
| `produit` | Carte du restaurant (prix HT) | `idPROD`, `libellePROD`, `prixHT` |
| `commande` | Commande d'un client | `idCOM`, `etatCOM`, `date_horaireCOM`, `valeurTTC`, `typeCOM`, `TVA`, `idUTIL` |
| `ligne_de_commande` | Produits et quantités d'une commande | `idLIGNCOM`, `quantiteProduit`, `totalHT`, `idCOM`, `idPROD` |

Modèle : `UTILISATEUR 1—N COMMANDE 1—N LIGNE_DE_COMMANDE N—1 PRODUIT` (voir `BDD/MCD.png` et `BDD/MLD.png`).

### Triggers (`ap resto/bdd/all trigger.sql`)

| Trigger | Sur | Rôle |
|---------|-----|------|
| `before_ligne_insert` | `ligne_de_commande` (avant INSERT) | Calcule `totalHT` = quantité × `prixHT` |
| `before_ligne_update` | `ligne_de_commande` (avant UPDATE) | Recalcule `totalHT` |
| `after_ligne_insert` | `ligne_de_commande` (après INSERT) | Recalcule `commande.valeurTTC` = somme HT × (1 + TVA/100) |
| `after_ligne_update` | `ligne_de_commande` (après UPDATE) | Recalcule `commande.valeurTTC` |

> ⚠️ **Ne pas installer en l'état** : les triggers attendent une TVA en pourcentage entier, or `panier.php` enregistre un taux décimal (voir [anomalie ANO-01](./Manuels/MANUEL_TEST.md)). Le site fonctionne sans eux : les montants sont calculés par `panier.php`.
> Il n'y a ni fonction ni procédure stockée.

---

## 🌐 Routes

### Pages web (client)

| Route | Rôle |
|-------|------|
| `/index.php` | Accueil |
| `/pages/inscription.php` | Création de compte |
| `/pages/connexion.php` | Connexion (e-mail ou login) |
| `/pages/deconnexion.php` | Déconnexion |
| `/pages/menu.php` | Carte et ajout au panier |
| `/pages/panier.php` | Récapitulatif, choix du mode, paiement |
| `/pages/confirmation.php` | Résumé et état de la commande |

### API RestoSwing (GET, réponses JSON, sans authentification)

| Route | Description | Réponse |
|-------|-------------|---------|
| `/restoswing/commandes_en_attente.php` | Commandes `en_attente`, de la plus ancienne à la plus récente | Tableau JSON (`[]` si aucune) |
| `/restoswing/commande_accepter.php?id_commande=XX` | `en_attente` → `en_preparation` | Corps vide |
| `/restoswing/commande_refuser.php?id_commande=XX` | `en_attente` ou `en_preparation` → `abandonnee` | Corps vide |
| `/restoswing/commande_terminer.php?id_commande=XX` | `en_preparation` → `prete` | Corps vide |

Les erreurs sont silencieuses (cahier des charges). Détail des champs : [`Documentation JSON API.md`](<./ap%20resto/restoswing/Documentation%20JSON%20API.md>), exemple : `exemple_commande.json`.
⚠️ La documentation parle de `/api/` mais le dossier réel s'appelle `restoswing/`.

---

## 📊 Données pertinentes

### Taux de TVA

| Taux | Cas |
|------|-----|
| **10 %** | Consommation sur place |
| **5,5 %** | Commande à emporter |

Taux uniforme par commande. 🔗 [economie.gouv.fr – TVA réduite restauration](https://www.economie.gouv.fr/cedef/tva-reduite-restauration)

### États de la commande (`commande.etatCOM`)

```
en_attente ──accepter──▶ en_preparation ──terminer──▶ prete
     └───────────refuser───────────┘
               (abandonnee)
```

| Valeur | Signification |
|--------|---------------|
| `en_attente` | Commande payée, pas encore traitée par la cuisine |
| `en_preparation` | Acceptée, en cours de préparation |
| `abandonnee` | Refusée par la cuisine |
| `prete` | Prête à être remise au client |

Ces valeurs doivent rester identiques dans l'API et dans `confirmation.php`.

### Types de consommation (`commande.typeCOM`)

`Manger sur place` · `À emporter`

### Carte (13 produits, prix HT)

Plats : Pizza 5 fromages (13 €), Tacos 3 viandes (11 €), Poulet rôti 2 kg (20 €), Nouilles sautées (10 €), Sachet de frites (6 €), Salade César (10 €), Magret de canard (20 €), Foie gras (8 €), Cœurs de canards 0,5 kg (7 €), Pizza Margherita (10 €).
Boissons : Eau plate 33 cl (4 €), Coca-Cola 33 cl (4 €), Perrier 0,5 L (5 €).

---

## 🐞 Anomalies connues

Le registre complet (ANO-01 à ANO-10) est dans [`Manuels/MANUEL_TEST.md`](./Manuels/MANUEL_TEST.md). Les principales :

- **ANO-01** : `commande.TVA` est un `TINYINT` mais `panier.php` y écrit `0.10` / `0.055` (valeur stockée : 0).
- **ANO-05** : message SQL brut affiché en cas d'erreur dans `panier.php`.
- **ANO-07** : `db.php` peut renvoyer un message d'erreur à RestoSwing si la base est injoignable.

---

## 🌿 Branches Git

| Branche | Rôle |
|---------|------|
| `main` | Version stable du projet |

---

## 📚 Documentation

- **Conception** : [MCD](./BDD/MCD.png), [MLD](./BDD/MLD.png), [DCU](./DCU%20%2B%20DA/DCU_Restoweb.png), [Diagramme d'activités](./DCU%20%2B%20DA/DA_Restoweb.png), [IHM](./Sitemap%20%2B%20IHM/IHM.jpg), [Sitemap](./Sitemap%20%2B%20IHM/Sitemap.txt)
- **Réalisation** : dossier [`ap resto`](./ap%20resto), [documentation de l'API](<./ap%20resto/restoswing/Documentation%20JSON%20API.md>)
- **Exploitation** : [Manuel d'installation](./Manuels/MANUEL_INSTALLATION.md), [Manuel d'utilisation](./Manuels/MANUEL_UTILISATION.md), [Manuel de test](./Manuels/MANUEL_TEST.md)

---

## 👥 Contributeurs

- **Étudiants** : LACAN Liam ([@liamlcn](https://github.com/liamlcn)), MENS Diego, BEKKADOURI Ibrahim, SANTIAGO Rafael
- **Encadrants** : Christophe PUEL, Jean-François RAMIARA
- **Établissement** : Institut LIMAYRAC
- **Formation** : BTS SIO 2ème année – Option SLAM
- **Année scolaire** : 2026/2027

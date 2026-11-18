# Manuel d'utilisation — Food Express (RestoWeb)

> Projet AP3 — BTS SIO 2ᵉ année SLAM — Institut LIMAYRAC
> Dépôt : <https://github.com/liamlcn/AP3-G2-2SIO-RestoWeb>

## Sommaire

1. [Présentation](#1-présentation)
2. [Guide du client](#2-guide-du-client)
3. [Règles de gestion à connaître](#3-règles-de-gestion-à-connaître)
4. [Guide de la cuisine (restaurateur)](#4-guide-de-la-cuisine-restaurateur)
5. [Limites de la version actuelle](#5-limites-de-la-version-actuelle)
6. [Questions fréquentes](#6-questions-fréquentes)
7. [Glossaire](#7-glossaire)

---

## 1. Présentation

**Food Express** permet à un client de commander des plats auprès d'un restaurant, de les consommer **sur place** ou **à emporter**, et de suivre l'avancement de sa commande. Le restaurateur reçoit les commandes en cuisine et indique où elles en sont.

| Profil | Ce qu'il fait | Outil |
|---|---|---|
| 🧑‍💻 **Client** | S'inscrit, choisit ses produits, paie, suit sa commande | Le **site web** (navigateur) |
| 👨‍🍳 **Cuisine / restaurateur** | Consulte les commandes en attente, les accepte, les refuse, les déclare prêtes | L'application **RestoSwing** (Java), qui dialogue avec le site par l'**API** |

**Adresse du site** : `http://<adresse-du-serveur>/apresto/` (en local : `http://localhost/apresto/`). Si le site n'est pas encore installé, voir le [Manuel d'installation](MANUEL_INSTALLATION.md).

**Plan du site :**

```
Accueil (index.php)
├── Inscription ──► Connexion ──► Carte (menu) ──► Panier & paiement ──► Confirmation / suivi
└── Déconnexion
```

---

## 2. Guide du client

### 2.1 Page d'accueil

Ouvrir l'adresse du site. On y trouve :

- en haut à droite, les boutons **Se connecter** et **S'inscrire** (si vous n'êtes pas connecté) ou votre nom et **Se déconnecter** (si vous l'êtes) ;
- le bouton vert **« Voir la carte & Commander ➔ »** qui mène directement à la carte ;
- un encadré rappelant les modes de retrait (sur place / à emporter) et le paiement par carte.

### 2.2 Créer un compte

1. Cliquer sur **S'inscrire**.
2. Remplir les cinq champs, tous obligatoires :

| Champ | Règle |
|---|---|
| Prénom, Nom | Texte libre |
| Adresse e-mail | Adresse valide (ex. `prenom.nom@email.com`) ; **une adresse = un compte** |
| Mot de passe | **6 caractères minimum** |
| Confirmer le mot de passe | Identique au mot de passe |

3. Cliquer sur **S'inscrire**.

✅ Vous arrivez sur la page de connexion avec le message vert « *Votre compte a bien été créé, vous pouvez vous connecter.* ».

❌ En cas d'erreur, un cadre rouge liste ce qu'il faut corriger. Vos prénom, nom et e-mail sont conservés ; seuls les mots de passe sont à ressaisir.

> Votre mot de passe est enregistré **sous forme chiffrée** : personne, y compris l'administrateur, ne peut le relire. S'il est perdu, il n'existe pas de fonction de récupération dans cette version : contacter l'administrateur du site.

### 2.3 Se connecter

1. Cliquer sur **Se connecter**.
2. Saisir **votre adresse e-mail** (recommandé) ou votre identifiant — qui est votre « *Prénom Nom* » tel que saisi à l'inscription, par exemple `Alice Martin` — puis votre mot de passe.
3. Cliquer sur **Se connecter**.

✅ Vous arrivez sur **la carte**.
❌ « *Email/identifiant ou mot de passe incorrect.* » : vérifier la saisie (majuscules, espaces). Le message est volontairement identique que le compte existe ou non.

> Si deux personnes portent exactement les mêmes prénom et nom, seule la première peut se connecter avec son identifiant « Prénom Nom » ; **l'e-mail fonctionne toujours** : privilégiez-le.

### 2.4 Choisir ses produits (la carte)

La carte affiche tous les produits sous forme de cartes : **nom**, **prix** et un sélecteur de quantité.

> ℹ️ Les prix de la carte sont affichés **hors taxes (HT)**. La TVA est ajoutée à l'étape du panier.

Pour chaque produit :

1. Régler la quantité avec **`+`** et **`-`** (minimum 1).
2. Cliquer sur **Ajouter au panier**.

La page se recharge et le bouton en haut à droite affiche le nombre total d'articles : **« 🛒 Voir le Panier (8 articles) »**. Ce nombre est la **somme des quantités** (3 pizzas + 2 salades = 5 articles).

Ajouter plusieurs fois le même produit **cumule** les quantités sur une seule ligne du panier.

### 2.5 Le panier et le mode de consommation

Cliquer sur **🛒 Voir le Panier**. (Cette page demande d'être connecté ; sinon, vous êtes renvoyé vers la connexion.)

La page comporte deux blocs.

**1. Contenu de la commande**

- un tableau : produit, quantité, prix unitaire HT, total de la ligne ;
- le **mode de consommation** : **Manger sur place** (par défaut) ou **À emporter** ;
- le récapitulatif : **Total HT**, **TVA**, **Total TTC**.

Le choix du mode change **immédiatement** la TVA et le total, sans recharger la page :

| Mode | Taux de TVA | Exemple pour 160 € HT |
|---|:-:|---|
| Manger sur place | **10 %** | 16,00 € de TVA → **176,00 € TTC** |
| À emporter | **5,5 %** | 8,80 € de TVA → **168,80 € TTC** |

Le taux est **le même pour toute la commande**.

**2. Paiement par carte bancaire** — voir ci-dessous.

Pour modifier votre sélection, retourner sur la carte via **← Retour à la carte** et ajouter des articles (voir [limites](#5-limites-de-la-version-actuelle) pour retirer un article).

### 2.6 Payer

> ⚠️ **Le paiement est fictif** : aucune banque n'est contactée et aucune donnée de carte n'est conservée. Ne saisissez **jamais** un vrai numéro de carte ; utilisez un numéro d'essai, par exemple `4970 1012 3456 7890`, `12/30`, `123`.

| Champ | Format accepté |
|---|---|
| Numéro de carte | 13 à 23 chiffres, espaces autorisés |
| Date d'expiration | `MM/AA`, par exemple `12/30` (mois de 01 à 12) |
| Code CVC | exactement **3 chiffres** |

Cliquer sur **« Payer … € TTC »** (le montant du bouton suit le mode choisi).

❌ Si un champ est invalide, un cadre rouge l'indique (« Numéro de carte invalide. », « Date d'expiration invalide (format MM/AA). », « Code CVC invalide. »). Rien n'est enregistré et votre panier est conservé.

✅ Sinon, la commande est enregistrée, votre panier est vidé et vous arrivez sur la **page de confirmation**.

### 2.7 Confirmation et suivi

La page **« ✅ Commande Validée ! »** récapitule :

- votre nom et le **montant TTC payé** ;
- le **numéro de commande** (`#CDE-12` par exemple — à conserver) ;
- le **mode** (sur place / à emporter) et la **date et l'heure** ;
- le **statut** de la commande, dans un badge de couleur.

Pour **suivre l'avancement**, rechargez simplement la page (touche **F5**). Vous la retrouvez aussi plus tard en vous reconnectant : la dernière commande est réaffichée.

| Statut affiché | Signification | Ce que vous devez faire |
|---|---|---|
| ⏳ *En attente d'acceptation par le restaurant…* | Payée, pas encore vue par la cuisine | Patienter |
| ✅ *Commande acceptée, en préparation* | La cuisine prépare votre commande | Patienter |
| 🍽️ *Commande prête !* | Votre commande peut être servie / retirée | Vous présenter au comptoir avec votre n° de commande |
| ❌ *Commande refusée par le restaurant* | La cuisine n'a pas pu honorer la commande (rupture, surcharge, fermeture…) | Repasser commande, ou contacter le restaurant |

> Seul **vous** pouvez consulter vos commandes : l'accès à la commande d'un autre client est refusé.

### 2.8 Se déconnecter

Cliquer sur **Se déconnecter** (en haut de la page d'accueil). Un message « *Vous êtes déconnecté* » s'affiche puis vous revenez à l'accueil. **Votre panier en cours est vidé** à la déconnexion.

---

## 3. Règles de gestion à connaître

| Règle | Détail |
|---|---|
| **TVA** | 10 % pour une consommation **sur place**, 5,5 % pour une commande **à emporter**, identique pour tous les produits d'une commande |
| **Prix** | Affichés **HT** sur la carte ; total TTC = total HT × (1 + taux) |
| **Calcul d'une ligne** | quantité × prix HT unitaire |
| **Compte** | Une adresse e-mail = un compte ; mot de passe de 6 caractères minimum, stocké chiffré |
| **Panier** | Mémorisé pendant votre session ; vidé au paiement et à la déconnexion |
| **Paiement** | Fictif ; un format de carte valide suffit |
| **Commande** | Créée avec le statut « en attente » dès que le paiement est validé |
| **États d'une commande** | `en_attente` → `en_preparation` → `prete` ; ou `abandonnee` (refusée) |

Cycle de vie d'une commande :

```
                  ┌──────────── refuser ───────────┐
                  │                                 ▼
 (paiement) ► en_attente ─ accepter ► en_preparation ─ terminer ► prete
                  │                        │
                  └──── refuser ───────────┴────────────────────► abandonnee
```

- On ne peut **terminer** qu'une commande **en préparation** ; on ne peut **accepter** qu'une commande **en attente**.
- On peut **refuser** une commande **en attente** ou **en préparation** ; une commande déjà **prête** ne peut plus être refusée.
- Une action impossible dans l'état courant est **ignorée sans message** : elle ne change rien.

---

## 4. Guide de la cuisine (restaurateur)

### 4.1 Principe

La cuisine ne passe pas par le site web : l'application **RestoSwing** interroge régulièrement l'**API** du serveur pour afficher les commandes à traiter, et envoie les décisions du cuisinier (accepter, refuser, terminer). Le client voit ensuite le nouveau statut en rechargeant sa page de confirmation.

```
Client paie ──► commande « en attente » ──► RestoSwing la liste ──► le cuisinier clique :
   Accepter  →  « en préparation »      Refuser  →  « refusée »      Terminer  →  « prête »
```

### 4.2 Flux de travail conseillé

1. **Rafraîchir** la liste : toutes les commandes **en attente**, de la plus ancienne à la plus récente, avec le détail des produits.
2. Pour chaque commande :
   - **Accepter** si elle peut être préparée → elle disparaît de la liste « en attente » et passe en préparation ;
   - **Refuser** en cas d'impossibilité (plus d'ingrédient, trop de travail, panne, fermeture…) → le client est informé par le statut « refusée ».
3. Quand le plat est terminé : **Terminer** → le client voit « Commande prête ! ».

### 4.3 Informations affichées pour chaque commande

| Information | Exemple | Utilité |
|---|---|---|
| `id_commande` | 101 | Numéro de la commande (le client voit `#CDE-101`) |
| `date_heure` | 2026-10-14 13:45:00 | Ordre d'arrivée |
| `client` | Jean Dupont | À qui remettre la commande |
| `mode` | Manger sur place / À emporter | Service en salle ou emballage |
| `produits` | Magret de canard × 8 | Quoi préparer |
| `montant_ttc` | 176.00 | Montant payé par le client |

### 4.4 Utiliser l'API directement (sans RestoSwing)

Utile pour dépanner ou démontrer le fonctionnement : toutes les requêtes sont de simples adresses ouvertes dans un navigateur (ou avec `curl`). En local, l'adresse de base est `http://localhost/apresto/restoswing`.

| Action | Adresse | Réponse |
|---|---|---|
| Voir les commandes en attente | `…/restoswing/commandes_en_attente.php` | Liste JSON (ou `[]` si aucune) |
| Accepter la commande 101 | `…/restoswing/commande_accepter.php?id_commande=101` | Aucune (page vide) |
| Refuser la commande 101 | `…/restoswing/commande_refuser.php?id_commande=101` | Aucune |
| Terminer la commande 101 | `…/restoswing/commande_terminer.php?id_commande=101` | Aucune |

Exemple de réponse de la liste :

```json
[
  {
    "id_commande": 102,
    "date_heure": "2026-10-14 13:52:00",
    "montant_ttc": 46.42,
    "tva": 0.055,
    "mode": "À emporter",
    "client": "Marina Dubois",
    "produits": [
      { "libelle": "Pizza 5 fromages", "quantite": 2, "total_ht": 26.00 },
      { "libelle": "Sachet de frites", "quantite": 3, "total_ht": 18.00 }
    ]
  }
]
```

**Comportement à connaître :**

- Les actions (accepter, refuser, terminer) **ne renvoient rien** : pour vérifier le résultat, relire la liste ou consulter la base.
- **Aucun message d'erreur** n'est jamais affiché : un numéro inexistant, absent ou une transition interdite sont simplement ignorés.
- Une commande acceptée, refusée ou terminée **n'apparaît plus** dans la liste « en attente ».
- L'API n'est **pas protégée par mot de passe** (choix du cahier des charges) : elle doit rester accessible uniquement depuis le réseau de la cuisine.

Spécification complète : `ap resto/restoswing/Documentation JSON API.md`.

---

## 5. Limites de la version actuelle

Ces points sont connus ; ils sont détaillés dans le [registre des anomalies du manuel de test](MANUEL_TEST.md#7-registre-des-anomalies-connues).

**Fonctions annoncées mais pas encore disponibles**

| Fonction | État |
|---|---|
| **Notification par e-mail** quand la commande est prête (mentionnée dans les pages) | Non développée : suivre sa commande en rechargeant la page de confirmation |
| **Tableau de bord web** du restaurateur (onglets En attente / En préparation / Prêtes) | Non développé : la cuisine passe par RestoSwing (ou l'API, §4.4) |
| Statut « Retirée » (commande remise au client) | Non géré |
| Récupération d'un mot de passe oublié, modification du profil | Non prévus dans cette version |
| Vrai paiement bancaire | Paiement volontairement fictif |

**Comportements à contourner en attendant les corrections**

| Situation | Que faire |
|---|---|
| Retirer un article ou changer une quantité **dans le panier** (ANO-09) | La page Panier ne le permet pas. Se déconnecter puis se reconnecter vide le panier ; refaire alors la sélection |
| Bouton **Se déconnecter** en haut de la **carte** (ANO-02) | Il n'ouvre pas la bonne page. Se déconnecter depuis la page **d'accueil**, ou ouvrir l'adresse `…/pages/deconnexion.php` |
| Nom affiché « M le prof » en haut de la carte (ANO-02) | Texte fixe : sans incidence sur votre compte |
| Bouton **← Accueil** d'une page de connexion/inscription, ou retour automatique après la déconnexion, qui n'aboutit pas (ANO-03) | Revenir à l'accueil en saisissant `http://<serveur>/apresto/` |
| Statut affiché sous forme de code brut (`en_preparation`, `abandonnee`) (ANO-04) | Signification : *en préparation* / *refusée* (tableau du §2.7) |

---

## 6. Questions fréquentes

**Je ne reçois aucun e-mail.**
La notification par e-mail n'est pas encore active. Rechargez votre page de confirmation pour suivre l'état.

**Pourquoi le prix à payer est-il supérieur à la somme des prix de la carte ?**
Les prix de la carte sont **HT** ; la TVA (10 % ou 5,5 %) s'ajoute au panier.

**Pourquoi le total change-t-il quand je choisis « À emporter » ?**
Le taux de TVA est de 5,5 % à emporter contre 10 % sur place.

**Mon panier est vide alors que j'avais ajouté des articles.**
Le panier est lié à votre session : il disparaît à la déconnexion, après un paiement, ou si votre session a expiré (fermeture du navigateur). Refaire la sélection.

**Le site me renvoie vers la connexion quand j'ouvre le panier.**
Le panier et la confirmation exigent d'être connecté. Connectez-vous, puis rouvrez le panier.

**J'ai perdu le numéro de ma commande.**
Reconnectez-vous et ouvrez la page de confirmation : votre dernière commande est réaffichée avec son numéro.

**Ma commande est « en attente » depuis longtemps.**
Elle n'a pas encore été vue par la cuisine. Vérifier avec le restaurant ; la cuisine doit avoir RestoSwing ouvert (ou consulter la liste via l'API).

**Message « Erreur de connexion à la base de données ».**
Problème côté serveur (base arrêtée ou mal configurée) : prévenir l'administrateur, voir le [dépannage du manuel d'installation](MANUEL_INSTALLATION.md#9-dépannage).

**Je suis la cuisine et RestoSwing n'affiche rien.**
Ouvrir `…/restoswing/commandes_en_attente.php` dans un navigateur : si la réponse est `[]`, il n'y a simplement aucune commande en attente ; si la page ne s'ouvre pas, vérifier l'adresse du serveur et que Apache/MySQL sont démarrés.

---

## 7. Glossaire

| Terme | Définition |
|---|---|
| **HT / TTC** | Hors taxes / toutes taxes comprises (TVA incluse) |
| **TVA** | Taxe sur la valeur ajoutée : 10 % sur place, 5,5 % à emporter |
| **Sur place / À emporter** | Mode de consommation choisi au panier |
| **Commande** | Ensemble de produits payés en une fois, avec un numéro, un mode, un montant et un statut |
| **Ligne de commande** | Un produit et sa quantité au sein d'une commande |
| **Statut / état** | Étape d'avancement : en attente, en préparation, prête, refusée (« abandonnée ») |
| **Session** | Période pendant laquelle le site vous reconnaît après connexion ; le panier y est conservé |
| **API** | Interface permettant à RestoSwing d'échanger avec le site (adresses web renvoyant du JSON) |
| **JSON** | Format texte structuré utilisé par l'API (`{ "clé": valeur }`) |
| **RestoWeb** | Le site web et son serveur (cette application) |
| **RestoSwing** | L'application Java de la cuisine, cliente de l'API |

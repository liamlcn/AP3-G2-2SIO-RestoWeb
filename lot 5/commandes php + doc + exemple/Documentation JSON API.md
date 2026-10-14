# API RestoWeb — Documentation technique (Lot 5)

## Contexte

Cette API permet à **RestoSwing** (application graphique Java utilisée en cuisine) de communiquer avec **RestoWeb** (ce serveur). RestoWeb est le serveur, RestoSwing est le client.

- Toutes les requêtes sont en **HTTP** (GET).
- Toutes les réponses sont en **JSON**.
- La liaison est considérée comme sécurisée : **aucune authentification** n'est mise en œuvre sur ces endpoints.
- **Aucun message d'erreur n'est renvoyé par le serveur** en cas de problème (erreur silencieuse) : une requête invalide ou une erreur interne se traduit par une réponse vide ou neutre (tableau vide, ou simplement aucune action), jamais par un message d'erreur visible.

Base URL : `http://<mon application restoweb>/api/`

## Cycle de vie d'une commande (colonne `etatCOM`)

```
en_attente  --accepter-->  en_preparation  --terminer-->  prete
     |                            |
     '----------refuser----------'
                 (devient "abandonnee")
```

| Valeur `etatCOM` | Signification                                         |
|-------------------|--------------------------------------------------------|
| `en_attente`       | Commande payée, pas encore traitée par la cuisine      |
| `en_preparation`   | Commande acceptée, en cours de préparation             |
| `abandonnee`       | Commande refusée par la cuisine                        |
| `prete`            | Commande terminée, prête à être servie/remise au client |

⚠️ Ces libellés doivent rester identiques dans toute l'application (API **et** `confirmation.php`), sinon le statut affiché au client ne correspondra plus à la réalité.

---

## 1. Liste des commandes en attente

```
GET /api/commandes_en_attente.php
```

Retourne toutes les commandes dont `etatCOM = 'en_attente'`, triées par date croissante (les plus anciennes en premier).

**Réponse** : `Content-Type: application/json`

```json
[
    {
        "id_commande": 101,
        "date_heure": "2026-10-14 13:45:00",
        "montant_ttc": 176.00,
        "tva": 0.10,
        "mode": "Manger sur place",
        "client": "Jean Dupont",
        "produits": [
            { "libelle": "Magret de canard", "quantite": 8, "total_ht": 160.00 }
        ]
    }
]
```

| Champ                  | Type   | Description                                      |
|-------------------------|--------|---------------------------------------------------|
| `id_commande`            | int    | Identifiant de la commande (`idCOM`)              |
| `date_heure`             | string | Date/heure de la commande (`YYYY-MM-DD HH:MM:SS`) |
| `montant_ttc`            | float  | Total TTC de la commande                          |
| `tva`                    | float  | Taux de TVA appliqué (ex : `0.10`, `0.055`)       |
| `mode`                   | string | `"Manger sur place"` ou `"À emporter"`            |
| `client`                 | string | Nom/login du client ayant passé la commande       |
| `produits`               | array  | Liste des lignes de la commande                   |
| `produits[].libelle`     | string | Nom du produit                                    |
| `produits[].quantite`    | int    | Quantité commandée                                |
| `produits[].total_ht`    | float  | Total HT de la ligne (quantité × prix unitaire HT)|

S'il n'y a aucune commande en attente, la réponse est un tableau JSON vide : `[]`.

---

## 2. Accepter une commande

```
GET /api/commande_accepter.php?id_commande=XX
```

Fait passer la commande `XX` de l'état `en_attente` à `en_preparation`. Si la commande n'existe pas, n'est pas dans l'état `en_attente`, ou si `id_commande` est absent/invalide, la requête n'a aucun effet (pas de message d'erreur).

**Réponse** : aucune (corps vide).

---

## 3. Refuser une commande

```
GET /api/commande_refuser.php?id_commande=XX
```

Fait passer la commande `XX` à l'état `abandonnee` (manque d'ingrédient, surcharge de travail, panne, fermeture...). Autorisé depuis `en_attente` ou `en_preparation`. Mêmes conditions d'échec silencieux que ci-dessus.

**Réponse** : aucune (corps vide).

---

## 4. Terminer une commande

```
GET /api/commande_terminer.php?id_commande=XX
```

Fait passer la commande `XX` de l'état `en_preparation` à `prete`. Mêmes conditions d'échec silencieux que ci-dessus.

**Réponse** : aucune (corps vide).

---

## Exemple d'utilisation côté RestoSwing

1. Toutes les N secondes, RestoSwing interroge `commandes_en_attente.php` et rafraîchit l'écran cuisine avec la liste reçue.
2. Quand le personnel clique sur "Accepter" pour une commande, RestoSwing appelle `commande_accepter.php?id_commande=101`, puis relance une lecture de `commandes_en_attente.php` (la commande acceptée disparaît de la liste puisqu'elle n'est plus `en_attente`).
3. Idem pour "Refuser" → `commande_refuser.php`, et pour "Terminer" → `commande_terminer.php` une fois la commande en préparation.

## Fichiers livrés

- `commandes_en_attente.php`
- `commande_accepter.php`
- `commande_refuser.php`
- `commande_terminer.php`
- `exemple_commandes_en_attente.json` — exemple représentatif de réponse JSON
- `README.md` — ce document

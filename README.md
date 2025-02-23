# 🚀 Projet Symfony 2 - Backoffice Entreprise

Bienvenue dans le projet Symfony **Backoffice Entreprise** ! Ce projet permet de gérer les **utilisateurs, clients et produits** via une interface sécurisée.

📌 **Lien du projet sur GitHub :** [ProjetSymfony2](https://github.com/xavierkno/ProjetSymfony2)

📌 **Lien de la vidéo sur Youtube :** [ProjetSymfony2](https://github.com/xavierkno/ProjetSymfony2)

---

## ⚙️ Installation du Projet

### 1️⃣ **Cloner le dépôt**
Ouvrez un terminal et exécutez la commande suivante :
```sh
git clone https://github.com/xavierkno/ProjetSymfony2.git
```
```sh
cd ProjetSymfony2
```

### 2️⃣ **Installer les dépendances**
```sh
composer install
```

### 3️⃣ **Créer la base de données**
```sh
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 4️⃣ **Charger les données de test (fixtures)**
```sh
php bin/console doctrine:fixtures:load
```

### 5️⃣**Lancer le serveur Symfony**
```sh
symfony server:start
```
Le projet est maintenant accessible sur **[http://127.0.0.1:8000](http://127.0.0.1:8000)** 🎉

---

## 🛠 **Fonctionnalités Implémentées**
✅ **Authentification et gestion des rôles (Admin, Manager, Utilisateur)**  
✅ **Gestion des utilisateurs (ajout, modification, suppression)**  
✅ **Gestion des clients (ajout, modification, suppression)**  
✅ **Gestion des produits (ajout, modification, suppression)**  
✅ **Importation et exportation des produits via CSV**  
✅ **Commandes Symfony pour ajouter des clients via CLI**  
✅ **Système de sécurité avec Voters**  

---

## 🧩 **Comment Exécuter les Tests**
### 1️⃣ **Lancer les tests unitaires**
Exécutez la commande suivante :
```sh
php bin/phpunit
```
Pour tester uniquement un fichier spécifique :
```sh
php bin/phpunit tests/Voter/VoterTest.php
```

## 🌟 **Droits et Auteurs**
Ce projet a été réalisé par **Xavier Kno**.  
© 2024 - Tous droits réservés.

---


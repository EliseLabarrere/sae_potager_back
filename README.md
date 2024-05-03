# Guide de Configuration du Backend Laravel

Ce guide vous aidera à configurer le backend Laravel après avoir récupéré le code depuis le dépôt Git.
## Installation des Dépendances

Avant de démarrer, assurez-vous d'avoir installé Composer sur votre machine. Ensuite, suivez ces étapes :

1.    Ouvrez un terminal et accédez au répertoire du projet Laravel.
1.    Exécutez la commande suivante pour installer les dépendances :

```bash
composer install
```

## Configuration de la Base de Données

1.    Renommez le fichier .env.example en .env.
2.    Ouvrez le fichier .env dans un éditeur de texte.
3.    Définissez toutes les variables commençant par DB_ avec les informations de votre base de données, telles que l'hôte, le nom de la base de données, le nom d'utilisateur et le mot de passe.

## Migration de la Base de Données

1.    Assurez-vous que la configuration de la base de données dans le fichier .env est correcte.
2.    Exécutez la commande suivante pour migrer les tables de la base de données :

```bash
php artisan migrate
```

## Importation des Données

1.    Un fichier .sql contenant des données de base peut être fourni.
2.    Assurez-vous d'avoir accès à ce fichier .sql.
3.    Exécutez les commandes nécessaires pour importer les données de ce fichier dans votre base de données.

## Démarrage du Serveur de Développement

Une fois que vous avez terminé les étapes ci-dessus, vous pouvez démarrer le serveur de développement Laravel en exécutant la commande suivante :

```bash
php artisan serve
```

Le serveur de développement démarrera à l'adresse par défaut http://localhost:8000.

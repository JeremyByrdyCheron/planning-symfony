# Symfony Docker Project Setup

This repository contains a Docker-based development environment for Symfony applications.

## Prerequisites

- Docker
- Docker Compose
- Git

## Getting Started

### 1. Clone this repository

```bash
git clone git@github.com:Webanimus/symfony-dev-docker-base.git
cd symfony-dev-docker-base
```

### 2. Start the Docker environment

```bash
docker compose up -d --build
```

### 3. Install dependencies

```bash
docker compose exec php composer install
```

### 4. Configure the environment

Copie le fichier `.env` et adapte les variables :

```bash
cp .env .env.local
```

Vérifie que la `DATABASE_URL` correspond bien à :

```dotenv
DATABASE_URL="mysql://symfony:symfony@database:3306/symfony?serverVersion=mariadb-10.11.2"
```

### 5. Set up the database

```bash
docker compose exec php php bin/console doctrine:database:create
docker compose exec php php bin/console doctrine:migrations:migrate
```

### 6. Set proper permissions

```bash
docker compose exec php chown -R www-data:www-data var
```

### 7. Create an admin user

First, hash your password:

```bash
docker compose exec php php bin/console security:hash-password
```

Then insert the admin user into the database:

```bash
docker compose exec php php bin/console doctrine:query:sql "INSERT INTO \`user\` (\`email\`, \`roles\`, \`password\`) VALUES ('admin@example.com', '[\"ROLE_ADMIN\"]', 'your-hashed-password');"
```

> Replace `admin@example.com` and `your-hashed-password` with your actual values.

---

## Accessing the Application

| Service             | URL                   |
| ------------------- | --------------------- |
| Symfony application | http://localhost:8080 |
| phpMyAdmin          | http://localhost:8081 |
| MailHog             | http://localhost:8025 |

---

## Docker Services

- **PHP (8.2-FPM)** : PHP avec toutes les extensions nécessaires à Symfony
- **Nginx** : Serveur web
- **MariaDB (10.11.2)** : Base de données
- **phpMyAdmin** : Interface de gestion de la base de données
- **MailHog** : Outil de test d'envoi d'e-mails

### Database Credentials

| Paramètre     | Valeur  |
| ------------- | ------- |
| Database      | symfony |
| Username      | symfony |
| Password      | symfony |
| Root Password | root    |

---

## Common Commands

| Action                    | Commande                                                              |
| ------------------------- | --------------------------------------------------------------------- |
| Démarrer l'environnement  | `docker compose up -d`                                                |
| Arrêter l'environnement   | `docker compose down`                                                 |
| Accéder au container PHP  | `docker compose exec php bash`                                        |
| Installer les dépendances | `docker compose exec php composer install`                            |
| Vider le cache Symfony    | `docker compose exec php php bin/console cache:clear`                 |
| Lancer les migrations     | `docker compose exec php php bin/console doctrine:migrations:migrate` |

---

## Troubleshooting

**Problème de permissions :**

```bash
docker compose exec php chown -R www-data:www-data var
```

**Composer manque de mémoire :**

```bash
docker compose exec php php -d memory_limit=-1 /usr/bin/composer install
```

**Voir les logs :**

```bash
docker compose logs -f
```

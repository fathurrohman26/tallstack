# Tallstack

> This project uses laravel version 9.x, requires php version ^8.0

### Requirements

-   PHP
-   NodeJS (with npm or yarn)
-   GIT Client
-   Composer
-   Terminal / CMD [Git Bash](https://git-scm.com/downloads)
-   MySQL / MariaDB

### Database

Create database called `tallstack` using [phpMyAdmin](https://www.phpmyadmin.net/) or cli

```bash
» mariadb -u root -p
Enter password:
Welcome to the MariaDB monitor.  Commands end with ; or \g.
Your MariaDB connection id is 471
Server version: 10.9.4-MariaDB Arch Linux

Copyright (c) 2000, 2018, Oracle, MariaDB Corporation Ab and others.

Type 'help;' or '\h' for help. Type '\c' to clear the current input statement.

MariaDB [(none)]> CREATE DATABASE IF NOT EXISTS tallstack;
Query OK, 1 row affected (0.059 sec)

MariaDB [(none)]> Bye
```

Press `CTRL`+`d` to exit

### Install

```bash
git clone https://github.com/fathurrohman26/tallstack
cd tallstack
composer install
npm install
npm run build
```

### Conf

Configuration file

```bash
cp .env.example .env
```

Configure database connection

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tallstack
DB_USERNAME=root
DB_PASSWORD=root
```

Set the application key

```bash
php artisan key:generate
```

Configure mailtrap (dev purpose)

-   [Register to MailTrap for free](https://mailtrap.io/register/signup?ref=pricing_table_summary)
-   Create New Inbox called `tallstack`
-   Enter Inbox page
-   Select Laravel 7+ (dropdown integrations)
-   Update those values in .env

```ini
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=replace-your-own
MAIL_PASSWORD=replace-your-own
MAIL_ENCRYPTION=tls
```

### Database Migration & Seeder

```bash
php artisan migrate --seed
```

If the database has previously been used try

```bash
php artisan migrate:f --seed
```

> Warn: It will delete all tables in database be careful

### Launch

```bash
php artisan serve
```

Open http://localhost:8000 Or any other url given by laravel shown in terminal

Demo User (email verified):

-   EMail : `confirmed@user.test`
-   Passw : `password`

Demo User (email unverified)

-   EMail : `confirmed@user.test`
-   Passw : `unconfirmed@user.test`

### Unit Test

```bash
# All Tests
php artisan test

# Filter (Profile)
php artisan test --filter ProfileTest
```

Coverage with [Xdebug](https://xdebug.org/)

Enable coverage mode in php.ini

```ini
xdebug.mode=coverage
```

```bash
php artisan test --coverage
```

> Warn: Running the test will reset the database if the database for the test is not specified.

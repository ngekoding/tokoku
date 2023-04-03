# Tokoku

Simple Point of Sales (POS) app built with Laravel Breeze and Vue.

## Screenshots

![Add Transaction](./screenshots/transaction-create.png)

![Detail Transaction](./screenshots/transaction-detail.png)

## Requirements

This project is build with Laravel 10.x, so the requirements is same as the framework.

- Composer
- PHP 8.1 or above
- MySQL 5.7+ or any [supported databases](https://laravel.com/docs/10.x/database)
- Node.js 14.18+, 16+

## Installation

- Create new database (e.g. `tokoku`)
- Open your CMD/Terminal and follow the below commands

```sh
git clone https://github.com/ngekoding/tokoku.git
cd tokoku

# Create .env by copying the .env.example
cp .env.example .env

# Generate key
php artisan key:generate --ansi

# Installing dependencies
composer install
npm install
```

- Change your database configurations in `.env` file
- Run the migration and seeder for dummy data

```sh
php artisan migrate --seed
```

### Run for Development

When running the project for development, you need to run both the server-side and client-side. So you need to open 2 CMD/Terminal.

- Run for client-side script
```sh
npm run dev
```

- Run for server-side script

```sh
php artisan serve
```

- Then open the address for the server-side (e.g. `http:\\localhost:8000`)

### Accounts for Log in

There are two accounts was created by the user seeder, that different by it's role and access.

**Super Admin**
- Email: superadmin@tokoku.com
- Password: secret

**Staff**
- Email: staff@tokoku.com
- Password: secret

The default password configuration can be found in `.env` file at `DEFAULT_USER_PASSWORD`.

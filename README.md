# Laravel CMS Boilerplate

Boilerplate for multilingual CMS using Laravel & Vue.js.

## Installation

Install dependencies
```
composer install
yarn install
```

Create `.env` file and change
```
cp .env.example .env
```

Create database
```
php artisan migrate
```

You can optionally generate fake data using factories with the `--seed` flag.
Create a user
```
php artisan user:create
```

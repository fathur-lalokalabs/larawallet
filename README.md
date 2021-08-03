## About LaraWallet

LaraWallet is a sample e-wallet web application for learning purpose. Authenticated user can transfer credit to others user. 

### Requirement

- PHP 7.4
- MYSQL
- Composer
- NPM

### Install

```
git clone git@github.com:fathur-xoxzo/larawallet.git
cd larawallet
cp .env.example .env
composer install
npm install
npm run dev
# once you setup DB config in .env, then you can migrate
php artisan migrate
php artisan db:seed
```

### Get started

- Register your account and login
- Try to perform Credit Transfer

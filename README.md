# CkManager

Visit at <a href="https://ckmanager.com/" target="_blank">ckmanager.com</a>
Username: test@gmail.com
Password: 123456789

CkManager is a web-application to manage business operations from many user's e-commerce websites:

- E-commerce websites.
- Products & Inventory.
- Orders.
- Customer.

## Provides APIs

CkManager provides many APIs to front-end websites for using:

- Display products.
- Customer Login/Register.
- Place orders.

## Running CkManager

After cloning from github, set up the .env file then do the following steps:

```bash
composer install
```

```bash
php artisan key:generate
```

```bash
php artisan migrate
```

```bash
php artisan db:seed
```

```bash
php artisan storage:link
```

To start CkManager:

```bash
php artisan serve
```

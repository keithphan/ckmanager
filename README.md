<p align="center">CkManager</p>

## About CkManager

CkManager is a web-application to manage business operations from many user's e-commerce websites:

- E-commerce websites.
- Products & Inventory.
- Orders.
- Customer.

## Prodive APIs

CkManager provides many APIs to front-end websites for using:

- Display products.
- Cutomer Login/Register.
- Place orders.

## Running CkManager

After cloning from github, do the following steps:

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

To start CkManager:

```bash
php artisan serve
```

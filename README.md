## Product Catalog

## Requirements

• PHP 8.1 or higher

## Version

This Laravel framework is running on a version of 10.25.2 and Bootstrap is running on 5.3.2.

## Usage <br>

Clone the repository <br>

```
git clone git@github.com:ushanmithma/product_catalog.git
```

Change directories into web <br>

```
cd product_catalog/
```

Install composer <br>

```
composer install
```

Create the .env file by duplicating the .env.example file <br>

```
cp .env.example .env
```

Set the APP_KEY value <br>

```
php artisan key:generate
```

Clear your cache & config (OPTIONAL)

```
php artisan cache:clear && php artisan config:clear
```

Run migrations and seeds

```
php artisan migrate --seed
```

Finally, run your project in the browser!

```
php artisan serve
```

User Account,

```
Email: test@example.com
Password: 0000
```

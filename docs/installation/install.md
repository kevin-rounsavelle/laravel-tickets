# Install

Clone the repository and install dependencies.

```bash
composer install
npm install
npm run build
```

Configure `.env`, generate the key, and migrate:

```bash
php artisan key:generate
php artisan migrate --seed
```

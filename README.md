
# Clone it in your machine
- Clone the repo
- Edit .env
- Generate key
```code
php artisan key:generate
```
- Migrate to database
```code
php artisan migrate --seed
```
- Install passport
```code
php artisan passport:install
php artisan passport:keys
```

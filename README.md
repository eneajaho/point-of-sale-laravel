
# Clone it in your machine
- Clone the repo
- Edit .env
- Generate key
```code
php artisan key:generate
```
- Migrate to database
```code
php artisan migrate:fresh --seed
```
- Install passport
```code
php artisan passport:install
php artisan passport:keys
```

- Link storage
```code
php artisan storage:link
```

## UI Angular app
Find the frontend code here: [Point of sale Angular](https://github.com/eneajaho/point-of-sale-angular)

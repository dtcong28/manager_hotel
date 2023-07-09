## Project Information
```
- Laravel: 9.x
- Apache: 2.4
- PHP: 8.1.12 
- MySQL: 8.x
- Composer: 2.1.x
```

## Installer
```
0. clone project, setting virtual host, create database
1. run: composer install 
2. run and change setting config: cp .env.example .env (change setting APP_URL, DB, MAIL ...)
3. run: php artisan key:generate
4. clear cache: php artisan optimize:clear
5. create storage link: php artisan storage:link
6. run migrate: php artisan migrate
7. run seeder create user: php artisan db:seed --class=UserSeeder
```
## Run test stripe in local 
```
- stripe login
- stripe listen --forward-to dev.hotel.local/booking/webhook
- test : stripe trigger payment_intent.succeeded
```
## SSL
```
- 3 tháng vào đăng kí lại 1 lần để dùng miễn phí: https://www.sslforfree.com/
```
## Build Production 
```
- npm run build
```

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
```

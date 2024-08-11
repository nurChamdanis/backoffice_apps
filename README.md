## BILPAY MULTIPAYMENT APP
### Error Code API
- 0023 = Poin referral not set
- 0024 = Nominal poin referral not set
- 0025 = Poin deposit not set
- 0026 = Nominal poin deposit not set 
- 0027 = Request top up Anda telah mencapai limit harian
- 0028 = Kode pembayaran tidak tersedia
- 0029 = Limit deposit Anda telah mencapai batas
- 0030 = Mode maintenance not set

### Installation Instructions

1. Clone repository Bilpay
2. Create a MySQL database for the project
    - `mysql -u root -p`, if using Vagrant: `mysql -u homestead -psecret`
    - `create database bilpay;`
    - `\q`
3. From the projects root run `cp .env.example .env`
4. Configure your `.env` file
5. Install composer, php-mysql, php-ext and php-dom (dependent on your distrubtion, For Debian run `apt install composer php-mysql php-ext php-dom`)
6. Run `composer update` from the projects root folder
7. From the projects root folder run:

```
php artisan vendor:publish --tag=laravel2step &&
php artisan vendor:publish --tag=laravel-email-database-log-migration
```

7. From the projects root folder run `sudo chmod -R 755 ../backoffice_app`
8. From the projects root folder run `php artisan key:generate`
9. From the projects root folder run `php artisan migrate`
10. From the projects root folder run `composer dump-autoload`
11. From the projects root folder run `php artisan db:seed`
12. Compile the front end assets with [npm steps](#using-npm) or [yarn steps](#using-yarn).

#### Build the Front End Assets with Mix

##### Using Yarn:

1. Install yarn (dependent on your distribution)
2. From the projects root folder run `yarn install`
3. From the projects root folder run `yarn run dev` or `yarn run production`

-   You can watch assets with `yarn run watch`

##### Using NPM:

1. From the projects root folder run `npm install`
2. From the projects root folder run `npm run dev` or `npm run production`

-   You can watch assets with `npm run watch`

#### Optionally Build Cache

1. From the projects root folder run `php artisan config:cache`
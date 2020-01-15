# Laravel Boilerplate (Current: Laravel 6.*)
<p align="center">by <a href="https://www.kainotomo.com/"><img src="https://www.kainotomo.com/images/kainotomo-logo.png" width="15">AINOTOMO PH</a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://poser.pugx.org/laravel/framework/license.svg" alt="License"></a>
</p>

## Installation

Copy file .env.example to .env and edit appropriately values to connect to database.

For administrator credentials modify parameters:
- ADMIN_EMAIL
- ADMIN_PASSWORD

Run below commands:

- `composer install`
- `npm install`
- `php artisan session:table`
- `php artisan migrate`
- `php artisan db:seed`

## Administrator Credentials

**User:** admin@admin.com  
**Password:** Administr@tor

## About Laravel Boilerplate

Laravel Boilerplate is a starting point for a new Laravel application.

### Features
- Account Control System https://docs.spatie.be/laravel-permission/v3/introduction/
- Oauth login https://laravel.com/docs/6.x/socialite
- Subsciption system https://laravel.com/docs/6.x/billing

## Contributing

Raise an issue

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

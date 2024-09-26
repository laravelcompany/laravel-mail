<p align="center"><img src="https://i.imgur.com/yueknrU_d.jpg?maxwidth=520&shape=thumb&fidelity=high" width="250"></p>


The Missing Mail Platform for Laravel

- [Website](https://laravelmail.com)
- [Documentation](https://docs.laravelmail.com/)

## Introduction

The core functionality of Laravel Mail is contained within the [Laravel Mail Core](https://github.com/laravelcompany/laravel-mail) package. If you would like to add SendPortal to an existing application that already handles user authentication, you only require [Laravel Mail Core](https://laravelmail.com/).

## Features
Laravel Mail includes subscriber and list management, email campaigns, message tracking, reports and multiple workspaces/domains in a modern, flexible and scalable application.

Laravel Mail integrates with [Amazon SES](https://aws.amazon.com/ses), [Postmark](https://postmarkapp.com), [Sendgrid](https://sendgrid.com), [Mailgun](https://www.mailgun.com/), [Mailjet](https://www.mailjet.com) and [ZeptoMail](https://www.zeptomail.com/) to send and receive emails.

The [Laravel Mail](https://laravelmail.com) application acts as a wrapper around Laravel Mail Core. This will allow you to run your own copy of Laravel Mail as a stand-alone application, including user authentication and multiple workspaces.

## Installation

If you would like to install SendPortal as a stand-alone application, please follow the [installation guide](https://docs.laravelmail.com/).

If you would like to add SendPortal to an existing application, please follow the [package installation guide](https://docs.laravelmail.com/installation/package-installation).

## Requirements
Laravel Mail V1 requires:

- PHP 8.3+
- Laravel 11+
- MySQL (≥ 5.7) or PostgreSQL (≥ 9.4)


## Package Installation
As of Version 1, Laravel Mail can be installed as a stand-alone application 
(i.e. including everything you need to run SendPortal), or as a package inside an existing Laravel application.

This page covers the Package installation. 
If you want to install Laravel Mail as a stand-alone application, then head over to the [installation guide](https://docs.laravelmail.com/).

### Installing Laravel Mail as a Package

To install Laravel Mail as a package, you will need to add the following to your `composer.json` file:

```json
"require": {
    "laravelcompany/laravel-mail": "^1.0"
}
```

Then run `composer update` to install the package.

### Installing Laravel Mail as a Package Inside an Existing Application

To install Laravel Mail as a package inside an existing application, you will need to add the following to your `composer.json` file:

```json
"require": {
    "laravelcompany/laravel-mail": "^1.0"
}
```

Then run `composer update` to install the package.

Next, you will need to add the following to your `config/app.php` file:

```php
'providers' => [
    LaravelCompany\Mail\Providers\LaravelMailServiceProvider::class,
],
```


Run Artisan to publish the configuration file:

```bash
php artisan vendor:publish --provider="LaravelCompany\Mail\Providers\LaravelMailServiceProvider"
```


Finally, you will need to add the following to your `config/mail.php` file:

```php
'driver' => env('MAIL_DRIVER', 'smtp'),
'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
'port' => env('MAIL_PORT', 587),
'from' => [
    'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
    'name' => env('MAIL_FROM_NAME', 'Example'),
],
'encryption' => env('MAIL_ENCRYPTION', 'tls'),
'username' => env('MAIL_USERNAME'),
'password' => env('MAIL_PASSWORD'),
'sendmail' => '/usr/sbin/sendmail -bs',
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email security@laravelmail.com instead of using the issue tracker.

## Credits

- [Laravel](https://laravel.com)
- [SendPortal](https://sendportal.io)
- [42Coders](https://42coders.com/)

## License

The MIT License (MIT).

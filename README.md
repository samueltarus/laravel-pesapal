# Laravel PesaPal Integration

This package provides an easy way to integrate PesaPal payment gateway into your Laravel application.

## Installation

You can install the package via composer:

```bash
composer require samueltarus/laravel-pesapal
```

## Configuration

Publish the config file with:

```bash
php artisan vendor:publish --provider="samueltarus\LaravelPesaPal\PesaPalServiceProvider" --tag="config"
```

Then, add your PesaPal credentials to your `.env` file:

```
PESAPAL_CONSUMER_KEY=your_consumer_key_here
PESAPAL_CONSUMER_SECRET=your_consumer_secret_here
PESAPAL_ENDPOINT=https://endpoints.mikaappliances.com
```

## Usage

This package provides two main routes:

1. Process Payment: `POST /pesapal/process-payment`
2. Check Status: `GET /pesapal/check-status`

You can also use the `PesaPal` facade in your code:

```php
use samueltarus\LaravelPesaPal\Facades\PesaPal;

// Process a payment
$result = PesaPal::submitOrder([
    'amount' => 1000,
    'currency' => 'USD',
    'description' => 'Test payment',
    'callback_url' => 'https://your-callback-url.com',
]);

// Check status of a transaction
$status = PesaPal::getTransactionStatus('order_tracking_id');
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.# laravel-pesapal

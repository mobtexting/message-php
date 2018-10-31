# Mobtexting Messaging Api

This package makes it easy to send [Mobtexting Message](https://mobtexting.com).

## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)

## Installation

You can install the package via composer:

``` bash
composer require mobtexting/message-sdk
```


## Usage

```php
<?php
$token = "YYYYYY"; 

$client = new Mobtexting\Message\Client($token);
$message = $client->send(
  '1234567890', // Text this number
  array(
    'from' => 'MOBtxt',
    'text' => 'Hello from MOBtexting!',
    'service' => 'T'
  )
);

print_r($message->json());
```

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email support@mobtexting.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

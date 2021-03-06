# Slim Framework IP Filter

A slim middleware to filter ip addresses that will access to your routes. It internally uses `Ip` Validator of [Respect/Validation][respect-validation] and [rka-ip-address-middleware][rka-ip-address-middleware]. Is based on [slim-restrict-route][slim-restrict-route]

## Install

Via Composer

``` bash
$ composer require juanpagfe/slim-ip-filter
```

Requires Slim 3.0.0 or newer.

## Usage

You have to register also the [`RKA\Middleware\IpAddress`][rka-ip-address-middleware] middleware to correctly read the ip address.
In most cases you want to register `Jpgfe\Slim\IpFilter` for a single route, however,
as it is middleware, you can also register it for all routes.


### Register per route

```php
$app = new \Slim\App();

$app->add(new RKA\Middleware\IpAddress());

$options = array(
    array(
        'ip' => '192.*.*.*',
        'allow' => false
        )
);

$app->get('/api/myEndPoint',function ($req, $res, $args) {
  //Your amazing route code
})->add(new \Jpgfe\Slim\IpFilter\RestrictRoute($options));

$app->run();
```


### Register for all routes

```php
$app = new \Slim\App();

$app->add(new RKA\Middleware\IpAddress());

$options = array(
    array(
        'ip' => '192.*.*.*',
        'allow' => false
        )
);

// Register middleware for all routes
// If you are implementing per-route checks you must not add this
$app->add(new \Jpgfe\Slim\IpFilter\RestrictRoute($options));

$app->get('/foo', function ($req, $res, $args) {
  //Your amazing route code
});

$app->post('/bar', function ($req, $res, $args) {
  //Your amazing route code
});

$app->run();
```

## Ip address

You can restrict route using a different value of `ip` in the `options` given to `\RestrictRoute`:
* any of the filters provided by PHP regarding `FILTER_VALIDATE_IP` (e.g.: `FILTER_FLAG_NO_PRIV_RANGE`);
* asterisk (`*`) to filter ip that are in the given subnet (e.g.: `192.*`);
* ranges (`-`) to filter ip that are in the given range (e.g.: `192.168.0.0-192.168.255.255`);
* single ip (e.g.: `192.168.0.1-192.168.0.1`);
* array of ranges to filter ip (e.g.: `array('192.0.0.0-192.255.255.255', '178.0.0.*')`).

You can find more syntax information on the `Ip` validator [documentation](https://github.com/Respect/Validation/blob/master/docs/Ip.md) and in its [Unit Test class](https://github.com/Respect/Validation/blob/master/tests/unit/Rules/IpTest.php).

## Testing

``` bash
$ phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Juan Pablo Garcia](https://github.com/juanpagfe)


[slim-restrict-route]: https://github.com/DavidePastore/Slim-Restrict-Route
[respect-validation]: https://github.com/Respect/Validation/
[rka-ip-address-middleware]: https://github.com/akrabat/rka-ip-address-middleware
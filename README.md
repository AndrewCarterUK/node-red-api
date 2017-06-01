# Node-RED API

A limited set of classes for communicating with the Node-RED API.

## Authentication

```php
use NodeRED\Instance;
use NodeRED\OAuth;

$instance = new Instance('http://localhost:1883');

$oAuth = new OAuth($instance);
$token = $oAuth->getToken('username', 'password');
```

## Tokens

```php
// Tokens are serializable
$serializedToken = serialize($token);
$token = unserialize($serializedToken);

// Check if a token has expired
if ($token->hasExpired()) {
    // ...
}
```

## Instance Methods

```php
// ::get($path, ? $token)
$authScheme = $instance->get('auth/login');
$flows = $instance->get('flows', $token);

// ::postJson($path, $data, ? $token)
$instance->postJson('nodes', ['module' => 'node-red-node-suncalc'], $token);
```

## Importing Flows

```php
use NodeRed\Importer;

$importer = new Importer($instance, $token);

$flowJson = '[{"id":"38fb694f.83ac86","type":"inject","z":"7578d4d1.ba2e2c","name":"","topic":"","payload":"","payloadType":"date","repeat":"","crontab":"","once":false,"x":602.5,"y":298,"wires":[["f8ac9ac8.c76808"]]},{"id":"f8ac9ac8.c76808","type":"debug","z":"7578d4d1.ba2e2c","name":"","active":true,"console":"false","complete":"false","x":794.5,"y":298,"wires":[]}]';

$flowId = $importer->importFlow('My New Flow', $flowJson);
```

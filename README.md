# TransferWise Provider for OAuth 2.0 Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/imliam/oauth2-transferwise.svg)](https://packagist.org/packages/imliam/oauth2-transferwise)
[![Build Status](https://img.shields.io/travis/imliam/oauth2-transferwise.svg)](https://travis-ci.org/imliam/oauth2-transferwise)
![Code Quality](https://img.shields.io/scrutinizer/g/imliam/oauth2-transferwise.svg)
![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/imliam/oauth2-transferwise.svg)
[![Total Downloads](https://img.shields.io/packagist/dt/imliam/oauth2-transferwise.svg)](https://packagist.org/packages/imliam/oauth2-transferwise)
[![License](https://img.shields.io/github/license/imliam/oauth2-transferwise.svg)](LICENSE.md)

This package provides TransferWise OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require imliam/oauth2-transferwise
```

## Usage

Usage is the same as The League's OAuth client, using `\ImLiam\OAuth2\Client\Provider\Transferwise` as the provider.

### Authorization Code Flow

```php
$provider = new ImLiam\OAuth2\Client\Provider\Transferwise([
    'clientId'          => '{transferwise-client-id}',
    'clientSecret'      => '{transferwise-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code']
    ]);

    // Optional: Now you have a token you can look up a users profile data
    try {

        // We got an access token, let's now get the user's details
        $user = $provider->getResourceOwner($token);

        // Use these details to create a new profile
        printf('Hello %s!', $user->getNickname());

    } catch (Exception $e) {

        // Failed to get user details
        exit('Oh dear...');
    }

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/imliam/oauth2-transferwise/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Steven Maguire](https://github.com/stevenmaguire)
- [All Contributors](https://github.com/imliam/oauth2-transferwise/contributors)
- [Based off of league/oauth2-github](https://github.com/league/oauth2-github)

## License

The MIT License (MIT). Please see [License File](https://github.com/imliam/oauth2-transferwise/blob/master/LICENSE) for more information.

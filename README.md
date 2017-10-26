## Laravel Follow

[![Build Status][icon-travis]][link-travis]
[![Software License][icon-license]][link-license]
[![Latest Version on Packagist][icon-version]][link-packagist]
[![Total Downloads][icon-downloads]][link-packagist]

Laravel 5.5 Follow System for Eloquent models.

This package requires PHP 7.0 or higher and follows the FIG standards [PSR-1][link-psr-1], [PSR-2][link-psr-2] and [PSR-4][link-psr-4] to ensure a high level of interoperability between shared PHP.

## Laravel Version Compatibility

Laravel Follow                      | Laravel
----------------------------------- | ------------------------------------------
![1.0.x][icon-laravel-follow_1_0_x] | ![Laravel 5.5][icon-laravel_5_5]


## Installation

You can install the package via composer:

```
composer require hypefactors/laravel-follow
```

Next, open your `config/app.php` file and add the service provider to the `providers` array:

```
Hypefactors\Laravel\Follow\FollowServiceProvider::class,
```

Now you need to run the migrations:

```
php artisan migrate
```

## Usage

### Preparing the Eloquent Models

To allow an entity to be followed or to follow other entities, the corresponding models have to implement an interface and make usage of a trait.

Here's how we do it for a `User` and `Company` entity, where a user will be able to follow a company and the company will be able to be followed:

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\CanFollow;
use Hypefactors\Laravel\Follow\Contracts\CanFollowContract;

class User extends Model implements CanFollowContract
{
    use CanFollow;
}
```

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\CanBeFollowed;
use Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract;

class Company extends Model implements CanBeFollowedContract
{
    use CanBeFollowed;
}
```

> **Note:** If required, an entity can follow and can also be followed, just implement both interfaces and traits on the same model to achieve that requirement.

### Following an Entity

You can follow an entity like this:

```php
$company = Company::find(1);

$user = User::find(1);
$user->follow($company);
```

You can also perform the same through the entity that's going to be followed:

```php
$user = User::find(1);

$company = Company::find(1);
$company->addFollower($user);
```

### Unfollowing an Entity

You can unfollow an entity like this:

```php
$company = Company::find(1);

$user = User::find(1);
$user->unfollow($company);
```

You can also perform the same through the entity that's going to be followed:

```php
$user = User::find(1);

$company = Company::find(1);
$company->removeFollower($user);
```

### Determining if an Entity is Following another Entity

You can unfollow an entity like this:

```php
$company = Company::find(1);

$user = User::find(1);
$user->isFollowing($company);
```

You can also perform the same through the entity that's going to be followed:

```php
$user = User::find(1);

$company = Company::find(1);
$company->hasFollower($user);
```

### Determine if an Entity has Followings

```php
$user = User::find(1);

if ($user->hasFollowings()) {
    echo "User is following {$user->followings->count()} entities.";
}
```

### Determine if an Entity has Followers

```php
$company = Company::find(1);

if ($company->hasFollowers()) {
    echo "Company has {$company->followers->count()} followers.";
}
```

### Get list of Followings

To get a list of followings (entities another entity is following)

```php
$user = User::find(1);

$followings = $user->followings
```

### Get List of Followers

To get a list of followers (entities that are following an entity)

```php
$company = Company::find(1);

$followers = $company->followers
```

## Change Log

Please refer to the [Change Log](CHANGELOG.md) for a full history of the project.

## Contributing & Protocols

- [Etiquette](CONTRIBUTING.md#etiquette)
- [Versioning](CONTRIBUTING.md#versioning)
- [Coding Standards](CONTRIBUTING.md#coding-standards)
- [Issues \ Bugs](CONTRIBUTING.md#issues--bugs)
- [Pull Requests](CONTRIBUTING.md#pull-requests)
- [Proposals](CONTRIBUTING.md#proposals)
- [Testing](CONTRIBUTING.md#running-tests)

## Security

If you discover any security related issues, please email support@hypefactors.com instead of using the issue tracker.

## License

`hypefactors/laravel-follow` is licenced under the BSD 3-Clause License. Please see the [license file](LICENSE) for more information.

[link-psr-1]:     http://www.php-fig.org/psr/psr-1/
[link-psr-2]:     http://www.php-fig.org/psr/psr-2/
[link-psr-4]:     http://www.php-fig.org/psr/psr-4/
[link-travis]:    https://travis-ci.org/hypefactors/laravel-follow
[link-license]:   https://opensource.org/licenses/BSD-3-Clause
[link-packagist]: https://packagist.org/packages/hypefactors/laravel-follow

[icon-travis]:    https://img.shields.io/travis/hypefactors/laravel-follow.svg?style=flat-square&label=Travis%20CI
[icon-license]:   https://img.shields.io/packagist/l/hypefactors/laravel-follow.svg?style=flat-square&label=License
[icon-version]:   https://img.shields.io/packagist/v/hypefactors/laravel-follow.svg?style=flat-square&label=Version
[icon-downloads]: https://img.shields.io/packagist/dt/hypefactors/laravel-follow.svg?style=flat-square&label=Downloads
[icon-laravel_5_5]: https://img.shields.io/badge/5.5-supported-brightgreen.svg?style=flat-square "Laravel 5.5"
[icon-laravel-follow_1_0_x]: https://img.shields.io/badge/version-1.0.*-blue.svg?style=flat-square&label=Version "Follow 1.0.*"

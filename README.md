## Laravel Follow

[![Build Status][icon-travis]][link-travis]
[![Software License][icon-license]][link-license]
[![Latest Version on Packagist][icon-version]][link-packagist]
[![Total Downloads][icon-downloads]][link-packagist]

Laravel 5.9 Follow System for Eloquent models.

This package requires PHP 7.2 or higher and follows the FIG standards [PSR-1][link-psr-1], [PSR-2][link-psr-2] and [PSR-4][link-psr-4] to ensure a high level of interoperability between shared PHP.

## Laravel Version Compatibility

Laravel Follow                  | Laravel
------------------------------- | ------------------------------------------
![1.x][icon-laravel-follow_1_x] | ![Laravel 5.5][icon-laravel_5_5]
![2.x][icon-laravel-follow_2_x] | ![Laravel 5.6][icon-laravel_5_6]
![3.x][icon-laravel-follow_3_x] | ![Laravel 5.7][icon-laravel_5_7]
![4.x][icon-laravel-follow_4_x] | ![Laravel 5.8][icon-laravel_5_8]
![5.x][icon-laravel-follow_5_x] | ![Laravel 5.9][icon-laravel_5_9]

## Installation

You can install the package via composer:

```
composer require hypefactors/laravel-follow
```

The package will be automatically registered.

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

### Follow Many Entities

You can follow many entities like this:

```php
$companies = Company::whereIn('id', [1, 3, 10])->get();

$user = User::find(1);
$user->followMany($companies);
```

You can also perform the same through the entity that's going to be followed:

```php
$users = User::whereIn('id', [1, 3, 10])->get();

$company = Company::find(1);
$company->addManyFollowers($users);
```

### Unfollowing an Entity

You can unfollow an entity like this:

```php
$company = Company::find(1);

$user = User::find(1);
$user->unfollow($company);
```

You can also perform the same through the entity that's going to be unfollowed:

```php
$user = User::find(1);

$company = Company::find(1);
$company->removeFollower($user);
```

### Unfollow Many Entities

You can unfollow many entities like this:

```php
$companies = Company::whereIn('id', [1, 3, 10])->get();

$user = User::find(1);
$user->unfollowMany($companies);
```

You can also perform the same through the entity that's going to be unfollowed:

```php
$users = User::whereIn('id', [1, 3, 10])->get();

$company = Company::find(1);
$company->removeManyFollowers($users);
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

### Get List of Followings by Entity Type

Get a list of followings (entities another entity is following) and filter by an entity type

```php
$user = User::find(1);

$followings = $user->followings()->whereFollowableType(Company::class)->get();
```

### Get List of Followers by Entity Type

Get a list of followers (entities that are following an entity) and filter by an entity type

```php
$company = Company::find(1);

$followers = $company->followers()->whereFollowerType(User::class)->get();
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
[icon-laravel_5_6]: https://img.shields.io/badge/5.6-supported-brightgreen.svg?style=flat-square "Laravel 5.6"
[icon-laravel_5_7]: https://img.shields.io/badge/5.7-supported-brightgreen.svg?style=flat-square "Laravel 5.7"
[icon-laravel_5_8]: https://img.shields.io/badge/5.8-supported-brightgreen.svg?style=flat-square "Laravel 5.8"
[icon-laravel_5_9]: https://img.shields.io/badge/5.9-supported-brightgreen.svg?style=flat-square "Laravel 5.9"
[icon-laravel-follow_1_x]: https://img.shields.io/badge/version-1.x-blue.svg?style=flat-square&label=Version "Follow 1.x"
[icon-laravel-follow_2_x]: https://img.shields.io/badge/version-2.x-blue.svg?style=flat-square&label=Version "Follow 2.x"
[icon-laravel-follow_3_x]: https://img.shields.io/badge/version-3.x-blue.svg?style=flat-square&label=Version "Follow 3.x"
[icon-laravel-follow_4_x]: https://img.shields.io/badge/version-4.x-blue.svg?style=flat-square&label=Version "Follow 4.x"
[icon-laravel-follow_5_x]: https://img.shields.io/badge/version-5.x-blue.svg?style=flat-square&label=Version "Follow 5.x"

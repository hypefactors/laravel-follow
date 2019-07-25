## Laravel Follow

[![Build Status][icon-travis]][link-travis]
[![Software License][icon-license]][link-license]
[![Latest Version on Packagist][icon-version]][link-packagist]
[![Total Downloads][icon-downloads]][link-packagist]

Laravel 6 Follow System for Eloquent models.

This package is compliant with the FIG standards [PSR-1][link-psr-1], [PSR-2][link-psr-2] and [PSR-4][link-psr-4] to ensure a high level of interoperability between shared PHP. If you notice any compliance oversights, please send a patch via pull request.

## Version Matrix

Version | Laravel | PHP Version
------- | ------- | ------------
5.x     | 6.0+    | >= 7.2
4.x     | 5.8.x   | >= 7.1
3.x     | 5.7.x   | >= 7.1
2.x     | 5.6.x   | >= 7.1
1.x     | 5.5.x   | >= 7.0

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
use Hypefactors\Laravel\Follow\Traits\CanFollow;
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
use Hypefactors\Laravel\Follow\Traits\CanBeFollowed;
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

## Contributing

Thank you for your interest in Laravel Follow. Here are some of the many ways to contribute.

- Check out our [contributing guide](/.github/CONTRIBUTING.md)
- Look at our [code of conduct](/.github/CODE_OF_CONDUCT.md)

## Security

If you discover any security related issues, please email support@hypefactors.com instead of using the issue tracker.

## License

Laravel Follow is licenced under the BSD 3-Clause License. Please see the [license file](LICENSE) for more information.

[link-psr-1]:     http://www.php-fig.org/psr/psr-1/
[link-psr-2]:     http://www.php-fig.org/psr/psr-2/
[link-psr-4]:     http://www.php-fig.org/psr/psr-4/
[link-travis]:    https://travis-ci.org/hypefactors/laravel-follow
[link-license]:   https://opensource.org/licenses/BSD-3-Clause
[link-packagist]: https://packagist.org/packages/hypefactors/laravel-follow

[icon-travis]:    https://travis-ci.org/hypefactors/laravel-follow.svg?branch=5.0
[icon-license]:   https://poser.pugx.org/hypefactors/laravel-follow/license
[icon-version]:   https://poser.pugx.org/hypefactors/laravel-follow/version
[icon-downloads]: https://poser.pugx.org/hypefactors/laravel-follow/downloads

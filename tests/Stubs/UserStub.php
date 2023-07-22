<?php

namespace Hypefactors\Laravel\Follow\Tests\Stubs;

use Hypefactors\Laravel\Follow\Contracts\CanFollowContract;
use Hypefactors\Laravel\Follow\Tests\Factories\UserStubFactory;
use Hypefactors\Laravel\Follow\Traits\CanFollow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserStub extends Model implements CanFollowContract
{
    use HasFactory, CanFollow;

    protected $table = 'users';

    protected static function newFactory()
    {
        return UserStubFactory::new();
    }
}

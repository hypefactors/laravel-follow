<?php

namespace Hypefactors\Laravel\Follow\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\Traits\CanFollow;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Hypefactors\Laravel\Follow\Contracts\CanFollowContract;
use Hypefactors\Laravel\Follow\Tests\Factories\UserStubFactory;

class UserStub extends Model implements CanFollowContract
{
    use HasFactory, CanFollow;

    protected $table = 'users';

    protected static function newFactory()
    {
        return UserStubFactory::new();
    }
}

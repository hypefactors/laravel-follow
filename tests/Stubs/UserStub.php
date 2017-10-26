<?php

namespace Hypefactors\Laravel\Follow\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\Traits\CanFollow;
use Hypefactors\Laravel\Follow\Contracts\CanFollowContract;

class UserStub extends Model implements CanFollowContract
{
    use CanFollow;

    protected $table = 'users';
}

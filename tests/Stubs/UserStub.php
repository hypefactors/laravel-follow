<?php

namespace Hypefactors\Laravel\Follow\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\Traits\CanFollow;

class UserStub extends Model
{
    use CanFollow;

    protected $table = 'users';
}

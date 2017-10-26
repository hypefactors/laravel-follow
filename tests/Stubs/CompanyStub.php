<?php

namespace Hypefactors\Laravel\Follow\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\Traits\CanBeFollowed;
use Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract;

class CompanyStub extends Model implements CanBeFollowedContract
{
    use CanBeFollowed;

    protected $table = 'companies';
}

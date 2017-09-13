<?php

namespace Hypefactors\Laravel\Follow\Tests\Stubs;

use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\Traits\CanBeFollowed;

class CompanyStub extends Model
{
    use CanBeFollowed;

    protected $table = 'companies';
}

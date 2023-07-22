<?php

namespace Hypefactors\Laravel\Follow\Tests\Stubs;

use Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract;
use Hypefactors\Laravel\Follow\Tests\Factories\CompanyStubFactory;
use Hypefactors\Laravel\Follow\Traits\CanBeFollowed;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyStub extends Model implements CanBeFollowedContract
{
    use HasFactory, CanBeFollowed;

    protected $table = 'companies';

    protected static function newFactory()
    {
        return CompanyStubFactory::new();
    }
}

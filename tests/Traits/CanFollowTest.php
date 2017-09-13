<?php

namespace Hypefactors\Laravel\Follow\Tests;

use Carbon\Carbon;
use Hypefactors\Laravel\Follow\Tests\Stubs\UserStub;
use Hypefactors\Laravel\Follow\Tests\Stubs\CompanyStub;

class CanFollowTest extends FunctionalTestCase
{
    /** @test */
    public function an_entity_can_follow_another_entity()
    {
        $user = factory(UserStub::class)->create();
        $company = factory(CompanyStub::class)->create();

        $user->follow($company);

        $this->assertTrue($user->isFollowing($company));
    }

    /** @test */
    public function an_entity_can_unfollow_another_entity()
    {
        $user = factory(UserStub::class)->create();
        $company = factory(CompanyStub::class)->create();

        $user->follow($company);

        $this->assertTrue($user->isFollowing($company));

        $user->unfollow($company);

        $this->assertFalse($user->isFollowing($company));
    }

    /** @test */
    public function an_entity_can_refollow_an_entity()
    {
        $user = factory(UserStub::class)->create();
        $company = factory(CompanyStub::class)->create();

        $user->follow($company);

        $this->assertTrue($user->isFollowing($company));

        $user->unfollow($company);

        $this->assertFalse($user->isFollowing($company));

        $user->follow($company);

        $this->assertTrue($user->isFollowing($company));
    }

    /** @test */
    public function deleting_a_follower_entity_deletes_the_following_records()
    {
        $user = factory(UserStub::class)->create();
        $company = factory(CompanyStub::class)->create();

        $user->follow($company);

        $user->delete();

        $this->assertFalse($company->hasFollowers());
    }
}

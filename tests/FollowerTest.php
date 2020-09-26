<?php

namespace Hypefactors\Laravel\Follow\Tests;

use Hypefactors\Laravel\Follow\Follower;
use Hypefactors\Laravel\Follow\Tests\Stubs\UserStub;
use Hypefactors\Laravel\Follow\Tests\Stubs\CompanyStub;

class FollowerTest extends FunctionalTestCase
{
    /** @test */
    public function the_following_entity_can_be_retrieved()
    {
        $user    = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

        $user->follow($company);

        $following = $user->findFollowing($company);

        $this->assertInstanceOf(CompanyStub::class, $following->followable);
    }

    /** @test */
    public function the_follower_entity_can_be_retrieved()
    {
        $user    = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

        $user->follow($company);

        $following = $user->findFollowing($company);

        $this->assertInstanceOf(UserStub::class, $following->follower);
    }

    /** @test */
    public function all_followers_can_be_retrieved_by_a_given_type()
    {
        $user    = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

        $user->follow($company);

        $followers = Follower::whereFollowerType(UserStub::class)->get();

        $this->assertCount(1, $followers);
    }

    /** @test */
    public function all_followables_can_be_retrieved_by_a_given_type()
    {
        $user    = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

        $user->follow($company);

        $followables = Follower::whereFollowableType(CompanyStub::class)->get();

        $this->assertCount(1, $followables);
    }
}

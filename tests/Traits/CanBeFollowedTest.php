<?php

namespace Hypefactors\Laravel\Follow\Tests;

use Carbon\Carbon;
use Hypefactors\Laravel\Follow\Tests\Stubs\UserStub;
use Hypefactors\Laravel\Follow\Tests\Stubs\CompanyStub;

class CanBeFollowedTest extends FunctionalTestCase
{
    /** @test */
    public function an_entity_can_add_a_follower_directly()
    {
        $user = factory(UserStub::class)->create();
        $company = factory(CompanyStub::class)->create();

        $company->addFollower($user);

        $this->assertTrue($company->hasFollower($user));
        $this->assertTrue($company->hasFollowers());
    }

    /** @test */
    public function an_entity_can_remove_a_follower_directly()
    {
        $user = factory(UserStub::class)->create();
        $company = factory(CompanyStub::class)->create();

        $company->addFollower($user);

        $this->assertTrue($company->hasFollower($user));
        $this->assertTrue($company->hasFollowers());

        $company->removeFollower($user);

        $this->assertFalse($company->hasFollower($user));
        #$this->assertFalse($company->hasFollowers());
    }

    /** @test */
    public function an_entity_can_readd_a_follower_directly()
    {
        $user = factory(UserStub::class)->create();
        $company = factory(CompanyStub::class)->create();

        $company->addFollower($user);

        $this->assertTrue($company->hasFollower($user));
        $this->assertTrue($company->hasFollowers());

        $company->removeFollower($user);

        $this->assertFalse($company->hasFollower($user));
        $this->assertFalse($company->hasFollowers());

        $company->addFollower($user);

        $this->assertTrue($company->hasFollower($user));
        $this->assertTrue($company->hasFollowers());
    }

    /** @test */
    public function it_can_determine_the_amount_of_gained_followers_for_a_given_date_range()
    {
        $user = factory(UserStub::class)->create();
        $company = factory(CompanyStub::class)->create();

        $startDate = Carbon::now()->subDays(3);
        $endDate = Carbon::now();

        $followersCount = $company->gainedFollowers($startDate, $endDate)->count();

        $this->assertSame(0, $followersCount);

        $startDate = Carbon::now()->subDays(3);
        $endDate = Carbon::now();

        $user->follow($company);

        $gainedFollowersCount = $company->gainedFollowers($startDate, $endDate)->count();

        $this->assertSame(1, $gainedFollowersCount);
    }

    /** @test */
    public function it_can_determine_the_amount_of_lost_followers_for_a_given_date_range()
    {
        $user = factory(UserStub::class)->create();
        $company = factory(CompanyStub::class)->create();

        $startDate = Carbon::now()->subDays(3);
        $endDate = Carbon::now();

        $user->follow($company);
        $user->unfollow($company);

        $lostFollowersCount = $company->lostFollowers($startDate, $endDate)->count();

        $this->assertSame(1, $lostFollowersCount);
    }
}

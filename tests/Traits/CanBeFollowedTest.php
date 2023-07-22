<?php

namespace Hypefactors\Laravel\Follow\Tests\Traits;

use Carbon\Carbon;
use Hypefactors\Laravel\Follow\Tests\FunctionalTestCase;
use Hypefactors\Laravel\Follow\Tests\Stubs\CompanyStub;
use Hypefactors\Laravel\Follow\Tests\Stubs\UserStub;

class CanBeFollowedTest extends FunctionalTestCase
{
    /**
     * @test
     */
    public function an_entity_can_add_a_follower_directly()
    {
        $user = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

        $company->addFollower($user);

        $this->assertCount(1, $company->followers);
        $this->assertTrue($company->hasFollowers());
        $this->assertTrue($company->hasFollower($user));
    }

    /**
     * @test
     */
    public function an_entity_can_add_many_followers_directly()
    {
        $company = CompanyStub::factory()->create();

        $users = UserStub::factory()->count(3)->create();

        $company->addManyFollowers($users);

        $this->assertCount(3, $company->followers);
        $this->assertTrue($company->hasFollowers());
    }

    /**
     * @test
     */
    public function an_entity_can_remove_a_follower_directly()
    {
        $user = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

        $company->addFollower($user);

        $this->assertTrue($company->hasFollowers());
        $this->assertTrue($company->hasFollower($user));

        $company->removeFollower($user);

        $this->assertFalse($company->hasFollowers());
        $this->assertFalse($company->hasFollower($user));
    }

    /**
     * @test
     */
    public function an_entity_can_remove_many_followers_directly()
    {
        $company = CompanyStub::factory()->create();

        $users = UserStub::factory()->count(3)->create();

        $company->addManyFollowers($users);

        $this->assertCount(3, $company->followers);
        $this->assertTrue($company->hasFollowers());

        $company->removeManyFollowers($users);

        $this->assertCount(0, $company->fresh()->followers);
        $this->assertFalse($company->hasFollowers());
    }

    /**
     * @test
     */
    public function an_entity_can_readd_a_follower_directly()
    {
        $user = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

        $company->addFollower($user);

        $this->assertTrue($company->hasFollowers());
        $this->assertTrue($company->hasFollower($user));

        $company->removeFollower($user);

        $this->assertFalse($company->hasFollower($user));
        $this->assertFalse($company->hasFollowers());

        $company->addFollower($user);

        $this->assertTrue($company->hasFollowers());
        $this->assertTrue($company->hasFollower($user));
    }

    /**
     * @test
     */
    public function it_can_determine_the_amount_of_gained_followers_for_a_given_date_range()
    {
        $user = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

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

    /**
     * @test
     */
    public function it_can_determine_the_amount_of_lost_followers_for_a_given_date_range()
    {
        $user = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

        $user->follow($company);
        $user->unfollow($company);

        $startDate = Carbon::now()->subDays(3);
        $endDate = Carbon::now();

        $lostFollowersCount = $company->lostFollowers($startDate, $endDate)->count();

        $this->assertSame(1, $lostFollowersCount);
    }

    /**
     * @test
     */
    public function deleting_a_following_entity_deletes_the_following_records()
    {
        $user = UserStub::factory()->create();
        $company = CompanyStub::factory()->create();

        $user->follow($company);

        $company->delete();

        $this->assertFalse($user->hasFollowings());
    }

    /**
     * @test
     */
    public function an_entity_can_have_many_entities_synchronized_as_followers()
    {
        $company = CompanyStub::factory()->create();

        $users = UserStub::factory()->count(3)->create();

        $company->addManyFollowers($users);

        $this->assertCount(3, $company->followers);
        $this->assertTrue($company->hasFollowers());

        $users = UserStub::factory()->count(4)->create();

        $company = $company->syncManyFollowers($users);

        $this->assertCount(4, $company->followers);
        $this->assertTrue($company->hasFollowers());
        $this->assertSame(
            $users->pluck('id')->toArray(),
            $company->followers->pluck('id')->toArray()
        );
    }
}

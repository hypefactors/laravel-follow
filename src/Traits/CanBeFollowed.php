<?php

namespace Hypefactors\Laravel\Follow\Traits;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\Follower;
use Illuminate\Database\Eloquent\Builder;

trait CanBeFollowed
{
    /**
     * Boots the trait.
     *
     * @return void
     */
    public static function bootCanBeFollowed()
    {
        static::deleted(function (Model $entity) {
            $entity->followables()->delete();
        });
    }

    /**
     * Returns the followers that this entity is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function followables()
    {
        return $this->morphMany(Follower::class, 'followable');
    }

    /**
     * Determines if the entity has followers associated.
     *
     * @return bool
     */
    public function hasFollowers()
    {
        return (bool) $this->followables()->withoutTrashed()->count();
    }

    /**
     * Determines if the given entity is a follower of this entity.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     *
     * @return bool
     */
    public function hasFollower(Model $entity)
    {
        $follower = $this->findFollower($entity);

        return (bool) $follower && ! $follower->trashed();
    }

    /**
     * Adds the given entity as a follower of this entity.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addFollower(Model $entity)
    {
        $followed = $this->followables()->withTrashed()->whereFollowerEntity($entity)->first();

        // If the entity was previously a follower of this entity but
        // later decided to unfollow it, we still have that entry,
        // it just needs to be restored.
        if ($followed && $followed->trashed()) {
            $followed->restore();

        // The entity was never a follower of this entity
        } elseif (! $followed) {
            $follower = new Follower;
            $follower->follower_id = $entity->getKey();
            $follower->follower_type = $entity->getMorphClass();

            $this->followables()->save($follower);
        }

        return $this->fresh();
    }

    /**
     * Removes the given entity from being a follower of this entity.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function removeFollower(Model $entity)
    {
        $followed = $this->findFollower($entity);

        if ($followed && ! $followed->trashed()) {
            $followed->delete();
        }

        return $this->fresh();
    }

    # Needs to be redone!
    public function syncFollowers(array $entities)
    {
        $followers = array_pull($attributes, 'followers', []);

        $currentFollowers = $this->followers->pluck('follower_id')->all();

        $followersToAdd = array_diff($followers, $currentFollowers);
        $followersToDel = array_diff($currentFollowers, $followers);

        // Add followers
        foreach ($this->userModel->whereIn('id', $followersToAdd)->get() as $user) {
            $this->addFollower($user);
        }

        // Remove followers
        foreach ($this->userModel->whereIn('id', $followersToDel)->get() as $user) {
            $this->removeFollower($user);
        }

        $this->load('followers');

        return $this;
    }

    /**
     * Finds the gained followers (created) over the given time period.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \DateTime                             $startDate
     * @param \DateTime                             $endDate
     *
     * @return int
     */
    public function scopeGainedFollowers(Builder $query, DateTime $startDate, DateTime $endDate)
    {
        return $this
            ->followables()
            ->withoutTrashed()
            ->whereBetween('created_at', [$startDate, $endDate])
        ;
    }

    /**
     * Finds the lost followers (deleted) over the given time period.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \DateTime                             $startDate
     * @param \DateTime                             $endDate
     *
     * @return int
     */
    public function scopeLostFollowers(Builder $query, DateTime $startDate, DateTime $endDate)
    {
        return $this
            ->followables()
            ->onlyTrashed()
            ->whereBetween('deleted_at', [$startDate, $endDate])
        ;
    }

    /**
     * Returns the given entity record if this entity is being followed by it.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findFollower(Model $entity)
    {
        return $this->followables()->withTrashed()->whereFollowerEntity($entity)->first();
    }
}

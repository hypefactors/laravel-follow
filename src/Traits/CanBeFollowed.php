<?php

namespace Hypefactors\Laravel\Follow\Traits;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\Follower;
use Illuminate\Database\Eloquent\Builder;
use Hypefactors\Laravel\Follow\Contracts\CanFollowContract;

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
            $entity->followers()->delete();
        });
    }

    /**
     * Returns the followers that this entity is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function followers()
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
        return (bool) $this->followers()->withoutTrashed()->count();
    }

    /**
     * Determines if the given entity is a follower of this entity.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanFollowContract $entity
     *
     * @return bool
     */
    public function hasFollower(CanFollowContract $entity)
    {
        $follower = $this->findFollower($entity);

        return (bool) $follower && ! $follower->trashed();
    }

    /**
     * Adds the given entity as a follower of this entity.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanFollowContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addFollower(CanFollowContract $entity)
    {
        $followed = $this->followers()->withTrashed()->whereFollowerEntity($entity)->first();

        // If the entity was previously a follower of this entity
        // but later decided to unfollow it, we still have that
        // entry, it just needs to be restored.
        if ($followed && $followed->trashed()) {
            $followed->restore();
        } elseif (! $followed) {
            $follower                = new Follower();
            $follower->follower_id   = $entity->getKey();
            $follower->follower_type = $entity->getMorphClass();

            $this->followers()->save($follower);
        }

        return $this->fresh();
    }

    /**
     * Removes the given entity from being a follower of this entity.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanFollowContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function removeFollower(CanFollowContract $entity)
    {
        $followed = $this->findFollower($entity);

        if ($followed && ! $followed->trashed()) {
            $followed->delete();
        }

        return $this->fresh();
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
            ->followers()
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
            ->followers()
            ->onlyTrashed()
            ->whereBetween('deleted_at', [$startDate, $endDate])
        ;
    }

    /**
     * Returns the given entity record if this entity is being followed by it.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanFollowContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findFollower(CanFollowContract $entity)
    {
        return $this->followers()->withTrashed()->whereFollowerEntity($entity)->first();
    }
}

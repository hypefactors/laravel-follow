<?php

namespace Hypefactors\Laravel\Follow\Contracts;

use DateTime;
use Illuminate\Database\Eloquent\Builder;

interface CanBeFollowedContract
{
    /**
     * Returns the followers that this entity is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function followers();

    /**
     * Determines if the entity has followers associated.
     *
     * @return bool
     */
    public function hasFollowers();

    /**
     * Determines if the given entity is a follower of this entity.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanFollowContract $entity
     *
     * @return bool
     */
    public function hasFollower(CanFollowContract $entity);

    /**
     * Adds the given entity as a follower of this entity.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanFollowContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addFollower(CanFollowContract $entity);

    /**
     * Removes the given entity from being a follower of this entity.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanFollowContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function removeFollower(CanFollowContract $entity);

    /**
     * Finds the gained followers (created) over the given time period.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \DateTime                             $startDate
     * @param \DateTime                             $endDate
     *
     * @return int
     */
    public function scopeGainedFollowers(Builder $query, DateTime $startDate, DateTime $endDate);

    /**
     * Finds the lost followers (deleted) over the given time period.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \DateTime                             $startDate
     * @param \DateTime                             $endDate
     *
     * @return int
     */
    public function scopeLostFollowers(Builder $query, DateTime $startDate, DateTime $endDate);

    /**
     * Returns the given entity record if this entity is being followed by it.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanFollowContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findFollower(CanFollowContract $entity);
}

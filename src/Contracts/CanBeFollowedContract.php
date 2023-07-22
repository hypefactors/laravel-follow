<?php

namespace Hypefactors\Laravel\Follow\Contracts;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
     * @return bool
     */
    public function hasFollower(CanFollowContract $entity);

    /**
     * Adds the given entity as a follower of this entity.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addFollower(CanFollowContract $entity);

    /**
     * Adds many entities as followers of this entity.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function addManyFollowers(Collection $entities);

    /**
     * Removes the given entity from being a follower of this entity.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function removeFollower(CanFollowContract $entity);

    /**
     * Removes many entities from being followers of this entity.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function removeManyFollowers(Collection $entities);

    /**
     * Finds the gained followers (created) over the given time period.
     *
     * @return int
     */
    public function scopeGainedFollowers(Builder $query, DateTime $startDate, DateTime $endDate);

    /**
     * Finds the lost followers (deleted) over the given time period.
     *
     * @return int
     */
    public function scopeLostFollowers(Builder $query, DateTime $startDate, DateTime $endDate);

    /**
     * Returns the given entity record if this entity is being followed by it.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findFollower(CanFollowContract $entity);

    /**
     * Synchronize many entities that follows this entity.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function syncManyFollowers(Collection $entities);
}

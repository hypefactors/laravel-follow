<?php

namespace Hypefactors\Laravel\Follow\Contracts;

interface CanFollowContract
{
    /**
     * Returns the entities that this entity is following.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followings();

    /**
     * Determines if the entity has followings associated.
     *
     * @return bool
     */
    public function hasFollowings();

    /**
     * Determines if the entity is following the given entity.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract $entity
     *
     * @return bool
     */
    public function isFollowing(CanBeFollowedContract $entity);

    /**
     * Follows the given entity.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function follow(CanBeFollowedContract $entity);

    /**
     * Unfollows the given entity.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function unfollow(CanBeFollowedContract $entity);

    /**
     * Returns the given following entity record if this entity is following it.
     *
     * @param \Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract $entity
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findFollowing(CanBeFollowedContract $entity);
}

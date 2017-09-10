<?php

namespace Hypefactors\Laravel\Follow\Traits;

use Illuminate\Database\Eloquent\Model;
use Hypefactors\Laravel\Follow\Follower;

trait CanFollow
{
    /**
     * Returns the entities that this entity is following.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function followings()
    {
        return $this->morphMany(Follower::class, 'follower');
    }

    /**
     * Determines if the entity is following the given entity.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     *
     * @return bool
     */
    public function isFollowing(Model $entity)
    {
        return (bool) $this->following()->whereFollowableEntity($entity)->first();
    }

    /**
     * Follows the given entity.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function follow(Model $entity)
    {
        $following = $this->findFollowing($entity);

        // If the entity previously followed the entity but then unfollowed it,
        // we still have the relationship, it just needs to be restored.
        if ($following && $following->trashed()) {
            $following->restore();

        // The entity never followed this entity
        } elseif (! $following) {
            $follower = new Follower();
            $follower->followable_id = $entity->getKey();
            $follower->followable_type = $entity->getMorphClass();

            $this->following()->save($follower);
        }

        return $this->fresh();
    }

    /**
     * Unfollows the given entity.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function unfollow(Model $entity)
    {
        if ($this->isFollowing($entity)) {
            $this->following()->whereFollowableEntity($entity)->delete();
        }

        return $this->fresh();
    }

    /**
     * Returns the given entity record if this entity is following it.
     *
     * @param \Illuminate\Database\Eloquent\Model $entity
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected function findFollowing(Model $entity)
    {
       return $this->following()->withTrashed()->whereFollowableEntity($entity)->first();
    }
}

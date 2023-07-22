<?php

namespace Hypefactors\Laravel\Follow\Traits;

use Hypefactors\Laravel\Follow\Contracts\CanBeFollowedContract;
use Hypefactors\Laravel\Follow\Follower;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait CanFollow
{
    /**
     * Boots the trait.
     *
     * @return void
     */
    public static function bootCanFollow()
    {
        static::deleted(function (Model $entityModel) {
            $entityModel->followings()->delete();
        });
    }

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
     * Determines if the entity has followings associated.
     *
     * @return bool
     */
    public function hasFollowings()
    {
        return (bool) $this->followings()->withoutTrashed()->count();
    }

    /**
     * Determines if the entity is following the given entity.
     *
     * @return bool
     */
    public function isFollowing(CanBeFollowedContract $entity)
    {
        $following = $this->findFollowing($entity);

        return $following && ! $following->trashed();
    }

    /**
     * Follows the given entity.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function follow(CanBeFollowedContract $entity)
    {
        $following = $this->findFollowing($entity);

        // If the entity previously followed the entity but then unfollowed it,
        // we still have the relationship, it just needs to be restored.
        if ($following && $following->trashed()) {
            $following->restore();
        } elseif (! $following) {
            $follower = new Follower();
            $follower->followable_id = $entity->getKey();
            $follower->followable_type = $entity->getMorphClass();

            $this->followings()->save($follower);
        }

        return $this->fresh();
    }

    /**
     * Follows many entities.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function followMany(Collection $entities)
    {
        $entities->each(function (CanBeFollowedContract $entity) {
            $this->follow($entity);
        });

        return $this->fresh();
    }

    /**
     * Unfollows the given entity.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function unfollow(CanBeFollowedContract $entity)
    {
        $following = $this->findFollowing($entity);

        if ($following && ! $following->trashed()) {
            $this->followings()->whereFollowableEntity($entity)->delete();
        }

        return $this->fresh();
    }

    /**
     * Unfollows many entities.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function unfollowMany(Collection $entities)
    {
        $entities->each(function (CanBeFollowedContract $entity) {
            $this->unfollow($entity);
        });

        return $this->fresh();
    }

    /**
     * Returns the given following entity record if this entity is following it.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function findFollowing(CanBeFollowedContract $entity)
    {
        return $this->followings()->withTrashed()->whereFollowableEntity($entity)->first();
    }

    /**
     * Synchronize many entities to be followed by this entity.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function syncManyFollowings(Collection $entities)
    {
        $this->followings()->delete();

        $entities->each(function (CanBeFollowedContract $entity) {
            $this->follow($entity);
        });

        return $this->fresh();
    }
}

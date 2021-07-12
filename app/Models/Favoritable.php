<?php

namespace App\Models;

trait Favoritable
{
    protected static function bootFavoritable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite($user)
    {
        $withUser = ['user_id' => $user->id];

        if (!$this->favorites()->where($withUser)->exists()) {
            $this->favorites()->create($withUser);
        }
    }

    public function unfavorite($user)
    {
        $withUser = ['user_id' => $user->id];

        if ($this->favorites()->where($withUser)->exists()) {

            $this->favorites()->where($withUser)->get()->each->delete();
        }
    }

    public function isFavoritedByMe()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritedByMeAttribute()
    {
        return $this->isFavoritedByMe();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}

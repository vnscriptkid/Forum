<?php

namespace App\Models;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $withUser = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($withUser)->exists()) {
            $this->favorites()->create($withUser);
        }
    }

    public function isFavoritedByMe()
    {
        return !!$this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}

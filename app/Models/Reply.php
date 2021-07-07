<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->diffForHumans();
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
        return $this->favorites()->where(['user_id' => auth()->id()])->exists();
    }
}

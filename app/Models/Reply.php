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
        $this->favorites()->create([
            'user_id' => auth()->id()
        ]);
    }
}

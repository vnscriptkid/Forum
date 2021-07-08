<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
    protected $with = ['favorites', 'owner'];

    use HasFactory;
    use Favoritable;

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}

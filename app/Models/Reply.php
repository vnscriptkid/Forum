<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];
    protected $with = ['favorites', 'owner'];
    protected $appends = ['favoritesCount', 'favoritedByMe'];

    use HasFactory;
    use Favoritable;
    use RecordsActivity;

    protected static function boot()
    {
        parent::boot();
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function link()
    {
        return $this->thread->link() . "#reply-{$this->id}";
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Reply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function store(Reply $reply)
    {
        $reply->favorite(auth()->user());

        if (request()->wantsJson()) {
            return response(null, 200);
        }

        return back();
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite(auth()->user());
    }
}

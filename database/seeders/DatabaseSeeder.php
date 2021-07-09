<?php

namespace Database\Seeders;

use App\Models\Favorite;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::transaction(function () {
            Cache::clear();

            create(User::class, 1, [
                'email' => 'thanh@gmail.com',
                'password' => bcrypt('12345678')
            ]);

            create(Thread::class, 20);

            $threadIds = Thread::all()->pluck('id');
            $userIds = User::all()->pluck('id');

            Reply::factory(200)->create([
                'thread_id' => function () use ($threadIds) {
                    return $threadIds->random();
                }
            ]);

            $replyIds = Reply::all()->pluck('id');

            collect(range(1, 500))->each(function () use ($userIds, $replyIds) {
                $added = false;
                while (!$added) {
                    $userId = $userIds->random();
                    $replyId = $replyIds->random();

                    $favorite = Favorite::where([
                        'user_id' => $userId,
                        'favorited_id' => $replyId,
                        'favorited_type' => 'App\Models\Reply'
                    ]);

                    if (!$favorite->exists()) {
                        DB::table('favorites')->insert([
                            'user_id' => $userId,
                            'favorited_id' => $replyId,
                            'favorited_type' => 'App\Models\Reply'
                        ]);
                        $added = true;
                    }
                }
            });
        });
    }
}

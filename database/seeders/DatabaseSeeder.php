<?php

namespace Database\Seeders;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Database\Seeder;
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
            create(Thread::class, 20);

            $threadIds = Thread::all()->pluck('id');

            Reply::factory(200)->create([
                'thread_id' => function () use ($threadIds) {
                    return $threadIds->random();
                }
            ]);
        });
    }
}

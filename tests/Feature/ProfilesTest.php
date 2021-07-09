<?php

namespace Tests\Feature;

use App\Models\Activity;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_view_profile_of_any_user()
    {
        // Given there's an user
        // When i access his profile
        // Then i can see his name
        $user = create(User::class);

        $response = $this->get("/profiles/{$user->name}");

        $response->assertStatus(200);
        $response->assertSeeText($user->name);
    }

    private function createWithActivity($class, $attributes)
    {
        $item = create($class, 1, $attributes);

        $filtered = array_filter(
            $attributes,
            fn ($key) => in_array($key, ['created_at']),
            ARRAY_FILTER_USE_KEY
        );

        Activity::latest()->take(1)
            ->update($filtered);

        return $item;
    }

    public function test_can_see_threads_or_replies_created_by_one_user_on_his_profile_with_latest_first()
    {
        // Given there's an user
        // And there's 3 threads created by him
        // When i access his profile
        // Then i can see those 3 threads in order from latest to oldest
        $user = create(User::class);
        $this->signIn($user);

        $item1 = $this->createWithActivity(Thread::class, [
            'user_id' => $user->id,
            'created_at' => Carbon::parse('3 days ago')
        ]);

        $item2 = $this->createWithActivity(Thread::class, [
            'user_id' => $user->id,
            'created_at' => Carbon::now()->subDay()
        ]);

        $item3 = $this->createWithActivity(Reply::class, [
            'user_id' => $user->id,
            'created_at' => Carbon::now()->subDays(2),
            'thread_id' => $item1->id
        ]);

        $response = $this->get("/profiles/{$user->name}");

        $response->assertStatus(200);
        $response->assertSeeTextInOrder([
            $item2->title,
            $item3->body,
            $item1->title,
        ]);
    }
}

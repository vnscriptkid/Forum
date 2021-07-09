<?php

namespace Tests\Feature;

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

    public function test_can_see_threads_or_replies_created_by_one_user_on_his_profile_with_latest_first()
    {
        // Given there's an user
        // And there's 3 threads created by him
        // When i access his profile
        // Then i can see those 3 threads in order from latest to oldest
        $this->withoutExceptionHandling();

        $user = create(User::class);
        $this->signIn($user);

        $order3Thread = create(Thread::class, 1, [
            'user_id' => $user->id,
            'created_at' => Carbon::parse('3 days ago')
        ]);
        $order1Thread = create(Thread::class, 1, [
            'user_id' => $user->id,
            'created_at' => Carbon::parse('1 days ago')
        ]);
        $order2Reply = create(Reply::class, 1, [
            'user_id' => $user->id,
            'created_at' => Carbon::parse('2 days ago'),
            'thread_id' => $order1Thread->id
        ]);

        $response = $this->get("/profiles/{$user->name}");

        $response->assertStatus(200);
        $response->assertSeeTextInOrder([
            $order1Thread->title,
            $order2Reply->body,
            $order3Thread->title,
        ]);
    }
}

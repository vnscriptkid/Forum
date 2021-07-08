<?php

namespace Tests\Feature;

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

    public function test_can_see_posts_created_by_one_user_on_his_profile_with_latest_first()
    {
        // Given there's an user
        // And there's 3 threads created by him
        // When i access his profile
        // Then i can see those 3 threads in order from latest to oldest
        $this->withoutExceptionHandling();

        $user = create(User::class);
        $threadA = create(Thread::class, 1, [
            'user_id' => $user->id,
            'created_at' => Carbon::parse('3 days ago')
        ]);
        $threadB = create(Thread::class, 1, [
            'user_id' => $user->id,
            'created_at' => Carbon::parse('1 days ago')
        ]);
        $threadC = create(Thread::class, 1, [
            'user_id' => $user->id,
            'created_at' => Carbon::parse('2 days ago')
        ]);

        $response = $this->get("/profiles/{$user->name}");

        $response->assertStatus(200);
        $response->assertSeeTextInOrder([
            $threadB->title,
            $threadC->title,
            $threadA->title,
        ]);
    }
}

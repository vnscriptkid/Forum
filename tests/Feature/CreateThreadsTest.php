<?php

namespace Tests\Feature;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_users_can_create_thread()
    {
        // Given i am a authenticated user
        $user = User::factory()->create();

        // When i submit a new thread
        $thread = Thread::factory()->make();
        $response = $this->actingAs($user)
            ->followingRedirects()
            ->post('/threads', $thread->toArray());

        // Then i should be able to see it on threads page
        $response->assertSeeText($thread->title);
    }

    public function test_guests_can_not_create_thread()
    {
        // Given i am a guest
        // When i submit a new thread
        $thread = Thread::factory()->make();
        $response = $this->post('/threads', $thread->toArray());

        // Then i should be redirected to login page and no thread has been created
        $response->assertRedirect('/login');
        $this->assertCount(0, Thread::all());
    }
}

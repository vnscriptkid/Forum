<?php

namespace Tests\Feature;

use App\Models\Channel;
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
        // When i submit a new thread
        $thread = make(Thread::class);

        $response = $this->signIn()
            ->followingRedirects()
            ->post('/threads', $thread->toArray());

        // Then i should be able to see it on threads page
        $response->assertSeeText($thread->title);
    }

    public function test_guests_can_not_create_thread()
    {
        // Given i am a guest
        // When i submit a new thread
        $thread = make(Thread::class);
        $response = $this->post('/threads', $thread->toArray());

        // Then i should be redirected to login page and no thread has been created
        $response->assertRedirect('/login');
        $this->assertCount(0, Thread::all());
    }

    public function test_authenticated_user_can_view_create_thread_form()
    {
        // Given i am an authenticated user and there's a channel
        // When i access GET /threads/create
        // Then I should be able to see the form
        $response = $this->signIn()->get("/threads/create");

        $response->assertStatus(200);
        $response->assertSeeText('Create a new thread');
    }

    public function test_guest_can_not_see_create_thread_form()
    {
        $response = $this->get("/threads/create");

        $response->assertRedirect('/login');
    }

    public function test_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function test_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function test_thread_requires_a_channel_id()
    {
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');
    }

    public function test_thread_requires_a_valid_channel_id()
    {
        $this->publishThread(['channel_id' => 999999])
            ->assertSessionHasErrors('channel_id');
    }

    private function publishThread($overrides = [])
    {
        $thread = Thread::factory()->make($overrides);

        return $this->signIn()
            ->post('/threads', $thread->toArray());
    }
}

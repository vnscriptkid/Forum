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
        // Given i am an authenticated user
        // When i access GET /threads/create
        // Then I should be able to see the form
        $response = $this->signIn()->get('/threads/create');

        $response->assertStatus(200);
        $response->assertSeeText('Create a new thread');
    }

    public function test_guest_can_not_see_see_create_thread_form()
    {
        $response = $this->get('/threads/create');

        $response->assertRedirect('/login');
    }
}

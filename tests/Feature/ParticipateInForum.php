<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForum extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
        $this->reply = make(Thread::class);
    }

    public function test_authenticated_user_can_post_a_reply_on_a_thread()
    {
        // Given there's a thread
        // And I am an authenticated user
        // When i post my reply on thread
        $response = $this
            ->signIn()
            ->followingRedirects()
            ->post($this->thread->link() . '/replies', $this->reply->toArray());

        // Then it's visible on the thread
        $response->assertSeeText($this->reply->body);
    }

    public function test_unauthenticated_user_can_not_post_reply_on_thread()
    {
        // Given there's a thread
        // And I am an unauthenticated user
        // When i post my reply on thread

        $response = $this->post($this->thread->link() . '/replies', $this->reply->toArray());

        // Then i should be redirected to login page
        $response->assertRedirect('/login');
        // And no reply has been added
        $this->assertCount(0, $this->thread->replies);
    }
}

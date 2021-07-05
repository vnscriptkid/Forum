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

    public function test_authenticated_user_can_post_a_reply_on_a_thread()
    {
        // Given there's a thread
        $thread = create(Thread::class);
        // And I am an authenticated user

        // When i post my reply on thread
        $reply = make(Reply::class);

        $response = $this
            ->signIn()
            ->followingRedirects()
            ->post($thread->link() . '/replies', $reply->toArray());

        // Then it's visible on the thread
        $response->assertSeeText($reply->body);
    }

    public function test_unauthenticated_user_can_not_post_reply_on_thread()
    {
        // Given there's a thread
        $thread = create(Thread::class);

        // And I am an unauthenticated user
        // When i post my reply on thread
        $reply = make(Reply::class);

        $response = $this->post($thread->link() . '/replies', $reply->toArray());

        // Then i should be redirected to login page
        $response->assertRedirect('/login');
        // And no reply has been added
        $this->assertCount(0, $thread->replies);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_delete_his_own_thread()
    {
        // Given I am an authenticated user
        // And there's a thread that I am the creator
        // When I delete my thread
        // Then the thread no longer exist in db
        $me = create(User::class);
        $myThread = create(Thread::class, 1, [
            'user_id' => $me->id
        ]);

        $response = $this->signIn($me)->json('delete', $myThread->link());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', ['id' => $myThread->id]);
    }

    public function test_authenticated_user_can_not_delete_thread_of_other()
    {
        $me = create(User::class);
        $someoneElseThread = create(Thread::class);

        $response = $this->signIn($me)->json('delete', $someoneElseThread->link());

        $response->assertStatus(403);
        $this->assertDatabaseHas('threads', ['id' => $someoneElseThread->id]);
    }

    public function test_guests_can_not_delete_thread()
    {
        $thread = create(Thread::class);

        $response = $this->json('delete', $thread->link());

        $response->assertStatus(401);
        $this->assertDatabaseHas('threads', ['id' => $thread->id]);
    }

    public function test_all_replies_associated_with_thread_get_deleted()
    {
        $this->withoutExceptionHandling();
        $me = create(User::class);
        $myThread = create(Thread::class, 1, [
            'user_id' => $me->id
        ]);
        $repliesOnMyThread = create(Reply::class, 2, [
            'thread_id' => $myThread->id
        ]);

        $response = $this->signIn($me)->json('delete', $myThread->link());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('threads', ['id' => $myThread->id]);
        $this->assertDatabaseMissing('replies', ['id' => $repliesOnMyThread[0]->id]);
        $this->assertDatabaseMissing('replies', ['id' => $repliesOnMyThread[1]->id]);
    }
}

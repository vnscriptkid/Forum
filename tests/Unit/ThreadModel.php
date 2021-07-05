<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadModel extends TestCase
{
    use RefreshDatabase;

    public function test_it_belongs_to_an_user()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(User::class, $thread->owner);
    }

    public function test_it_has_many_replies()
    {
        $thread = create(Thread::class);

        create(Reply::class, 2, ['thread_id' => $thread->id]);

        $this->assertContainsOnlyInstancesOf(Reply::class, $thread->replies);
        $this->assertCount(2, $thread->replies);
    }

    public function test_it_can_add_a_reply()
    {
        $thread = create(Thread::class);

        $thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'A sample body'
        ]);

        $this->assertCount(1, $thread->replies);
    }
}

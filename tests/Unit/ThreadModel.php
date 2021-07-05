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
        $thread = Thread::factory()->create();

        $this->assertInstanceOf(User::class, $thread->owner);
    }

    public function test_it_has_many_replies()
    {
        $thread = Thread::factory()->create();

        Reply::factory(2)->create(['thread_id' => $thread->id]);

        $this->assertContainsOnlyInstancesOf(Reply::class, $thread->replies);
        $this->assertCount(2, $thread->replies);
    }

    public function test_it_can_add_a_reply()
    {
        $thread = Thread::factory()->create();

        $thread->addReply([
            'user_id' => User::factory()->create()->id,
            'body' => 'A sample body'
        ]);

        $this->assertCount(1, $thread->replies);
    }
}

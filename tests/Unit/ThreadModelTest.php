<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadModelTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thread = create(Thread::class);
    }

    public function test_it_belongs_to_an_user()
    {
        $this->assertInstanceOf(User::class, $this->thread->owner);
    }

    public function test_it_has_many_replies()
    {
        create(Reply::class, 2, ['thread_id' => $this->thread->id]);

        $this->assertContainsOnlyInstancesOf(Reply::class, $this->thread->replies);
        $this->assertCount(2, $this->thread->replies);
    }

    public function test_it_can_add_a_reply()
    {
        $this->thread->addReply([
            'user_id' => create(User::class)->id,
            'body' => 'A sample body'
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_it_belongs_to_a_channel()
    {
        $this->assertInstanceOf(Channel::class, $this->thread->channel);
    }

    public function test_it_has_a_link()
    {
        $this->assertEquals('/threads/' . $this->thread->channel->slug . '/' . $this->thread->id, $this->thread->link());
    }
}

<?php

namespace Tests\Unit;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChannelModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_threads()
    {
        $channel = create(Channel::class);
        create(Thread::class, 2, ['channel_id' => $channel->id]);
        create(Thread::class);

        $this->assertCount(2, $channel->threads);
        $this->assertContainsOnlyInstancesOf(Thread::class, $channel->threads);
    }
}

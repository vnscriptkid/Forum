<?php

namespace Tests\Feature;

use App\Models\Channel;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrowseThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_browse_all_threads()
    {
        $threads = create(Thread::class, 2);

        $response = $this->get('/threads');

        $response->assertStatus(200);
        $response->assertSeeText($threads[0]->title);
        $response->assertSeeText($threads[1]->title);
        $response->assertSee($threads[0]->link());
        $response->assertSee($threads[1]->link());
    }

    public function test_can_filter_threads_belong_to_one_channel()
    {
        $channel = create(Channel::class);

        $threadOfChannel = create(Thread::class, 1, ['channel_id' => $channel->id]);
        $threadOutsideChannel = create(Thread::class);

        $response = $this->get("/threads/{$channel->slug}");

        $response->assertStatus(200);
        $response->assertSeeText($threadOfChannel->title);
        $response->assertDontSeeText($threadOutsideChannel->title);
    }

    public function test_can_filter_threads_belong_to_one_username()
    {
        $john = create(User::class, 1, ['name' => 'john']);

        $threadByJohn = create(Thread::class, 1, ['user_id' => $john->id]);
        $threadNotByJohn = create(Thread::class);

        $response = $this->get("/threads?by=john");

        $response->assertStatus(200);
        $response->assertSeeText($threadByJohn->title);
        $response->assertDontSeeText($threadNotByJohn->title);
    }

    public function test_can_browse_a_single_thread_and_who_created_it()
    {
        $thread = create(Thread::class);

        $response = $this->get($thread->link());

        $response->assertStatus(200);
        $response->assertSeeText($thread->title);
        $response->assertSeeText($thread->owner->name);
    }

    public function test_can_see_replies_belongs_to_one_thread()
    {
        // Given a thread
        $thread = create(Thread::class);
        // And that thread has some replies
        $replies = Reply::factory(2)->create(['thread_id' => $thread->id]);

        // When I browse that thread
        $response = $this->get($thread->link());

        // Then I can see replies of that thread
        $response->assertStatus(200);
        $response->assertSeeText($replies[0]->body);
        $response->assertSeeText($replies[1]->body);

        // And I can see owners for each thread
        $response->assertSeeText($replies[0]->owner->name);
        $response->assertSeeText($replies[1]->owner->name);
    }
}

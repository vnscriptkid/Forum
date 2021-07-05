<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BrowseThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_browse_all_threads()
    {
        $threads = Thread::factory(2)->create();

        $response = $this->get('/threads');

        $response->assertStatus(200);
        $response->assertSeeText($threads[0]->title);
        $response->assertSeeText($threads[1]->title);
        $response->assertSee('/threads/' . $threads[0]->id);
        $response->assertSee('/threads/' . $threads[1]->id);
    }

    public function test_can_browse_a_single_thread()
    {
        $thread = Thread::factory()->create();

        $response = $this->get('/threads/' . $thread->id);

        $response->assertStatus(200);
        $response->assertSeeText($thread->title);
    }

    public function test_can_see_replies_belongs_to_one_thread()
    {
        $this->withoutExceptionHandling();
        // Given a thread
        $thread = Thread::factory()->create();
        // And that thread has some replies
        $replies = Reply::factory(2)->create(['thread_id' => $thread->id]);

        // When I browse that thread
        $response = $this->get('/threads/' . $thread->id);

        // Then I can see replies of that thread
        $response->assertStatus(200);
        $response->assertSeeText($replies[0]->body);
        $response->assertSeeText($replies[1]->body);

        // And I can see owners for each thread
        $response->assertSeeText($replies[0]->owner->name);
        $response->assertSeeText($replies[1]->owner->name);
    }
}

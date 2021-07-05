<?php

namespace Tests\Feature;

use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadsTest extends TestCase
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
        $this->withoutExceptionHandling();
        $thread = Thread::factory()->create();

        $response = $this->get('/threads/' . $thread->id);

        $response->assertStatus(200);
        $response->assertSeeText($thread->title);
    }
}

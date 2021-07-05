<?php

namespace Tests\Unit;

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
}

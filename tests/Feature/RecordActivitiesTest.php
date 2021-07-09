<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RecordActivitiesTest extends TestCase
{
    use RefreshDatabase;

    public function test_auto_record_activity_when_thread_is_created()
    {
        // Given i am an authenticated user
        // When i create a thread
        // Then the activity should be recorded
        $this->signIn();

        $thread = create(Thread::class, 1, ['user_id' => $this->getSignedInUser()->id]);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => $thread->owner->id,
            'subject_id' => $thread->id,
            'subject_type' => 'App\Models\Thread'
        ]);
    }

    public function test_auto_record_activity_when_reply_is_created()
    {
        $this->signIn();

        $reply = create(Reply::class, 1, ['user_id' => $this->getSignedInUser()->id]);

        $this->assertDatabaseCount('activities', 2);
        $this->assertDatabaseHas('activities', [
            'type' => 'created_reply',
            'user_id' => $reply->owner->id,
            'subject_id' => $reply->id,
            'subject_type' => 'App\Models\Reply'
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteRepliesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_not_delete_reply()
    {
        $reply = create(Reply::class);

        $response = $this->delete("/replies/{$reply->id}");

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('replies', ['id' => $reply->id]);
    }

    public function test_user_can_not_delete_other_reply()
    {
        $reply = create(Reply::class);

        $response = $this->signIn()->delete("/replies/{$reply->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('replies', ['id' => $reply->id]);
    }

    public function test_user_can_delete_his_own_reply()
    {
        $this->signIn();

        $reply = create(Reply::class, 1, [
            'user_id' => auth()->id()
        ]);

        $response = $this->from('/somewhere')->delete("/replies/{$reply->id}");

        $response->assertRedirect('/somewhere');
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }
}

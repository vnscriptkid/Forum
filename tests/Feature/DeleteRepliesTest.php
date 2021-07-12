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

    public function test_deleting_liked_comment_will_clear_all_associated_activities()
    {
        // Given i am an authenticated user
        $this->signIn();
        // And I left a reply on some random post
        $reply = create(Reply::class, ['user_id' => auth()->id()]);
        // And I liked it myself
        $reply->favorite(auth()->user());

        // When I delete my comment
        $this->json('delete', "/replies/{$reply->id}")->assertStatus(200);

        // Then 2 associated activities `reply_created` and `favorite_created` should be deleted from db
        $this->assertDatabaseMissing('activities', ['type' => 'created_reply', 'user_id' => auth()->id()]);
        $this->assertDatabaseMissing('activities', ['type' => 'created_favorite', 'user_id' => auth()->id()]);
    }
}

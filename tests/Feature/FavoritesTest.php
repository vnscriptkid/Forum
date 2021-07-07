<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_like_a_reply()
    {
        // Given there's a reply
        // And i am an authenticated user
        // When a like a reply by: POST /replies/replyId/favorites
        // Then there must be a favorite for that reply in database
        $reply = create(Reply::class);

        $response = $this->signIn()->post("/replies/{$reply->id}/favorites");

        $response->assertStatus(200);
        $this->assertCount(1, $reply->favorites);
        $this->assertEquals($this->getSignedInUser()->id, $reply->favorites->first()->user_id);
    }

    public function test_guests_can_not_like_a_reply()
    {
        $reply = create(Reply::class);

        $response = $this->post("/replies/{$reply->id}/favorites");

        $response->assertRedirect('/login');
        $this->assertCount(0, $reply->favorites);
    }
}

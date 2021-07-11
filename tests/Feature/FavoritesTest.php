<?php

namespace Tests\Feature;

use App\Models\Reply;
use App\Models\User;
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

        $response->assertStatus(302);
        $this->assertCount(1, $reply->favorites);
        $this->assertEquals($this->getSignedInUser()->id, $reply->favorites->first()->user_id);
    }

    public function test_authenticated_user_can_like_a_reply_only_once()
    {
        $reply = create(Reply::class);

        $this->signIn()->post("/replies/{$reply->id}/favorites");
        $this->post("/replies/{$reply->id}/favorites");

        $this->assertCount(1, $reply->favorites);
    }

    public function test_guests_can_not_like_a_reply()
    {
        $reply = create(Reply::class);

        $response = $this->post("/replies/{$reply->id}/favorites");

        $response->assertRedirect('/login');
        $this->assertCount(0, $reply->favorites);
    }

    public function test_guests_can_not_unlike_a_reply()
    {
        $reply = create(Reply::class);
        $user = create(User::class);
        $reply->favorite($user);

        $response = $this->delete("/replies/{$reply->id}/favorites");

        $response->assertRedirect('/login');
        $this->assertDatabaseHas('favorites', ['user_id' => $user->id]);
    }

    public function test_authenticated_user_can_unlike_a_reply()
    {
        $this->signIn();

        $someone = create(User::class);
        $reply = create(Reply::class);

        $reply->favorite(auth()->user());
        $reply->favorite($someone);

        $response = $this->delete("/replies/{$reply->id}/favorites");

        $response->assertStatus(200);
        $this->assertDatabaseMissing('favorites', ['user_id' => auth()->id()]);
        $this->assertDatabaseHas('favorites', ['user_id' => $someone->id]);
    }
}

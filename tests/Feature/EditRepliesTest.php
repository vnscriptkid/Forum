<?php

namespace Tests\Feature;

use App\Models\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EditRepliesTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_user_can_not_edit_reply()
    {
        $reply = create(Reply::class);

        $response = $this->patch("/replies/{$reply->id}", [
            'body' => 'Body updated'
        ]);

        $response->assertRedirect('/login');
    }

    public function test_reply_onwer_can_edit_his_reply()
    {
        $this->signIn();

        $reply = create(Reply::class, 1, ['user_id' => auth()->id()]);

        $response = $this->patch("/replies/{$reply->id}", [
            'body' => 'Body updated'
        ]);

        $response->assertStatus(200);
        $this->assertDatabaseHas('replies', [
            'id' => $reply->id,
            'body' => 'Body updated'
        ]);
    }

    public function test_unauthorized_user_can_not_edit_reply()
    {
        $reply = create(Reply::class);

        $response = $this->signIn()->patch("/replies/{$reply->id}", [
            'body' => 'Body updated'
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseMissing('replies', [
            'id' => $reply->id,
            'body' => 'Body updated'
        ]);
    }

    public function test_returns_404_if_reply_id_does_not_exist()
    {
        $response = $this->signIn()->patch("/replies/nonexistentid", [
            'body' => 'Body updated'
        ]);

        $response->assertStatus(404);
    }

    public function test_returns_422_if_body_is_empty()
    {
        $this->signIn();

        $reply = create(Reply::class, 1, ['user_id' => auth()->id()]);

        $response = $this->json('PATCH', "/replies/{$reply->id}", [
            'body' => null
        ], ['Accept' => 'application/json']);

        $response->assertStatus(422);
        $response->assertJson(['body' => ['The body field is required.']]);
    }
}

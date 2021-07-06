<?php

namespace Tests\Unit;

use App\Models\Reply;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_an_owner()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->owner);
    }
}

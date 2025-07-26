<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Comment;

class CommentTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateComment()
    {
        $comment = new Comment();
        $comment->email = 'test@example.com';
        $comment->title = 'Test Comment';
        $comment->comment = 'This is a test comment.';
        $comment->save();

        $this->assertDatabaseHas('comments', [
            'email' => 'test@example.com',
            'title' => 'Test Comment',
            'comment' => 'This is a test comment.',
        ]);
    }
}

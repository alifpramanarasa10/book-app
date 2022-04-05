<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_book()
    {
        $response = $this->get('/api/book');

        $response->assertStatus(200);
    }

    public function test_create_book()
    {
        $book = [
            'author_id' => 1,
            'title' => 'Testing',
            'description' => 'Testing',
            'image' => 'default.jpg'
        ];
        
        $this->json('POST', 'api/book/', $book,
        [
            'Accept' => 'application/json',
            'x-api-key' => env('API_KEY')
        ])
        ->assertStatus(200)
        ->assertJsonStructure([
            "code",
            "status",
            "message",
            "data"
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\User;
use App\Author;
use Tests\TestCase;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthorsTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @watch
     */
    public function it_returns_an_author_as_a_resource_object()
    {
        //$author = factory(Author::class)->create();

        $author = Author::create([
            'name' => 'John Doe'
        ]);

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $this->getJson('/api/v1/authors/1')
            ->assertStatus(200)
            ->assertJson([
                "data" => [
                    "id" => '1',
                    "type" => "authors",
                    "attributes" => [
                        'name' => $author->name,
                        'created_at' => $author->created_at->toJSON(),
                        'updated_at' => $author->updated_at->toJSON(),
                    ]
                ]
            ]);
    }
}

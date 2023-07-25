<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequireContentTypeJsonTest extends TestCase
{
    /**
     * @dataProvider listOfRoutes
     */
    public function test_example(string $routeName, string $method, ?int $routeParam = null)
    {
        $response = $this->{$method}(route($routeName, [$routeParam]));

        $response->assertStatus(400)
            ->assertExactJson([
                'message' => 'Content type should be application/json'
            ]);
    }

    public static function listOfRoutes(): array
    {
        return [
            ['events.index', 'get'],
            ['events.update', 'put', 1],
            ['events.update', 'patch', 1],
            ['events.show', 'get',1],
            ['events.destroy', 'delete',1],
        ];
    }
}

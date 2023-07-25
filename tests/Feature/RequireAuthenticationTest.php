<?php


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RequireAuthenticationTest extends TestCase
{
    /**
     * @dataProvider listOfRoutes
     */
    public function test_example(string $routeName, string $method, ?int $routeParam = null)
    {
        $response = $this->{$method}(route($routeName, [$routeParam]));

        $response->assertStatus(401)
            ->assertExactJson([
                'message' => 'Unauthenticated.'
            ]);
    }

    public static function listOfRoutes(): array
    {
        return [
            ['events.index', 'getJson'],
            ['events.update', 'putJson', 1],
            ['events.update', 'patchJson', 1],
            ['events.show', 'getJson',1],
            ['events.destroy', 'deleteJson',1],
        ];
    }
}

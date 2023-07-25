<?php

namespace Tests\Feature\User;

use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;


class LoginTest extends TestCase
{

    protected User $user;

    protected string $password;

    protected function setUp(): void
    {
        parent::setUp();

        $this->password = Str::password();

        $this->user = User::factory(['password' => $this->password])->create();
    }

    /**
     * @test
     */
    public function successful_login(): void
    {
        $response = $this->postJson(route('user.login'), [
            'email' => $this->user->email,
            'password' => $this->password,
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * @test
     */
    public function login_with_wrong_password(): void
    {
        $response = $this->postJson(route('user.login'), [
            'email' => $this->user->email,
            'password' => 'incorrect_password',
        ]);

        $response->assertStatus(422)
            ->assertJsonFragment(['message' => 'The provided credentials are incorrect.']);
    }

    /**
     * @test
     */
    public function login_without_password(): void
    {
        $response = $this->postJson(route('user.login'), [
            'email' => $this->user->email,
        ]);

        $response->assertStatus(422)
            ->assertJsonFragment([
                'message' => 'The password field is required.',
                'errors' => [
                    'password' => [
                        'The password field is required.'
                    ]
    ]
            ]);
    }
}

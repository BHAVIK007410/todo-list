<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function test_the_login_is_successful()
    {
        $user = User::factory()->create(['password' => Hash::make('User12345')]);

        // Define custom headers
        $headers = [
            'X-API-Key' => 'SSD%$@#@DFDFFDFSD',
            'app-language' => 'en',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        // Perform the post request with custom headers and data
        $response = $this->withHeaders($headers)->json('POST', '/api/user/login', [
            'email' => $user->email,
            'password' => 'User12345',
        ]);

        $response->assertStatus(200);
    }

    public function test_login_with_wrong_password()
    {
        // Define custom headers
        $headers = [
            'X-API-Key' => 'SSD%$@#@DFDFFDFSD',
            'app-language' => 'en',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        // Perform the post request with custom headers and data
        $response = $this->withHeaders($headers)->json('POST', '/api/user/login', [
            'email' => "bhavik.test@yopmail.com",
            'password' => "wrongpassword",
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'status' => 401,
                'success' => false,
                'message' => 'Email or password wrong.'
            ]);
    }

    public function test_login_with_missing_email_address()
    {
        $response = $this->withHeaders([
            'X-API-Key' => 'SSD%$@#@DFDFFDFSD',
            'app-language' => 'en',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/user/login', [
            'password' => 'User12345',
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => [
                    'email' => [
                        'The email field is required.'
                    ]
                ]
            ]);
    }

    public function test_login_with_invalid_email_address()
    {
        $response = $this->withHeaders([
            'X-API-Key' => 'SSD%$@#@DFDFFDFSD',
            'app-language' => 'en',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/user/login', [
            'email' => "bhavik.test@yopmail",
            'password' => "wrongpassword",
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => "Email or password wrong."
            ]);
    }

    public function test_login_with_missing_password()
    {
        $response = $this->withHeaders([
            'X-API-Key' => 'SSD%$@#@DFDFFDFSD',
            'app-language' => 'en',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/user/login', [
            'email' => "bhavik.test@yopmail.com",
        ]);

        $response->assertStatus(422)
            ->assertJson([
                'success' => false,
                'message' => [
                    'password' => [
                        'The password field is required.'
                    ]
                ]
            ]);
    }

    public function test_login_with_deleted_user()
    {
        $user = User::factory()->create(['deleted_at' => now()]);

        $response = $this->withHeaders([
            'X-API-Key' => 'SSD%$@#@DFDFFDFSD',
            'app-language' => 'en',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/user/login', [
            'email' => $user->email,
            'password' => 'User12345',
        ]);

        $response->assertStatus(401);
    }

    public function test_login_with_invalid_api_key()
    {
        $response = $this->withHeaders([
            'X-API-Key' => 'invalid_key',
            'app-language' => 'en',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/user/login', [
            'email' => 'bhavik.test@yopmail.com',
            'password' => 'User12345',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => "Wrong or no X-API-Key passed in header.",
            ]);
    }

    public function test_login_with_missing_app_language()
    {
        $response = $this->withHeaders([
            'X-API-Key' => 'SSD%$@#@DFDFFDFSD',
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->postJson('/api/user/login', [
            'email' => 'bhavik.test@yopmail.com',
            'password' => 'User12345',
        ]);

        $response->assertStatus(400)
            ->assertJson([
                'success' => false,
                'message' => 'Wrong or no app-language passed in header.'
            ]);
    }
}

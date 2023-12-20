<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TheProjectTest extends TestCase
{
    protected $email;
    protected $password = 'password';
    protected $authCode;

    // Before each Featuretest, create a user account
    protected function setUp(): void {
        parent::setUp();
        $this->create_user_account();
    }

    public function create_user_account(): void {
        $this->email = 'user' . rand(0, 10000) . '+' . time() . '@nice.local';

        $response = $this->post('/register', [
            'name' => 'test',
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->password,
        ]);

        $response->assertStatus(200);

        $response = $this->post('/login', [
            'email' => $this->email,
            'password' => $this->password,
        ]);

        $this->authCode = $response->json()['token'];
    }

    /**
     * Perform a login test.
     */
    public function test_update_project(): void
    {
        // Create project + append auth code for login
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->post('/projects', [
            'name' => 'test',
            'description' => 'test',
        ]);
        $response->assertStatus(201);
    }

    public function test_get_project(): void
    {
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->authCode,
            ])->get('/projects/1');
            $response->assertStatus(200);
    }

    
}

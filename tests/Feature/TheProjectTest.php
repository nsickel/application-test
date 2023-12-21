<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
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

    private function create_project()
    {
        return $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->post('/projects', [
            'name' => 'test',
            'description' => 'test'
        ]);
    }

    private function get_new_project_response_data()
    {
        $response = $this->create_project();
        return json_decode($response->getContent());
    }


    public function test_create_project(): void
    {
        // Create project + append auth code for login
        $response = $this->create_project();
        $response->assertStatus(201);
    }


    public function test_read_project(): void
    {
        $content = $this->get_new_project_response_data();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->authCode,
            ])->get('/projects/' . (string) $content->data->id);
            $response->assertStatus(200);
    }

    public function test_404_no_project_found():void
    {
         $random_number = rand(99999, 1000000);
         $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->authCode,
            ])->get('/projects/' . (string) $random_number);
         $response->assertStatus(404);
    }

    /**
    public function test_update_project(): void
    {
        $content = $this->get_new_project_response_data();
        $response = $this->withHeaders([
                'Authorization' => 'Bearer ' . $this->authCode,
            ])->put('/projects/' . (string) $content->data->id, [
                'name' => 'test test',
                'description' => 'test test'
            ]);
        $updated_content = json_decode($response->getContent());
        print_r($updated_content);
    }*/

    public function test_destroy(): void
    {
        $content = $this->get_new_project_response_data();
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->authCode,
        ])->delete('/projects/'. (string) $content->data->id);
        $response->assertStatus(200);
    }
}

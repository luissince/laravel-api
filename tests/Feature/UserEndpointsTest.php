<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserEndpointsTest extends TestCase
{
    // public function test_login_endpoint()
    // {
    //     $headers = [
    //         'Content-Type' => 'application/json',
    //         'Accept' => 'application/json',
    //     ];

    //     $payload = [
    //         "email" => "demo5@demo.com",
    //         "password" => "demo123456+"
    //     ];

    //     $this->json('POST', '/api/login', $payload, $headers)
    //         ->assertStatus(200);
    // }

    public function test_signup_endpoint()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];

        $payload = [
            "name" => "demo15",
            "email" => "demo15@demo.com",
            "password" => "demo123456+",
            "password_confirmation" => "demo123456+",
        ];

        $this->json('POST', '/api/signup', $payload, $headers)
            ->assertStatus(201);
    }

    // public function test_users_endpoint()
    // {
    //     $headers = [
    //         'Authorization' => 'Bearer 28|6e6xsxy21ztlybkBFfLfOJIuKIgVq4ilDh6e00ZT',
    //         'Content-Type' => 'application/json',
    //         'Accept' => 'application/json',
    //     ];

    //     $payload = [];

    //     $this->json('GET', '/api/users', $payload, $headers)
    //         ->assertStatus(200);
    // }

    // public function test_user_logout_endpoint()
    // {
    //     $headers = [
    //         'Authorization' => 'Bearer 28|6e6xsxy21ztlybkBFfLfOJIuKIgVq4ilDh6e00ZT',
    //         'Content-Type' => 'application/json',
    //         'Accept' => 'application/json',
    //     ];

    //     $payload = [];

    //     $this->json('DELETE', '/api/logout', $payload, $headers)
    //         ->assertStatus(200);
    // }
}

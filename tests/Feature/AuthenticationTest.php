<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class AuthenticationTest extends TestCase
{
    public function testRequiredFieldsForRegistration()
    {
        $this->json('POST', 'api/user/auth/register', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "data"=>[],
                "success"=> false,
                "message" => [
                    "name" => ["The name field is required."],
                    "email" => ["The email field is required."],
                    "password" => ["The password field is required."],
                ]
            ]);
    }

    public function testRepeatPassword()
    {
        $userData = [
            "name" => "John Doe",
            "email" => "doe@example.com",
            "password" => "demo12345",
            "password_confirmation" => "demo123456",
        ];

        $this->json('POST', 'api/user/auth/register', $userData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJson([
                "data"=>[],
                "success"=> false,
                //"message" => "The given data was invalid.",
                "message" => [
                    "password" => ["The password confirmation does not match."]
                ]
            ]);
    }

    // public function testSuccessfulRegistration()
    // {
    //     $userData = [
    //         "name" => "John Doe",
    //         "email" => "doe@example.com",
    //         "password" => "demo12345",
    //         "role_type" => "customer",
    //         "updated_at"=> "2022-02-14T08:51:09.000000Z",
    //         "created_at"=> "2022-02-14T08:51:09.000000Z",
    //        // "password_confirmation" => "demo12345"
    //     ];
    //     $this->withoutExceptionHandling();
       
    //     $this->json('POST', 'api/user/auth/register', $userData, ['Accept' => 'application/json'])
    //         ->assertStatus(200)
    //         ->assertJson([
    //             "data" => [
    //                 "user" => [
    //                     "name",
    //                     "email" ,
    //                     "password" ,
    //                     "role_type",
    //                     "updated_at",
    //                     "created_at",
    //                 ],
    //                 'access_token',
    //                 'token_type'
    //             ],
    //             "success"=>true,
    //             "message"=>"Register successfully."
    //         ]);
    //         $this->assertAuthenticated();
    // }
        
}

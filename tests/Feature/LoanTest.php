<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoanTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // public function test_example()
    // {
    //     $response = $this->get('/');

    //     $response->assertStatus(200);
    // }

    // public function testRequiredFieldsForLoanRequest()
    // {
    //     $this->assertAuthenticated();
    //     $this->json('POST', 'api/user/loan_rerquest', ['Accept' => 'application/json'])
    //         ->assertStatus(200)
    //         ->assertJson([
    //             "data"=>[],
    //             "success"=> false,
    //             "message" => [
    //                 "amount" => ["The amount field is required."],
    //                 "duration" => ["The duration field is required."]
    //             ]
    //         ]);
    // }
}

<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test create user.
     */
    public function test_register_user_with_api_expect_code_201(): void
    {
        $response = $this->json('POST', 'api/auth/register', [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => '12345678',
        ]);

        $response->assertCreated();
    }

    public function test_register_user_expect_return_json_with_structure_correctly(): void
    {
        $response = $this->json('POST', 'api/auth/register', [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => '12345678',
        ]);

        $response->assertCreated();

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                    $json->hasAll(['status', 'message', 'token'])
            );
    }

    public function test_create_user_missing_param_name_expect_unprocessable_code_422(): void
    {
        $response = $this->json('POST', 'api/auth/register', [
            'email' => fake()->email(),
            'password' => '12345678',
        ]);

        $response->assertUnprocessable();
        $response->assertStatus(422);
    }

    public function test_create_user_invalid_email_expect_unprocessable_code_422(): void
    {
        $response = $this->json('POST', 'api/auth/register', [
            'name' => fake()->name(),
            'email' => 'mario', //invalid email
            'password' => '12345678',
        ]);

        $response->assertUnprocessable();
        $response->assertStatus(422);
    }

    public function test_login_expect_valid_json_with_status_true_code_200(): void
    {
        $email = fake()->email();
        $password = fake()->password(minLength: 8);

        $response = $this->json('POST', 'api/auth/register', [
            'name' => fake()->name(),
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertCreated();

        $response = $this->json('POST', 'api/auth/login', [
            'email' => $email,
            'password' => $password,
        ]);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                    $json->hasAll(['status', 'message', 'token'])
                        ->where('status', true)
            );

        $response->assertOk();
    }

    public function test_error_login_expect_status_false_and_code_401(): void
    {
        $email = fake()->email();
        $password = fake()->password(minLength: 8);

        $response = $this->json('POST', 'api/auth/register', [
            'name' => fake()->name(),
            'email' => $email,
            'password' => $password,
        ]);

        $response->assertCreated();

        $response = $this->json('POST', 'api/auth/login', [
            'email' => $email,
            'password' => 1234,
        ]);

        $response
            ->assertJson(
                fn (AssertableJson $json) =>
                    $json->hasAll(['status', 'message'])
                        ->where('status', false)
            );

        $response->assertStatus(401);
    }
}

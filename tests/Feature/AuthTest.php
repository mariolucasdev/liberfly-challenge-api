<?php

namespace Tests\Feature;

use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test create user expect code 201.
     */
    public function test_register_user_with_api_expect_code_201(): void
    {
        $response = $this->json('POST', 'api/auth/register', [
            'name' => fake()->name(),
            'email' => fake()->email(),
            'password' => '12345678',
        ]);

        $response->assertCreated();
        $response->assertStatus(201);
    }

    /**
     * Test crete with return json with correct structure
     *
     * @return void
     */
    public function test_register_user_expect_return_json_with_structure_correct(): void
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

    /**
     * Test try create user with param missed, expect unprocessable code 422
     *
     * @return void
     */
    public function test_create_user_missing_param_name_expect_unprocessable_code_422(): void
    {
        $response = $this->json('POST', 'api/auth/register', [
            'email' => fake()->email(),
            'password' => '12345678',
        ]);

        $response->assertUnprocessable();
        $response->assertStatus(422);
    }

    /**
     * Test try create user with invalid email, expect unprocessable code 422
     *
     * @return void
     */
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

    /**
     * Test login user, expect json valid
     * with status 200 and param status been true
     *
     * @return void
     */
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

    /**
     * Test try login user with incorrectly password,
     * expect param status false, message and code 401
     *
     * @return void
     */
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

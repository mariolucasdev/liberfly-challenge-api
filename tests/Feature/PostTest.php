<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    /**
     * Create post expect created status with code 201
     *
     * @return void
     */
    public function test_create_new_post_expect_status_created_with_code_201(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->json('POST', 'api/post', [
            'title' => fake()->title(),
            'slug' => fake()->slug(5, true),
            'content' => fake()->paragraph(3, true)
        ]);

        $response->assertCreated();
        $response->assertStatus(201);
    }

    /**
     * Test create new post without user toke,
     * expect unauthorize response and code 401
     *
     * @return void
     */
    public function test_crete_new_post_without_user_token_expect_unauthorize_code_401(): void
    {
        $response = $this->json('POST', 'api/post', [
            'title' => fake()->title(),
            'slug' => fake()->slug(5, true),
            'content' => fake()->paragraph(3, true)
        ]);

        $response->assertUnauthorized();
        $response->assertStatus(401);

    }

    /**
     * Test list posts expect asset ok with status code 200
     *
     * @return void
     */
    public function test_list_posts_expect_assert_ok_with_code_200(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->json('GET', 'api/post');

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->first(
                fn ($post) =>
                $post->hasAll(['id', 'title', 'slug', 'content', 'created_at', 'updated_at'])
            )
        );

        $response->assertOk();
    }

    /**
     * Test show post expect assert ok with status 200
     *
     * @return void
     */
    public function test_show_post_expect_assert_ok_with_status_code_200(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $post = Post::latest()->first();

        $response = $this->json('GET', 'api/post/'.$post->id);

        $response->assertStatus(200);
        $response->assertOk();
    }

    /**
     * Test show post expect assert ok with status 200
     *
     * @return void
     */
    public function test_show_post_expect_structure_json_correct(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $post = Post::latest()->first();

        $response = $this->json('GET', 'api/post/'.$post->id);

        $response->assertJson(
            fn (AssertableJson $json) =>
            $json->hasAll(['id', 'title', 'slug', 'content', 'created_at', 'updated_at'])
                ->where('title', $post->title)
                ->where('slug', $post->slug)
                ->where('content', $post->content)
        );
    }

    /**
     * Test update post expect code 204
     *
     * @return void
     */
    public function test_update_post_expect_code_204(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $post = Post::latest()->first();

        $title = fake()->title();
        $slug = fake()->slug(4, true);
        $content = fake()->paragraph(3, true);

        $response = $this->json('PUT', 'api/post/'.$post->id, [
            'title' => $title,
            'slug' => $slug,
            'content' => $content
        ]);

        $response->assertStatus(204);
    }

    /**
     * Test update post missed field slug
     * expect status 422 unprocessable
     *
     * @return void
     */
    public function test_update_post_missed_field_expect_unprocessable_422(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $post = Post::latest()->first();

        $title = fake()->title();
        $content = fake()->paragraph(3, true);

        $response = $this->json('PUT', 'api/post/'.$post->id, [
            'title' => $title,
            'content' => $content
        ]);

        $response->assertStatus(422);
        $response->assertUnprocessable();
    }

    /**
     * Test delete post expect code 204
     *
     * @return void
     */
    public function test_delete_post_expect_code_204(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $post = Post::latest()->first();

        $response = $this->json('DELETE', 'api/post/'.$post->id);

        $response->assertStatus(204);
    }

    /**
     * Test delete post without token, expect unauthorized
     * code 401
     *
     * @return void
     */
    public function test_delete_post_without_token_expect_unauthorized_code_401(): void
    {
        $post = Post::latest()->first();

        $response = $this->json('DELETE', 'api/post/'.$post->id);

        $response->assertUnauthorized();
        $response->assertStatus(401);
    }

    /**
     * Test delete code with id not found expect code 404
     *
     * @return void
     */
    public function test_delete_post_not_found_expect_code_404(): void
    {
        Sanctum::actingAs(
            User::factory()->create(),
            ['*']
        );

        $response = $this->json('DELETE', 'api/post/11111111111');

        $response->assertStatus(404);
    }
}

<?php

namespace Tests\Unit\Http\Requests;

use App\Infrastructure\Laravel\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class AuthRequestTest extends TestCase
{

    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function login_email_required()
    {
        $this->withoutExceptionHandling();

        $validatedField = 'email';
        $brokenRule = null;

        $credentials = [$validatedField => $brokenRule];

        $response = $this->postJson(
            route('login'),
            $credentials
        );

        $response->assertStatus(JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonStructure(['success', 'message', 'errors']);
        $response->assertJsonValidationErrors($validatedField);
    }

    /**
     * @test
     * @throws \Throwable
     */
    public function login_email_invalidate()
    {
        $this->withoutExceptionHandling();

        $validatedField = 'email';
        $brokenRule = 'emailinvalid';

        $credentials = [$validatedField => $brokenRule];

        $response = $this->postJson(
            route('login'),
            $credentials
        );

        $response->assertUnprocessable();
        $response->assertJsonStructure(['success', 'message', 'errors']);
        $response->assertJsonValidationErrors($validatedField);
    }

    /** @test */
    public function register_with_errors_fields()
    {
        $user = User::factory()->make(['email' => 'email invalid', 'identification' => 'must be numeric', 'type_document_id' => 'id not exist', 'cell_phone' => 'must be numeric', 'is_manager' => 'must be boolean']);
        $data = [
            "name" => $user->name,
            "last_name" => $user->last_name,
            "email" => $user->email,
            "identification" => $user->identification,
            "is_verified" => $user->is_verified,
            "password" => "Lol123Lol@",
            "password_confirmation" => "Lol123Lol@",
        ];

        $response = $this->postJson(route('register'), $data);

        $response->assertJsonValidationErrors(['email', 'identification']);
    }
}

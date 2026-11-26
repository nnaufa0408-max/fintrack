<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
class AuthTest extends TestCase
{
 use RefreshDatabase;
 public function test_user_can_register_and_is_authenticated(): void
 {
  $response=$this->post('/register',['name'=>'Test User','email'=>'test@example.com','password'=>'password123','password_confirmation'=>'password123']);
  $response->assertRedirect('/dashboard');
  $this->assertAuthenticated();
 }
}

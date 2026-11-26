<?php
namespace Tests\Feature;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
class TransactionTest extends TestCase
{
 use RefreshDatabase;
 public function test_authenticated_user_can_create_transaction(): void
 {
  $user=User::factory()->create();
  $response=$this->actingAs($user)->post('/transaksi',['title'=>'Uang makan','type'=>'expense','amount'=>25000,'transaction_date'=>now()->toDateString()]);
  $response->assertRedirect('/transaksi');
  $this->assertDatabaseHas('transactions',['user_id'=>$user->id,'title'=>'Uang makan']);
 }
}

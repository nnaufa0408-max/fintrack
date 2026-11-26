<?php
namespace Database\Seeders;
use App\Models\User;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder
{
 public function run(): void {
  $user=User::firstOrCreate(['email'=>'demo@fintrack.test'],['name'=>'Demo FinTrack','password'=>Hash::make('password123')]);
  $categories=[
   ['name'=>'Gaji','type'=>'income','color'=>'blue'],['name'=>'Freelance','type'=>'income','color'=>'cyan'],
   ['name'=>'Makanan','type'=>'expense','color'=>'orange'],['name'=>'Transportasi','type'=>'expense','color'=>'purple'],
   ['name'=>'Belanja','type'=>'expense','color'=>'pink'],['name'=>'Pendidikan','type'=>'expense','color'=>'green']
  ];
  foreach($categories as $data){Category::firstOrCreate(['user_id'=>$user->id,'name'=>$data['name']],$data);}
  if(!$user->transactions()->exists()){
   $cat=Category::where('user_id',$user->id)->get()->keyBy('name');
   $samples=[
    ['Gaji','income','Uang bulanan',2500000,-20],['Makanan','expense','Makan siang',35000,-18],
    ['Transportasi','expense','Transportasi kampus',20000,-16],['Freelance','income','Desain poster',450000,-12],
    ['Belanja','expense','Kebutuhan harian',125000,-9],['Pendidikan','expense','Buku kuliah',85000,-5]
   ];
   foreach($samples as [$category,$type,$title,$amount,$days]) $user->transactions()->create(['category_id'=>$cat[$category]->id,'type'=>$type,'title'=>$title,'amount'=>$amount,'transaction_date'=>now()->addDays($days)->toDateString()]);
  }
 }
}

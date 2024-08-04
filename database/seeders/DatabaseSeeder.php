<?php

namespace Database\Seeders;

use App\Models\Fee;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        try {
            DB::beginTransaction();

            Role::create(['name' => 'advertiser']);
            Role::create(['name' => 'webmaster']);
            Role::create(['name' => 'administrator']);
            Wallet::create(['system_code' => 101]);
            Wallet::create(['system_code' => 102]);
            Fee::create(['percent' => 15, 'description' => 'basic']);


            $user = User::create([
                'name' => 'admin',
                'email' => 'admin@adtech.com',
                'password' => Hash::make('11111'),
                'role_id' => 3,
                'email_verified_at' => date("Y-m-d H:i:s"),
            ]);

            $wallet = Wallet::create([
                'balance' => 0,
                'user_id' => $user->id,
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }
}

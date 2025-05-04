<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $users = [
      [
        'username' => 'admin',
        'password' => Hash::make('adminn'),
        'first_name' => 'Admin',
        'last_name' => 'User',
        'phone' => null,
        'email' => 'admin@admin.admin',
        'street' => null,
        'city' => null,
        'postal_code' => null,
        'role' => 'admin',
      ]
    ];
    foreach ($users as $user) {
      DB::table('users')->insert(
        [
          ...$user,
          'created_at' => now(),
          'updated_at' => now()
        ]
      );
    }
  }
}

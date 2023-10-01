<?php

namespace Database\Seeders\tenant;

use App\Models\Tenant\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userList = [
            [
                'name' => fake()->name(),
                'email' => 'admin@mail.com',
            ]
        ];

        foreach ($userList as $key => $value) {
            $exists = User::where('email', $value['email'])->count();
            if (!$exists) {
                $user = User::create([
                    'name' => $value['name'],
                    'email' => $value['email'],
                    'password' => Hash::make('123456'),
                    'email_verified_at' => Carbon::now(),
                ]);
            }
        }
    }
}

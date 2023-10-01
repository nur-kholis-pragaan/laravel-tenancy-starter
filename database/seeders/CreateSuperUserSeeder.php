<?php

namespace Database\Seeders;

use App\Models\SuperUser;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateSuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userList = [
            [
                'name' => fake()->name(),
                'email' => 'superadmin@mail.com',
            ]
        ];

        foreach ($userList as $key => $value) {
            $exists = SuperUser::where('email', $value['email'])->count();
            if (!$exists) {
                $user = SuperUser::create([
                    'name' => $value['name'],
                    'email' => $value['email'],
                    'password' => Hash::make('123456'),
                    'email_verified_at' => Carbon::now(),
                ]);
            }
        }
    }
}

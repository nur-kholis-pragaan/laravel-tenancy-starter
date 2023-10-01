<?php

namespace Database\Seeders;

use Database\Seeders\Tenant\CreateConfigSeeder;
use Database\Seeders\tenant\CreateUserSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            CreateConfigSeeder::class,
            CreateUserSeeder::class,
        ]);
    }
}

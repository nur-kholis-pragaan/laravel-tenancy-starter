<?php

namespace Database\Seeders\Tenant;

use App\Models\Tenant\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'key' => 'APP_NAME',
                'value' => env('APP_NAME'),
            ],
        ];

        foreach ($data as $key => $value) {
            $exists = Config::where('key', $value['key'])->count();
            if (!$exists) {
                Config::create([
                    'key' => $value['key'],
                    'value' => $value['value'],
                ]);
            }
        }
    }
}

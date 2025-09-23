<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NutritionistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private static string $password;


    public function run(): void
    {
        self::$password = Hash::make('Rm@150917');

        $nutritionists = [
            [ 'user_type_id' => 2, 'name' => 'Nutricionista 01', 'phone' => '1234567890', 'email' => 'nutri01@gmail.com'],
            [ 'user_type_id' => 2, 'name' => 'Nutricionista 02', 'phone' => '9876543210', 'email' => 'nutri02@gmail.com'],

        ];

        foreach ($nutritionists as $data) {
            User::create([
                ...$data,
                'password' => self::$password,
            ]);
        }
    }
}

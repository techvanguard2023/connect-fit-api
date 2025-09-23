<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PersonalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private static string $password;

    public function run(): void
    {
        self::$password = Hash::make('Rm@150917');

        $personal = [
            [ 'user_type_id' => 1, 'name' => 'Personal 01', 'phone' => '1234567890', 'email' => 'personal01@gmail.com'],
            [ 'user_type_id' => 1, 'name' => 'Personal 02', 'phone' => '9876543210', 'email' => 'personal02@gmail.com'],

        ];

        foreach ($personal as $data) {
            User::create([
                ...$data,
                'password' => self::$password,
            ]);
        }
    }
}

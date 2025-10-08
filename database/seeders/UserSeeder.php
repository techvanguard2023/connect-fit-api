<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private static string $password;

    public function run(): void
    {
        self::$password = Hash::make('Rm@150917');

        $users = [
            [
                'name' => 'User 01',
                'phone' => '1234567890',
                'email' => 'user01@gmail.com',
                'age' => 25,
                'gender' => 'male',
                'goal_id' => 1,
            ],
            [
                'name' => 'User 02',
                'phone' => '9876543210',
                'email' => 'user02@gmail.com',
                'age' => 25,
                'gender' => 'female',
                'goal_id' => 2,
            ],

        ];

        foreach ($users as $data) {
            User::create([  
                ...$data,
                'password' => self::$password,
            ]);
        }
    }
}

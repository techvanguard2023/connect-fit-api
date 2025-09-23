<?php

namespace Database\Seeders;

use App\Models\Student;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private static string $password;

    public function run(): void
    {
        self::$password = Hash::make('Rm@150917');

        $students = [
            [
                'name' => 'Estudante 01',
                'phone' => '1234567890',
                'email' => 'estudante01@gmail.com',
                'age' => 25,
                'gender' => 'male',
                'goal_id' => 1,
            ],
            [
                'name' => 'Estudante 02',
                'phone' => '9876543210',
                'email' => 'estudante02@gmail.com',
                'age' => 25,
                'gender' => 'female',
                'goal_id' => 2,
            ],

        ];

        foreach ($students as $data) {
            Student::create([
                ...$data,
                'password' => self::$password,
            ]);
        }
    }
}

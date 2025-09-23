<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    private static string $password;

    public function run(): void
    {

        self::$password = Hash::make('Rm@150917');

        $employees = [
            ['name' => 'João da Silva', 'phone' => '1234567890', 'email' => 'joao@gmail.com', 'role' => 'admin'],
            ['name' => 'Maria Souza', 'phone' => '9876543210', 'email' => 'maria@gmail.com', 'role' => 'support'],

        ];

        foreach ($employees as $data) {
            Employee::create([
                ...$data,
                'password' => self::$password,
            ]);
        }

    }
}

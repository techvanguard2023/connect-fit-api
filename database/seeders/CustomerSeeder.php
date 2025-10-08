<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;



class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    protected static string $password;



    public function run(): void
    {
        self::$password = Hash::make('Rm@150917');

        Customer::create([
            'user_type_id' => 1,
            'stripe_customer_id' => 'cus_T6qu8Ffr4Aa7R5',	
            'name' => 'Robson Gomes Pedreira',
            'email' => 'masterdba6@gmail.com',
            'phone' => '21981321890',
            'password' => self::$password,
            'profile_picture' => 'https://media.licdn.com/dms/image/v2/D4D03AQG7x2GpWs2iCA/profile-displayphoto-shrink_800_800/profile-displayphoto-shrink_800_800/0/1687782341784?e=1762992000&v=beta&t=YCnfcHXswT2UWzmQH8Xnhjrgolv5rJrZfvCnw1UyU8g',
            'opt_in' => 1,
        ]);
    }
}

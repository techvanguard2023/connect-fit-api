<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CustomerAddress;

class CustomerAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CustomerAddress::create([
            'customer_id' => 5,
            'address' => 'Avenida José Mendonça de Campos',
            'number' => '402',
            'complement' => 'Apto 704 Bloco 02',
            'neighborhood' => 'Mutondo',
            'city' => 'São Gonçalo',
            'state' => 'RJ',
            'country' => 'Brasil',
            'zip_code' => '24451700',
            'latitude' => -23.550520,
            'longitude' => -46.633308,
        ]);
    }
}

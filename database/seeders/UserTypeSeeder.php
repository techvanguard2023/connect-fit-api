<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userTypes = [
            [
                'name' => 'Personal',
                'description' => 'Profissional responsável por elaborar e acompanhar treinos personalizados para os alunos.'
            ],
            [
                'name' => 'Nutricionista',
                'description' => 'Profissional especializado em orientar e montar planos alimentares para auxiliar nos objetivos dos alunos.'
            ],
            [
                'name' => 'Usuário',
                'description' => 'Usuário do sistema, que pode procurar por Personais para receber treinos ou Nutricionistas para receber orientações nutricionais.'
            ],
            [
                'name' => 'Funcionário',
                'description' => 'Usuário com acesso ao sistema, podendo gerenciar usuários, planos, etc.'
            ],
        ];

        foreach ($userTypes as $userType) {
            UserType::create($userType);
        }
    }

}

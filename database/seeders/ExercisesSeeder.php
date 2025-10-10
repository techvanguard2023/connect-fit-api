<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExercisesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $exercises = [
            // Peito - muscle_group_id 1
            ['name' => 'Supino reto (barra ou halteres)', 'muscle_group_id' => 1],
            ['name' => 'Supino inclinado (barra ou halteres)', 'muscle_group_id' => 1],
            ['name' => 'Supino declinado', 'muscle_group_id' => 1],
            ['name' => 'Crucifixo reto, inclinado ou declinado', 'muscle_group_id' => 1],
            ['name' => 'Paralelas (dips para peito)', 'muscle_group_id' => 1],
            ['name' => 'Flexão de braço (tradicional, inclinada, declinada, diamante)', 'muscle_group_id' => 1],
            ['name' => 'Cross over no cabo (alto, médio, baixo)', 'muscle_group_id' => 1],
            ['name' => 'Peck deck (voador peitoral)', 'muscle_group_id' => 1],
            ['name' => 'Pullover com halteres', 'muscle_group_id' => 1],
            ['name' => 'Flexão com pegada ampla', 'muscle_group_id' => 1],

            // Bíceps - muscle_group_id 4
            ['name' => 'Rosca direta (barra ou halteres)', 'muscle_group_id' => 4],
            ['name' => 'Rosca alternada', 'muscle_group_id' => 4],
            ['name' => 'Rosca concentrada', 'muscle_group_id' => 4],
            ['name' => 'Rosca Scott', 'muscle_group_id' => 4],
            ['name' => 'Rosca martelo', 'muscle_group_id' => 4],
            ['name' => 'Rosca inversa', 'muscle_group_id' => 4],
            ['name' => 'Rosca no banco inclinado', 'muscle_group_id' => 4],
            ['name' => 'Rosca no cabo baixo', 'muscle_group_id' => 4],

            // Panturrilha - muscle_group_id 7
            ['name' => 'Elevação em pé (livre, barra ou máquina)', 'muscle_group_id' => 7],
            ['name' => 'Elevação sentado', 'muscle_group_id' => 7],
            ['name' => 'Elevação unilateral em degrau', 'muscle_group_id' => 7],
            ['name' => 'Pular corda', 'muscle_group_id' => 7],

            // Ombro - muscle_group_id 3
            ['name' => 'Elevação lateral', 'muscle_group_id' => 3],
            ['name' => 'Elevação frontal', 'muscle_group_id' => 3],
            ['name' => 'Crucifixo inverso (voador invertido)', 'muscle_group_id' => 3],
            ['name' => 'Desenvolvimento com barra ou halteres, frente ou atrás', 'muscle_group_id' => 3],
            ['name' => 'Elevação lateral inclinada', 'muscle_group_id' => 3],
            ['name' => 'Arnold press', 'muscle_group_id' => 3],
            ['name' => 'Remada alta', 'muscle_group_id' => 3],

            // Costas - muscle_group_id 2
            ['name' => 'Barra fixa (supinada, pronada, neutra)', 'muscle_group_id' => 2],
            ['name' => 'Remada curvada (barra/haltéres)', 'muscle_group_id' => 2],
            ['name' => 'Remada unilateral (serrote)', 'muscle_group_id' => 2],
            ['name' => 'Remada baixa (cabo ou máquina)', 'muscle_group_id' => 2],
            ['name' => 'Puxada frente ou atrás (cabo)', 'muscle_group_id' => 2],
            ['name' => 'Puxador articulado', 'muscle_group_id' => 2],
            ['name' => 'Remada cavalinho (T-bar)', 'muscle_group_id' => 2],
            ['name' => 'Pulldown', 'muscle_group_id' => 2],
            ['name' => 'Peso morto', 'muscle_group_id' => 2],

            // Tríceps - muscle_group_id 5
            ['name' => 'Tríceps pulley (corda, barra, inverso)', 'muscle_group_id' => 5],
            ['name' => 'Tríceps testa', 'muscle_group_id' => 5],
            ['name' => 'Tríceps francês', 'muscle_group_id' => 5],
            ['name' => 'Tríceps coice', 'muscle_group_id' => 5],
            ['name' => 'Mergulho em banco ou paralela', 'muscle_group_id' => 5],
            ['name' => 'Flexão de braço pegada fechada', 'muscle_group_id' => 5],

            // Trapézio - muscle_group_id 8
            ['name' => 'Encolhimento de ombros', 'muscle_group_id' => 8],
            ['name' => 'Remada alta', 'muscle_group_id' => 8],
            ['name' => 'Levantamento terra', 'muscle_group_id' => 8],

            // Abdômen - muscle_group_id 9
            ['name' => 'Abdominal tradicional, infra, supra', 'muscle_group_id' => 9],
            ['name' => 'Abdominal oblíquo (twist, lateral)', 'muscle_group_id' => 9],
            ['name' => 'Elevação de pernas', 'muscle_group_id' => 9],
            ['name' => 'Prancha', 'muscle_group_id' => 9],
            ['name' => 'Bicicleta', 'muscle_group_id' => 9],
            ['name' => 'Abdominal canivete', 'muscle_group_id' => 9],
            ['name' => 'Ab roller', 'muscle_group_id' => 9],

            // Pernas - muscle_group_id 6
            ['name' => 'Agachamento livre (frontal, sumô)', 'muscle_group_id' => 6],
            ['name' => 'Leg press', 'muscle_group_id' => 6],
            ['name' => 'Cadeira extensora', 'muscle_group_id' => 6],
            ['name' => 'Mesa flexora', 'muscle_group_id' => 6],
            ['name' => 'Stiff (terra)', 'muscle_group_id' => 6],
            ['name' => 'Passada/lunge', 'muscle_group_id' => 6],
            ['name' => 'Afundo', 'muscle_group_id' => 6],
            ['name' => 'Step up', 'muscle_group_id' => 6],
            ['name' => 'Hack machine', 'muscle_group_id' => 6],

            // Glúteo - muscle_group_id 10
            ['name' => 'Elevação pélvica/Glute bridge', 'muscle_group_id' => 10],
            ['name' => 'Cadeira abdutora', 'muscle_group_id' => 10],
            ['name' => 'Agachamento sumô', 'muscle_group_id' => 10],
            ['name' => 'Avanço', 'muscle_group_id' => 10],

            // Antebraço - muscle_group_id 11
            ['name' => 'Rosca inversa', 'muscle_group_id' => 11],
            ['name' => 'Rosca punho', 'muscle_group_id' => 11],
            ['name' => 'Farmer’s walk', 'muscle_group_id' => 11],
        ];

        DB::table('exercises')->insert($exercises);
    }
}

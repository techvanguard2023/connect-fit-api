<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MuscleGroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $muscleGroups = [
            ['name' => 'Peito', 'description' => 'Músculos peitorais responsáveis pela movimentação do braço para frente e para dentro.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2020/04/chest.jpg', 'color' => '#FFD700'],
            ['name' => 'Costas', 'description' => 'Músculos das costas que auxiliam na postura e movimentos de puxar.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2020/04/upperback.jpg', 'color' => '#FF4500'],
            ['name' => 'Ombros', 'description' => 'Deltoides e músculos ao redor que controlam movimentos do braço e ombro.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2020/04/shoulders_0.jpg', 'color' => '#FFA500'],  
            ['name' => 'Bíceps', 'description' => 'Músculos frontais do braço responsáveis pela flexão do cotovelo.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2020/04/biceps_0.jpg', 'color' => '#FF4500'],
            ['name' => 'Tríceps', 'description' => 'Músculos posteriores do braço que estendem o cotovelo.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2020/04/triceps.jpg', 'color' => '#FFA500'],
            ['name' => 'Pernas', 'description' => 'Quadríceps, posteriores e outros músculos das coxas para movimentos de suporte e locomoção.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2020/04/pernas.jpg', 'color' => '#FF4500'],
            ['name' => 'Panturrilha', 'description' => 'Músculos da parte inferior da perna importantes para a flexão do pé.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2020/04/calves_0.jpg', 'color' => '#FF4500'],
            ['name' => 'Trapézio', 'description' => 'Músculos da parte superior das costas que movem, estabilizam e giram a escápula.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2020/04/trap.jpg', 'color' => '#FFA500'],
            ['name' => 'Abdômen', 'description' => 'Músculos centrais do tronco responsáveis pela estabilidade e flexão do corpo.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2020/04/abs_0.jpg', 'color' => '#FF4500'],
            ['name' => 'Glúteos', 'description' => 'Músculos das nádegas que ajudam na extensão e rotação do quadril.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2024/09/glutes_0.jpg', 'color' => '#FF4500'],
            ['name' => 'Antebraço', 'description' => 'Músculos do braço inferior responsáveis pelos movimentos do pulso e dedos.', 'image' => 'https://www.hipertrofia.org/blog/wp-content/uploads/2024/09/forearms_0-392x245.jpg', 'color' => '#FFA500'],
        ];

        DB::table('muscle_groups')->insert($muscleGroups);
    }
}

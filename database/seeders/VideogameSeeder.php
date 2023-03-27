<?php

namespace Database\Seeders;

use App\Models\Videogame;
use Faker\Generator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VideogameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(Generator $faker): void
    {
        $platforms = ['PC', 'Xbox', 'PlayStation', 'Switch'];

        for ($i = 0; $i < 10; $i++) {
            $videogame = new Videogame();
            $videogame->title = $faker->words(3, true);
            $videogame->description = $faker->paragraph();
            $videogame->img_url = $faker->imageUrl(300, 300);
            $videogame->platform = $faker->randomElement($platforms);
            $videogame->pegi = $faker->numberBetween(6, 18);
            $videogame->producer = $faker->company();
            $videogame->vote = $faker->numberBetween(0, 5);
            $videogame->save();
        }
    }
}

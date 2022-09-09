<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Post;
use Illuminate\Support\Str;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for($i = 0; $i < 10; $i++) {
            //creo un nuovo post (per 10 volte)
            $new_post = new Post();

            //compilo title e content
            //con ucfirst trasformo la prima lettera del title da minuscolo a maiuscolo
            $new_post->title = ucfirst($faker->words(rand(2, 7), true));
            $new_post->content = $faker->paragraph(rand(5, 12), true);
            $new_post->slug = Str::slug($new_post->title, '-');
            $new_post->save();
        }
    }
}

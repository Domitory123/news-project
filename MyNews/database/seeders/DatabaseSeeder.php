<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Services\NewsService;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       
       $tags = \App\Models\Tag::factory(150)->create();
       $News = \App\Models\News::factory(50)->create();
      
       foreach ($News as $singleNews) {
        NewsService::addTagsforNewtextforFactory($singleNews);
      }
    //    $News->each(function ($news) use ($tags) {
    //     $tagIds = $tags->random(3)->pluck('id');
    //     $news->tags->attach($tagIds);
    //  });
    }
}

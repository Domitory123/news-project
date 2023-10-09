<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> $this->faker->sentence,
            'text'=>  $this->faker->paragraphs(3, true),
            'photo'=> 'public/photo/1.png',
        ];
    }

    // public function configure()
    // {
    //     return $this->afterCreating(function (News $news) {
    //         $tagsCount = $this->faker->numberBetween(1, 5); // Виберіть бажану кількість тегів.
    //         Tag::factory($tagsCount)->create(['news_id' => $news->id]);
    //     });
    // }
}

<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence();
        $slug = Str::slug($title, '-');
        $date = $this->faker->dateTimeThisMonth();

        return [
            'created_at' => $date,
            'updated_at' => $date,

            'en' => [
                'title' => $title,
                'slug' => $slug,
                'content' => $this->faker->realText(500),
                'excerpt' => $this->faker->realText(150),
            ],
            'de' => [
                'title' => $title,
                'slug' => $slug,
                'content' => $this->faker->realText(500),
                'excerpt' => $this->faker->realText(150),
            ],
        ];
    }
}

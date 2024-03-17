<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;
 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\odel=Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->jobTitle;
        $created_at = now()->subDays(rand(1, 30));

        $content = ''; // lets generate some real html

        for ($i = 0; $i < 5; $i++) {
            $content .= '<p class="mb-4">' . $this->faker->sentences(rand(5,10),asText:true) . '</p>';
        }
        return [
            'title' => $title,
            'user_id' => User::factory(),//cascade through the user model
            'slug' => Str::slug($title)."-" . $this->faker->unique()->numberBetween(1, 100),
            'company' => $this->faker->company,
            'location' => $this->faker->address,
            'logo' => basename($this->faker->image(storage_path('app/public'), 100, 100, null, false)),
            'is_highlighted' => (rand(0,9) > 7 ? true : false),
            'is_active' => true,
            'content' => $content,
            'apply_link' => $this->faker->url,
            'created_at' => $created_at ,
            'updated_at' => $created_at->addDays(rand(1, 5)),
        ];
    }
}

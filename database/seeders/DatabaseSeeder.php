<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Listing;
use App\Models\User;
use App\Models\Tag;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //\App\Models\User::factory(10)->create();

        User::factory()->create([
            'name' => 'Joe',
            'email' => 'joe.hunter.dev@gmail.com',
            'password' => Hash::make('123456')
        ]);


        $tags = Tag::factory(10)->create();

        //Loop through the users and create listings for each user
        //Tags,attach,random 
        User::factory(20)->create()->each(function ($user) use ($tags) {
            Listing::factory(rand(1, 3))->create(['user_id' => $user->id,])->each(function ($listing) use ($tags) {
                $listing->tags()->attach($tags->random(rand(1, 3)));
            });
        });
    }
}

# Job Board

## Setup db

## Models + Migrations

php artisan make:model Listing -m
php artisan make:model Clicks -m
php artisan make:model Tag - m

## Relationships:

Tags and Listings = many to many uses model names in alfabetical order which is the laravel convention. We will need a pivot table

php artisan make:migration create_listing_tag_table



## 2. Models

## Factories

php artisan make:factory TagFactory -model=Tag
laravel_jobsphp artisan make:factory ListingFactory -model=Listing

*for Listing user id relations create a seeder that runs through user creation and passes id*

```
User::factory(10)->create()->each(function ($user) {
    Listing::factory(rand(1,3))->create(['user_id' => $user->id]);
}); 
 
```

*when seeding tags you can use each->closure with eloquent tags method tags()->attach(rand(1,10)) with use to pass in a collection of tags*



```
//Tags,attach,random 
User::factory(20)->create()->each(function ($user) use ($tags) {
    Listing::factory(rand(1, 3))->create(['user_id' => $user->id])->each(function ($listing) use ($tags) {
        $listing->tags()->attach($tags->random(rand(1, 3)));
    });
});
```

*attach() is used in many to many*

load these objects into your seeder 

## Notes

`dcr can be used for docker compose run`

- homestead is an environment for laravel
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

## Dependancies 
composer require laravel/ui --dev
php artisan ui bootstrap 
php artisan ui bootstrap --auth
npm install && npm run dev #compile assets

Auth::routes(); in web.php should be enough for your defaults
Auth::routes(['register' => false]);// is a way to disable from default
if we wanted to auth emails we could using  implements MustVerifyEmail
composer require laravel/cashier
with billable trait in User Model
then you will need to add stripe key and secret into env
composer requuire erusev/parsedown-extra


## Notes

`dcr can be used for docker compose run`

- homestead is an environment for laravel
- tailwind may work slighty better with react, slightly better with mobile

# Job Board

## Setup db

## 1. Models + Migrations

`php artisan make:model Listing -m`
`php artisan make:model Clicks -m`
`php artisan make:model Tag -m`

## Relationships:

- Tags and Listings = many to many uses model names in alfabetical order which is the laravel convention. We will need a pivot table

`php artisan make:migration create_listing_tag_table`



## 2. Models

## Factories

- `php artisan make:factory TagFactory -model=Tag`
- `laravel_jobsphp artisan make:factory ListingFactory -model=Listing`

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

- *`attach()` is used in many to many*

- load these objects into your seeder 

## 3. Dependancies 

`composer require laravel/ui --dev`
`php artisan ui bootstrap`
`php artisan ui bootstrap --auth`
`npm install && npm run dev` #compile assets


- `Auth::routes();` in web.php should be enough for your defaults
- `Auth::routes(['register' => false]);// ` is a way to disable from default
- if we wanted to auth emails we could using  implements MustVerifyEmail

`composer require laravel/cashier`

with **Billable** trait in User Model
then you will need to add stripe key and secret into env

`composer require erusev/parsedown-extra`


## 4. Front Page
- Lets overwrite our default route
`php artisan make:controller ListingController`
- return data and view in index 

- in our listing view we can now use our blade components
- you can now use components and include them with `<x-whatever>`
- additionally you can use `<x-app-layout>` on your listings index to leverage the existing app layout
- lets also pull in tags into listing controller
- `@extend()`
- `@section() ` in your outer templates
- inline active can be done like this {{ $tag->slug === request()->get('tag') ? 'btn-primary' : 'btn-secondary' }}
- `php artisan storage:link`
- add a search function to pass param s
- detect this in controller and return

- To record clicks lets create a new apply method. and associate clicks with that listing

## 5. Listing page

- Parse to variable route to variable `/{listing}`
    - Model Route Binding: `public function show(Listing $listing, Request $request)`
    - Laravel will expect the id of object by default
- To get round this issue we can modify the model and create a `getRouteKeyName() : slug` on the parent class to *bind the key name to object* this is the col in db
- `{!!$listing->content!!}`

- To track click we need to create a new controller method, and pass the associated header in `$clicks->create()`
- Then redirect
- This needs to be mapped to apply link via route
- `<a href="{{ route('listings.apply', $listing->slug) }}" class="btn btn-primary">Apply Now</a>`

- Parser.php which browser could be usefull for tracking

## 6. Purchase Listing
- Include js directly in blade view
- use `$request->validate `
    - 2 steps allowing for user thats already logged 
- try catch block
- hook into stripe and do charge with options
- Test The Flow
    - Form requires redirect be weary of configurables

 - When creating a new listing its done of the user object `$listing = $user->listings()`

## 7. Employer Dashboard
- We now need to pass listing param to view
- 
## Notes

- *dcr can be used for docker compose run*
- homestead is an environment for laravel
- tailwind may work slighty better with react, slightly better with mobile

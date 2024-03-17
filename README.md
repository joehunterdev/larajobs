# Job Board

## Setup db

## Models + Migrations

php artisan make:model Listing -m
php artisan make:model Clicks -m
php artisan make:model Tags - m

## Relationships:

Tags and Listings = many to many uses model names in alfabetical order which is the laravel convention. We will need a pivot table

php artisan make:migration create_listing_tag_table
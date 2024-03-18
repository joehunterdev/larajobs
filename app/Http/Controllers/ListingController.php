<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Listing;
use Illuminate\Support\Str;

class ListingController extends Controller
{
    public function index(Request $request)
    {
        $listings = Listing::where('is_active', true)->latest()->orderBy('is_highlighted', 'asc')->get();

        $query = strtolower($request->get("s"));

        $tags = Tag::orderBy('name')->get();

        if ($request->has('tag')) {
            $tag = $request->get('tag');
            $listings = $listings->filter(function ($listing) use ($tag) {
                return $listing->tags->contains('slug', $tag);
            });
        }


        if ($request->has("s")) {


            $listings = $listings->filter(
                function ($listing) use ($query) {

                    if (Str::contains(strtolower($listing->title), strtolower($query))) {
                        return true;
                    }


                    if (Str::contains(strtolower($listing->company), strtolower($query))) {
                        return true;
                    }


                    if (Str::contains(strtolower($listing->location), strtolower($query))) {
                        return true;
                    }


                    if (Str::contains(strtolower($listing->description), strtolower($query))) {
                        return true;
                    }

                    return false;
                }
            );



        }


        return view('listings.index', compact('listings', 'tags'));

    }

    //Use Model Binding to get the listing  
    public function show(Listing $listing, Request $request)
    {
       // return $listing;
        return view('listings.show', compact('listing'));
    }

    //Create associated click data and redirect
    public function apply(Listing $listing, Request $request)
    {
         $listing->clicks()->create(
            [
                'user_agent' => $request->userAgent(),
                'ip' => $request->ip()
            ]
         );


         return redirect()->to('home');
         
    }
}

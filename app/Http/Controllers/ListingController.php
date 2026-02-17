<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Listing;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use ParsedownExtra;

class ListingController extends Controller
{
    protected $options =  [
        "automatic_payment_methods[enabled]" => true,
        "automatic_payment_methods[allow_redirects]" => 'never'
    ];

    public function create()
    {
        return view('listings.create');
    }

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


    public function store(Request $request)
    {
        // Validation and other code...



        $validationArr = [
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'content' => 'required',
            'apply_link' => 'required',
            'is_highlighted' => 'required',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];

        //lets do additonal check first if not authenticated
        if (!Auth::check()) {

            $validationArr = array_merge($validationArr, [
                'email' => 'required|email|unique:users',
                'name' => 'required',
                'password' => 'required|confirmed',
            ]);
        }

        request()->validate($validationArr);
        $user = Auth::user();

        //Create user on the fly
        if (!$user) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
        }
        //Hook into billable
        $user->createAsStripeCustomer();
+
        //Auth user
        Auth::login($user);

        //Process payment and place listing
        try {
            $amount = 9900;
            $amount += $request->is_highlighted ? 1900 : 0;  //EUR 19.00
            //charge method

            /*  \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $options = [
                // "amount" => $amount, // amount in cents
                // "currency" => "EUR",
                // // 'payment_method_types' => ['card'],
                // 'payment_method' => $request->payment_method_id,
                // 'confirmation_method' => 'manual',
                // 'confirm' => true,
                // 'return_url' => route('dashboard'), // Replace with your actual return URL
                "amount" => $amount, // amount in cents
                "currency" => "EUR",
                'payment_method' => $request->payment_method_id,
                'confirm' => true,
                'automatic_payment_methods' => [
                    'enabled' => true,
                    'allow_redirects' => 'never',
                ],
            ];

            $paymentIntent = \Stripe\PaymentIntent::create($options);
            //id holds the cc info we jsut pass id
            $user->charge($amount, $request->payment_method_id);
           */
            //md content
            $md = new ParsedownExtra();
            //$logoPath = $request->file('logo')->storeAs('public', $request->file('logo')->getClientOriginalName());
            $listing = $user->listings()
            ->create([
                'title' => $request->title,
                'slug' => Str::slug($request->title) . '-' . rand(1111, 9999),
                'company' => $request->company,
                //'logo' => basename($request->file('logo')->store('public')),
                'location' => $request->location,
                'apply_link' => $request->apply_link,
                'content' => $md->text($request->input('content')),
                'is_highlighted' => $request->filled('is_highlighted'),
                'is_active' => true
            ]);

            foreach (explode(',', $request->tags) as $requestTag) {
                $tag = Tag::firstOrCreate(
                    ['slug' => Str::slug(trim($requestTag))],
                    ['name' => ucwords(trim($requestTag))]
                );

                //sets relationip between tags passed and listing created
                $tag->listings()->attach($tag);
            }
            $listing->save();

            //\Stripe\PaymentIntent::create($options);

            return redirect()->route('dashboard', $listing->slug)->with('success', 'Listing created');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withErrors(['error' => $e->getMessage()]);
        }
    }
}

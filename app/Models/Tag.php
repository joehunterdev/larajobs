<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = []; // no prortected fields

    public function listings()
    {
        return $this->belongsToMany(related: Listing::class); //Tag belongs to many Listings
    }
}

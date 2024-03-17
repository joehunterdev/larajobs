<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $guarded = []; // This is a temporary fix to allow mass assignment

    public function clicks(){

        return $this->hasMany(related:Click::class);    //Listing has many CLicks

    }


    public function user(){

        return $this->belongsTo(related:User::class);     // Listing belongs to User

    }

    public function tags(){
        return $this->belongsToMany(related:Tag::class);  //Listing belongs to many Tags <-tags belongs to many listings || hasMany-->
    }
}

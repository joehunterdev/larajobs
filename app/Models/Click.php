<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;

    protected $guarded = [];  
    
    //1 relationship
    public function listing(){

        return $this->belongsTo(related:Listing::class); //Click belongs to Listing

    }
}

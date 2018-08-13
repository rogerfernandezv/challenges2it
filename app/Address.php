<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
    	'name',
    	'address',
    	'city',
    	'country',
    	'people_id'
    ];
}

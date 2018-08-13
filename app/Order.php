<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

	protected $fillable = [
		'people_id',
		'address_id'
	];

	/**
     * Append links attribute.
     *
     * @var array
     */
    protected $appends = ['_links'];

    /**
     * Get address from address_id
     *
     * @return App\Product
     */
    public function products(){
    	return $this->belongsToMany('App\Product');
    }

    /**
     * Get address from address_id
     *
     * @return App\Address
     */
    public function address(){
    	return $this->hasOne('App\Address', 'id', 'address_id');
    }

    /**
     * Get address from address_id
     *
     * @return App\People
     */
    public function people(){
    	return $this->hasOne('App\People', 'id', 'people_id');
    }

    /**
     * Set attributes links
     *
     * @return array
     */
    public function getLinksAttribute()
    {
        return [
            'self' => app()->make('url')->to("api/order/{$this->attributes['id']}")
        ];
    }
}

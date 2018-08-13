<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class People extends Model
{
	protected $table = 'peoples';

    protected $fillable = [
    	'name',
    	'phone'
    ];

    /**
     * Get address from address_id
     *
     * @return App\Address
     */
    public function address(){
    	return $this->hasMany('\App\Address');
    }

    /**
     * Append links attribute.
     *
     * @var array
     */
    protected $appends = ['_links'];
    
    /**
     * Set attributes links
     *
     * @return array
     */
    public function getLinksAttribute()
    {
        return [
            'self' => app()->make('url')->to("api/people/{$this->attributes['id']}")
        ];
    }
}

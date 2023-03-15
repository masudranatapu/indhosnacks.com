<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    protected $table = 'food_menu';
    protected $primaryKey = 'id';
    protected $appends = ['average_rating'];

    public function categoryitem()
    {
        return $this->hasOne('App\Category', 'id', 'category');
    }

    public function ingredient()
    {
        return $this->hasMany('App\Ingredient', 'menu_id', 'id');
    }



    public function ratings()
    {
        return $this->hasMany(Review::class, 'item_id');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->ratings()->average('stars'), 2);
    }
}

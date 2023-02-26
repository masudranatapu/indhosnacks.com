<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'food_category';
    protected $primaryKey = 'id';

    public function ingredient()
    {
        return $this->hasMany('App\Ingredient', 'category', 'id');
    }
}
?>

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory,HasEagerLimit;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'is_active',
    ];



    protected $hidden = ['pivot'];

    public function products()
    {
        return $this->belongsToMany(Product::class,'product_categories','category_id','product_id');
    }


}

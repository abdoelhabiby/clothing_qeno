<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory , SoftDeletes,HasEagerLimit;

    protected $hidden = ['pivot'];

    protected $fillable = [

        'name',
        'sku',
        'slug',
        'quantity',
        'price',
        'image',
        'is_active',
        'vendor_id'
    ];



    public function vendor()
    {
        return $this->belongsTo(Admin::class,'vendor_id','id');
    }



    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');

    }


}

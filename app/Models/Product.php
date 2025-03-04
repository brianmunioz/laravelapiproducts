<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name','price','quantity','variant'];

    public function images():HasMany
    {
        return $this->hasMany(Image::class,'product_id','id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function purchase(){
        return $this->hasMany(Purchase::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function store(){
        return $this->hasMany(Store::class);
    }
    public function sale(){
        return $this->hasMany(Sale::class);
    }
}

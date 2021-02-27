<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function bill(){
        return $this->belongsTo(bill::class);
    }
    public function store(){
        return $this->belongsTo(Store::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}


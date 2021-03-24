<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }
    public function PurchaseBill(){
        return $this->belongsTo(PurchaseBill::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function brand(){
        return $this->belongsTo(Brand::class);
    }
    public function unit(){
        return $this->belongsTo(Unit::class);
    }
    
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function purchaseDue(){
        return $this->hasMany(PurchaseDue::class);
    }
}

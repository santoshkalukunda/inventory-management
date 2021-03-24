<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseBill extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function dealer(){
        return $this->belongsTo(Dealer::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function purchase(){
        return $this->hasMany(Purchase::class);
    }
    public function purchaseDue(){
        return $this->hasMany(PurchaseDue::class);
    }
}

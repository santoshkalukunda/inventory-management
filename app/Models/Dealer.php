<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dealer extends Model
{
    use HasFactory;

protected $guarded=['id'];

public function purchase(){
    return $this->hasMany(Purchase::class);
}
public function purchaseDue(){
    return $this->hasMany(PurchaseDue::class);
}
}

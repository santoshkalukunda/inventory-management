<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDue extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    
    public function dealer(){
        return $this->belongsTo(dealer::class);
    }
    public function purchase(){
        return $this->belongsTo(purchase::class);
    }
    public function PurchaseBill(){
        return $this->belongsTo(PurchaseBill::class);
    }
}

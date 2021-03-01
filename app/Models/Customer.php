<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    
    public function purchase(){
        return $this->hasMany(Purchase::class);
    }

    public function bill(){
        return $this->hasMany(Bill::class);
    }

    public function sale(){
        return $this->hasMany(Sale::class);
    }
    public function saleDeu(){
        return $this->hasMany(SaleDue::class);
    }
}

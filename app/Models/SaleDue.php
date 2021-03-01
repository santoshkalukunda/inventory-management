<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDue extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function bill(){
        return $this->belongsTo(bill::class);
    }
}

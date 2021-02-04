<?php

namespace App\Http\Livewire;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Dealer;
use App\Models\Product;
use App\Models\Unit;
use Livewire\Component;

class PurchaseForm extends Component
{
    public $purchase;
    public $dealer;
    public $products;
    public $categories;
    public $brands;
    public $units;
    public $rate, $quantity,$total;
    protected $rules = [
        'purchase.name' => 'required',
    ];

    public function mount(Dealer $dealer)
    {
        $this->dealer = $dealer;
        $this->products = Product::get();
        $this->categories = Category::get();
        $this->brands = Brand::get();
        $this->units = Unit::get();
    }
    public function render()
    {
        if($this->rate != null or $this->quantity != null){
           
            $this->total=$this->rate + $this->quantity;
        }else{
            $this->rate = 0; 
            $this->quantity=0;
        }
        return view('livewire.purchase-form');
    }
}

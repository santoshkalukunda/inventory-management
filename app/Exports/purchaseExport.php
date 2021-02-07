<?php

namespace App\Exports;

use App\Models\Purchase;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class purchaseExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Purchase::all();
    }
    public function headings(): array
    {
        return [
            'id',
            'order_date',
            'shipping_date',
            'bill_no',
            'product',
            'dealer',
            'category',
            'brand',
            'model_no',
            'serial_no',
            'batch_no',
            'mf_date',
            'exp_date',
            'quantity',
            'unit',
            'rate',
            'discount',
            'vat',
            'total',
            'payment',
            'due',
            'mrp',
            'details',
            'created_at',
            'updated_at',
        ];
    }
}

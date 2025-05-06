<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'pr_id', 'product_id','product_name', 'quantity', 'uom', 'buying_price', 'selling_price'
    ];

    public function pr()
    {
        return $this->belongsTo(Pr::class);
    }
}
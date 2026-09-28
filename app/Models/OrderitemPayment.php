<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Business\MyBusiness;
use App\Models\Product;

class OrderitemPayment extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }

    public function business()
    {
        return $this->belongsTo(MyBusiness::class, 'product_id');
    }
}

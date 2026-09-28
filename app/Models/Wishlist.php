<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Business\MyBusiness;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_id',
    ];

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function businessProduct()
    {
        return $this->belongsTo(MyBusiness::class,'product_id');
    }
}

<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Business\RatingBusiness;

class MyBusiness extends Model
{
    use HasFactory;


  protected $fillable = [
    'image_one',
    'image_two',
    'image_three',
    'image_four',
    'category',
    'product_name',
    'product_quantity',
    'product_description',
    'price',
    'status',
    'user_id',
    'phone',
    'email',
    'name',
    'village',
    'road',
    'district',
    'police_station',
    'post_office',
    'country',
    'post_code',
    'personal_description',
    'payment_gateway',
    'store_id',
    'store_password',
    'bkash_number',
    'bank_name',
    'bank_account',
    'bank_routing',
];

    public function ratings()
    {
        return $this->hasMany(RatingBusiness::class, 'prod_id');
    }
}

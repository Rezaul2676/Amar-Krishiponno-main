<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerBuyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'business_id',
        'product_name',
        'buyer_id',
        'buyer_name',
        'buyer_email',
        'buyer_phone',
        'buyer_address',
        'buyer_state',
        'buyer_post_code',
        'quantity',
        'amount',
        'transaction_id',
        'payment_status',
        'notes',
        'fraud_score',
        'fraud_status',
        'buyer_ip',
        'payment_gateway',
        'payment_metadata',
    ];

    protected $casts = [
        'payment_metadata' => 'array',
    ];

    // Relationships
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function business()
    {
        return $this->belongsTo('App\Models\Business\MyBusiness', 'business_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [

        // day, month, year
        'day',
        'month',
        'year',

        // Customer information
        'customer_name',
        'phone_number',
        'email',
        'customer_address',

        // Purchase information
        'purchase_date',
        'product_details',
        'imei_number',
        'customer_id_proof',

        // Payment information
        'payment_method',
        'purchase_amount',

        // Category info
        'category',
        'sub_category',

        // shop & branch
        'company',
        'branch',
    ];
}

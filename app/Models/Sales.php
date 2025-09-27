<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = [
        'sales_date',
        'day',
        'month',
        'year',
        'cash_sales',
        'card_sales',
        'techpoint_sales',
        'tiktech_sales',
        'daily_total',
        'company',
        'branch',
    ];
}

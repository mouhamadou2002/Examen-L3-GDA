<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'order_id', 'invoice_number', 'pdf_path'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
} 
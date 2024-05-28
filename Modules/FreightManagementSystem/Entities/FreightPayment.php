<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FreightPayment extends Model
{
    use HasFactory;

    protected $table = "freight_payments";
    protected $fillable = [
        'invoice_id',
        'date',
        'amount', 
        'description',
        'reference',
        'add_receipt',
        'workspace', 
        'created_by', 
    ];
    
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightPaymentFactory::new();
    }
}

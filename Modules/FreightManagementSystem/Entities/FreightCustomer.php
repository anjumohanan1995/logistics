<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FreightCustomer extends Model
{
    use HasFactory;

    protected $table ='freight_customers';
    protected $fillable = ['user_id','name','email','workspace','created_by'];
    
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightCustomerFactory::new();
    }
}

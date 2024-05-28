<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FreightPrice extends Model
{
    use HasFactory;
    protected $table ='freight_prices';
    protected $fillable = ['name','volume_price','weight_price','service_price','workspace','created_by'];
    
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightPriceFactory::new();
    }
}

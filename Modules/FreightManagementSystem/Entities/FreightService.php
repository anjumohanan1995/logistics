<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FreightManagementSystem\Entities\FreightShippingService;
class FreightService extends Model
{
    use HasFactory;

    protected $table = "freight_services";
    protected $fillable = [
        'name',
        'sale_price', 
        'cost_price',
        'workspace', 
        'created_by', 
    ];
    
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightServiceFactory::new();
    }
}

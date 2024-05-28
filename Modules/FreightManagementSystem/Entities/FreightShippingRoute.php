<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FreightShippingRoute extends Model
{
    use HasFactory;

    protected $table = "freight_shipping_routes";
    protected $fillable = [
        'shipping_id',
        'route_operation', 
        'source_location',
        'destination_location',
        'transport',
        'send_date',
        'received_date',
        'cost_price',
        'sale_price',
        'workspace', 
        'created_by', 
    ];
    
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightShippingRouteFactory::new();
    }
}

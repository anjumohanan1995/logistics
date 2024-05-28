<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FreightManagementSystem\Entities\FreightService;
class FreightShippingService extends Model
{
    use HasFactory;

    protected $table = "freight_shipping_services";
    protected $fillable = [
        'shipping_id',
        'route_id',
        'vendor', 
        'service',
        'qty',
        'sale_price',
        'cost_price',
        'workspace', 
        'created_by', 
    ];
    public function serviceDetail()
    {
        return $this->hasOne(FreightService::class, 'id', 'service');
    }
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightShippingServiceFactory::new();
    }
}

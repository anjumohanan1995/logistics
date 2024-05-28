<?php

namespace Modules\FreightManagementSystem\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\FreightManagementSystem\Entities\FreightContainer;
class FreightShippingOrder extends Model
{
    use HasFactory;

    protected $table = "freight_shipping_orders";
    protected $fillable = [
        'shipping_id',
        'container_id', 
        'pricing_id',
        'description',
        'bill_on',
        'weight',
        'volume', 
        'price', 
        'sale_price', 
        'workspace', 
        'created_by', 
    ];
    public function container()
    {
        return $this->hasOne(FreightContainer::class, 'id', 'container_id');
    }
    protected static function newFactory()
    {
        return \Modules\FreightManagementSystem\Database\factories\FreightShippingOrderFactory::new();
    }
}

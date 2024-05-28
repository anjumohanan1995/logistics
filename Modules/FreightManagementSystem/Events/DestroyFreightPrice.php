<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class DestroyFreightPrice
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $price;

    public function __construct($price)
    {
        $this->price = $price;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}

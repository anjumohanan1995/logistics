<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class DestroyFreightShipping
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $shipping;
    public function __construct($shipping)
    {
        $this->shipping = $shipping;
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

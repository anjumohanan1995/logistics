<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class DestroyFreightCustomer
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $customer;

    public function __construct($customer)
    {
        $this->customer = $customer;
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

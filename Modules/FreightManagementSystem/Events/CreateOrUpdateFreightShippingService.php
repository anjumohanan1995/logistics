<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class CreateOrUpdateFreightShippingService
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $shipping;
    public $service;
    public function __construct($request ,$shipping ,$service)
    {
        $this->request = $request;
        $this->shipping = $shipping;
        $this->service = $service;
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

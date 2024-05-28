<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class UpdateFreightPrice
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $request;
    public $price;

    public function __construct($request ,$price)
    {
        $this->request = $request;
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

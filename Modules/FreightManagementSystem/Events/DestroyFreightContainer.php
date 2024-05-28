<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class DestroyFreightContainer
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $container;

    public function __construct($container)
    {
        $this->container = $container;
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

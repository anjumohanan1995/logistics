<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class DestroyFreightBookingRequest
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $booking_request;
    public function __construct($booking_request)
    {
        $this->booking_request = $booking_request;
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

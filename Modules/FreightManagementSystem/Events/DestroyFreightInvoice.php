<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class DestroyFreightInvoice
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $invoice;

    public function __construct($invoice)
    {
        $this->invoice = $invoice;
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

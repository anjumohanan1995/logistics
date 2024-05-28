<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class CreateFreightShippingInvoice
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $shipping;
    public $invoice;
    public function __construct($shipping ,$invoice)
    {
        $this->shipping = $shipping;
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

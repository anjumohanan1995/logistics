<?php

namespace Modules\FreightManagementSystem\Events;

use Illuminate\Queue\SerializesModels;

class FrieghtPaymentDestroyInvoice
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $payment;
    public $invoice;
    public function __construct($invoice,$payment)
    {
        $this->payment = $payment;
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

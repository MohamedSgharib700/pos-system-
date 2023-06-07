<?php

namespace App\Events;

use App\Models\Manager;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ManagerActivited
{
    use Dispatchable, SerializesModels;
    public $manager;
    public $commercial_registration_number;
    public $tax_number;
    public $company_name;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Manager $manager,$commercial_registration_number, $tax_number, $company_name)
    {
        $this->manager = $manager;
        $this->commercial_registration_number = $commercial_registration_number;
        $this->tax_number = $tax_number;
        $this->company_name = $company_name;
    }

}

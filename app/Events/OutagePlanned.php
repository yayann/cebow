<?php

namespace App\Events;

use App\Entities\Outage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class OutagePlanned
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var Outage
     */
    public $outage;

    /**
     * OutagePlanned constructor.
     * @param Outage $outage
     */
    public function __construct(Outage $outage)
    {
        $this->outage = $outage;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

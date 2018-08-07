<?php

namespace App\Events;

use App\Entities\Outage;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserLocationMatch implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  User */
    public $user;

    /** @var Outage */
    public $outage;

    /**
     * UserLocationMatch constructor.
     * @param User $user
     * @param Outage $outage
     */
    public function __construct(User $user, Outage $outage)
    {
        $this->user = $user;
        $this->outage = $outage;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('user.' . $this->user->id);
    }
}

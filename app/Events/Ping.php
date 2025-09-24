<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Ping
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public string $message) {}

    public function broadcastOn(): Channel
    {
        return new Channel('public-test');
    }

    // opcional: define o nome curto do evento
    public function broadcastAs(): string
    {
        return 'Ping';
    }

    public function broadcastWith(): array
    {
        return ['message' => $this->message];
    }
}

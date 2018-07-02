<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class LogEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $request = null;

    /**
     * LogEvent constructor.
     * @param Request $request
     */
    public function __construct(Request $request){
        $this->request = $request;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn(){

        return new PrivateChannel('channel-name');
    }
}

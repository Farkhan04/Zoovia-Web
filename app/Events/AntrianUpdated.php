<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class AntrianUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $action;
    public $antrian;
    public $queueSummary;

    /**
     * Create a new event instance.
     *
     * @param string $action Tindakan yang dilakukan (create, update, delete)
     * @param mixed $antrian Data antrian yang diubah
     * @return void
     */

    public function __construct($action, $antrian, $queueSummary)
    {
        $this->action = $action;
        $this->antrian = $antrian;
        $this->queueSummary = $queueSummary;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('antrian');
    }


}
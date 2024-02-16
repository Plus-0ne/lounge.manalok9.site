<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

use App\Models\Users\MembersModel;

class MessengerNotifyUser implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $data;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $data)
    {
        return $this->data = $data;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('messenger.notify.user.'.$this->data['receiver_uuid']);
    }
    public function broadcastWith() {
        if ($this->data['type'] == 'new_message_user_notify') {
            /* Message notification */

            /* Get Sender details */
            $sender_details = MembersModel::where('uuid',$this->data['sender_uuid'])->first();

            /* Get Sender details */
            $receiver_details = MembersModel::where('uuid',$this->data['receiver_uuid'])->first();

            /* Nav bar badge icon */

            $notifData = [
                'status' => 'new_message',
                'sender_details' => $sender_details,
                'receiver_details' => $receiver_details
            ];

            return $notifData;

        }
    }
}

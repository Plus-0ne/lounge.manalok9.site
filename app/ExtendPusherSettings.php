<?php
namespace App;

use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
use Illuminate\Broadcasting\BroadcastManager as BaseBroadcastManager;
use Psr\Log\LoggerInterface;
use Pusher\Pusher;

class ExtendPusherSettings extends BaseBroadcastManager
{
    protected function createPusherDriver(array $config)
    {
        $pusher = new Pusher(
            $config['key'], $config['secret'],
            $config['app_id'], $config['options'] ?? [],
            new \GuzzleHttp\Client($config['client_options']) ?? []
        );

        if ($config['log'] ?? false) {
            $pusher->setLogger($this->app->make(LoggerInterface::class));
        }

        return new PusherBroadcaster($pusher);
    }
}

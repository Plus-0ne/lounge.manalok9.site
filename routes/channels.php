<?php

use Illuminate\Support\Facades\Broadcast;

/* EVENTS */
use App\Models\Users\Trade;
use App\Models\Users\TradeLog;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('my.notification.{id}', function ($user, $id) {
    return true;
},['guards' => ['web']]);

Broadcast::channel('my.postNotifcation.{uuid}', function ($user, $uuid) {
    return true;
},['guards' => ['web']]);

Broadcast::channel('current.post.notification.{post_id}', function ($user,$post_id) {
    return true;
},['guards' => ['web']]);

/* Event for chat box update */
Broadcast::channel('messenger.update.{receiver_uuid}', function ($user,$receiver_uuid) {
    return true;
},['guards' => ['web']]);

/* Event for messenger contact list update */
Broadcast::channel('messenger.update.sidebarlist.{receiver_uuid}', function ($user,$receiver_uuid) {
    return true;
},['guards' => ['web']]);

/* Event for user notification if user received message */
Broadcast::channel('messenger.notify.user.{receiver_uuid}', function ($user,$receiver_uuid) {
    return true;
},['guards' => ['web']]);

Broadcast::channel('active.post.update', function ($user) {
    return true;
},['guards' => ['web']]);

Broadcast::channel('notification.reaction.{uuid}', function ($user,$uuid) {
    return true;
},['guards' => ['web']]);
Broadcast::channel('notification.comments.{uuid}', function ($user,$uuid) {
    return true;
},['guards' => ['web']]);

Broadcast::channel('user.create.post.{uuid}', function ($user,$uuid) {
    return true;
},['guards' => ['web']]);



Broadcast::channel('current.trade.notification.{trade_log_no}', function ($user,$trade_log_no) {
    $trade_poster = Trade::where('trade_status', 'ongoing')
                                            ->orWhere('trade_status', 'open')
                                            ->where('poster_iagd_number', $user->iagd_number)
                                            ->where('trade_log_no', $trade_log_no)
                                            ->count();
    $trade_requester = Trade::where('trade_status', 'ongoing')
                                            ->orWhere('trade_status', 'open')
                                            ->where('requester_iagd_number', $user->iagd_number)
                                            ->where('trade_log_no', $trade_log_no)
                                            ->count();
    $trade_log = TradeLog::where('log_status', 'accepted')
                                                ->orWhere('log_status', 'poster')
                                                ->where('trade_log_no', $trade_log_no)
                                                ->where('iagd_number', $user->iagd_number)
                                                ->count();
    return ($trade_log && ($trade_poster || $trade_requester));
},['guards' => ['web']]);

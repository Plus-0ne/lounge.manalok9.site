<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use JavaScript;
use Auth;
use Illuminate\Support\Facades\Http;
use DB;

use App\Models\Users\UserFollow;
use App\Models\Users\MembersModel;
use App\Models\Users\mlConversation;

use Dusterio\LinkPreview\Client;

use Carbon\Carbon;
use Str;

/* Broadcast events */
use App\Events\MessengerUpdate;
use App\Events\MessengerUpdateList;
use App\Events\MessengerNotifyUser;
use Crypt;
use Illuminate\Support\Facades\URL;
use Validator;

class MessengerController extends Controller
{
    /* -------------------------------------------------------------------------- */
    /*                               Messenger view                               */
    /* -------------------------------------------------------------------------- */
    public function index(Request $request)
    {
        /* If ru (room_uuid) request is not null set javascript variable to ru value */
        if (!empty($request->input('ru'))) {
            $ruValue = $request->input('ru');

            $chat_user_uuid = UserFollow::where([
                ['room_uuid', '=', $ruValue],
                ['uuid', '=', Auth::guard('web')->user()->uuid]
            ])->first()->follow_uuid;
        } else {
            $ruValue = null;
            $chat_user_uuid = null;
        }

        /* Get chat user id */


        Javascript::put([
            'myuuid' => Auth::guard('web')->user()->uuid,
            'assetUrl' => asset('/'),
            'baseUrl' => URL::to('/'),
            'room_uuid' => $ruValue,
            'user_to_chat' => $chat_user_uuid
        ]);

        $data = array(
            'title' => 'Messenger | Meta Lounge',
        );
        return view('pages/users/messenger/user-messenger', ['data' => $data]);
    }

    /* -------------------------------------------------------------------------- */
    /*                    Get all contacts from followers table                   */
    /* -------------------------------------------------------------------------- */
    public function all_follows(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        $myuuid = Auth::guard('web')->user()->uuid;

        $sub = mlConversation::orderBy('created_at', 'desc');


        $allFollows = tap(UserFollow::where('uuid', $myuuid)
            ->has('roomConversation')
            ->with('myFollowers')
            ->orderBy('last_message_at', 'DESC')
            ->paginate(100))
            ->map(function ($userFollows) {
                $userFollows->setRelation('LastMessage', $userFollows->LastMessage->first())->skip(0);
                return $userFollows;
            });



        if ($allFollows->count() > 0) {
            $data = [
                'status' => 'success',
                'message' => 'Start conversation',
                'all_follows' => $allFollows,
                // 'sidebar_lastmessage_at' => $sidebar_lastmessage_at->last_message_at
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => 'warning',
                'message' => 'Follow user to start private conversation'
            ];
            return response()->json($data);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                           Get users conversations                          */
    /* -------------------------------------------------------------------------- */
    public function get_conversation(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again later.'
            ];
            return response()->json($data);
        }

        /* Validate request */
        $validate = Validator::make($request->all(), [
            'room_uuid' => 'required',
            'sender_uuid' => 'required'
        ], [
            'room_uuid.required' => 'Room id not found.',
            'sender_uuid.required' => 'Sender id not found.'
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Variables */
        $room_uuid = $request->input('room_uuid');
        $sender_uuid = $request->input('sender_uuid');

        /* Get chat details */
        $ChatDetails = MembersModel::where('uuid', $sender_uuid);

        /* Throw response error if user is not found */
        if ($ChatDetails->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'User not found!'
            ];
            return response()->json($data);
        }

        /* Get conversation details */
        $CheckConversation = mlConversation::where(function ($q) use ($room_uuid) {
            $q->where('room_uuid', '=', $room_uuid);
            // Crypt::decryptString($q->message);
        });

        /* Check if conversation exist */
        if ($CheckConversation->count() > 0) {
            $CheckConversation->with('senderDetails')->orderBy('created_at', 'DESC');
            $cc = $CheckConversation->paginate(10);
        } else {
            $cc = null;
        }


        $data = [
            'status' => 'success',
            'message' => 'Conversation found',
            'convo' => $cc,
            'ChatDetails' => $ChatDetails->first()
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                            Send message to user                            */
    /* -------------------------------------------------------------------------- */
    public function sendMessage(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Create validation */
        $validate = Validator::make($request->all(), [
            'sendto_uuid' => 'required',
            'message_txt' => 'required',
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];
            return response()->json($data);
        }

        /* Send message from auth user to specific user */

        $sender_uuid = Auth::guard('web')->user()->uuid;
        $receiver_uuid = $request->input('sendto_uuid');
        $message_txt = $request->input('message_txt');

        /* Check if user has connection */
        $CheckUserFollow = UserFollow::where([
            ['uuid', '=', $sender_uuid],
            ['follow_uuid', '=', $receiver_uuid],
        ])->orWhere([
            ['uuid', '=', $receiver_uuid],
            ['follow_uuid', '=', $sender_uuid],
        ]);

        /* Connection variables */
        do {
            $room_uuid = Str::uuid();
        } while (UserFollow::where("room_uuid", $room_uuid)->first() instanceof UserFollow);

        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        if ($CheckUserFollow->count() > 0) {
            /* Get Room uuid */
            $room_uuid = $CheckUserFollow->first()->room_uuid;
        } else {
            /* Create connection */
            UserFollow::insert([
                [
                    'uuid' => $sender_uuid,
                    'follow_uuid' => $receiver_uuid,
                    'room_uuid' => $room_uuid,
                    'status' => 0,
                    'last_message_at' => $created_at,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
                [
                    'uuid' => $receiver_uuid,
                    'follow_uuid' => $sender_uuid,
                    'room_uuid' => $room_uuid,
                    'status' => 0,
                    'last_message_at' => $created_at,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
            ]);
        }

        do {
            $conversation_uuid = Str::uuid();
        } while (mlConversation::where("conversation_uuid", $conversation_uuid)->first() instanceof mlConversation);

        $sendMessage = mlConversation::create([
            'room_uuid' => $room_uuid,
            'conversation_uuid' => $conversation_uuid,
            'sender_uuid' => $sender_uuid,
            'receiver_uuid' => $receiver_uuid,
            'message' => $message_txt,
            'type' => 'private',
            'status' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        if ($sendMessage->save()) {

            /* Event update receiver messages */
            $data = [
                'type' => 'updateMessages',
                'fromUuid' => $sender_uuid,
                'room_uuid' => $room_uuid,
                'toUuid' => $receiver_uuid,
                'conversationUuid' => $conversation_uuid,
            ];
            broadcast(new MessengerUpdate($data));

            /* Event update receiver sidebar list */
            $data = [
                'type' => 'updateReceiverList',
                'sender_uuid' => $sender_uuid,
                'receiver_uuid' => $receiver_uuid,
            ];
            broadcast(new MessengerUpdateList($data));

            /* Event notify user */
            $data = [
                'type' => 'new_message_user_notify',
                'sender_uuid' => $sender_uuid,
                'receiver_uuid' => $receiver_uuid,
            ];
            broadcast(new MessengerNotifyUser($data));

            /* TODO : Attach message array */
            $conversationDetails = mlConversation::where('conversation_uuid', $conversation_uuid)
                ->with('userDetails')
                ->first();

            /* Update last message */
            UserFollow::where('room_uuid', $room_uuid)
                ->update([
                    'last_message_at' => $created_at
                ]);

            $data = [
                'status' => 'success',
                'message' => 'Message sent',
                'conversation' => $conversationDetails
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Message not sent!'
            ];
            return response()->json($data);
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                                Get last chat                               */
    /* -------------------------------------------------------------------------- */
    public function update_messengerChatContent(Request $request)
    {
        if (!$request->has('room_uuid') || !$request->has('created_at')) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }
        if (empty($request->input('room_uuid')) || empty($request->input('created_at'))) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Get latest message */
        $room_uuid = $request->input('room_uuid');
        $created_at = $request->input('created_at');

        $getLatestChats = mlConversation::where([
            ['room_uuid', '=', $room_uuid],
            ['created_at', '>', $created_at],
        ])
            ->with('senderDetails')
            ->with('receiverDetails');

        $getlastChatDateTime = mlConversation::where([
            ['room_uuid', '=', $room_uuid],
            ['created_at', '>', $created_at],
        ])
            ->orderBy('created_at', 'desc');

        $data = [
            'status' => 'success',
            'getLatestChats' => $getLatestChats->get(),
            'getlastChatDateTime' => $getlastChatDateTime->first()->created_at
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                              Get last message                              */
    /* -------------------------------------------------------------------------- */
    public function get_last_message_at(Request $request)
    {
        /* Preparation check key , request and value */
        if (!$request->has('last_message_at')) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }
        if (empty($request->input('last_message_at'))) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong'
            ];
            return response()->json($data);
        }

        /* Set variables */
        $myuuid = Auth::guard('web')->user()->uuid;
        $last_message_at = $request->input('last_message_at');

        /* Eloquent query get room and user details */
        $allFollows = tap(userFollow::where([
            ['uuid', '=', $myuuid],
            ['last_message_at', '>', $last_message_at]
        ])
            ->with('myFollowers')
            ->orderBy('last_message_at', 'DESC')
            ->get())
            ->map(function ($userFollows) {
                $userFollows->setRelation('LastMessage', $userFollows->LastMessage->first());
                return $userFollows;
            });


        $sidebar_lastmessage_at = userFollow::where([
            ['uuid', '=', $myuuid],
            ['last_message_at', '>', $last_message_at]
        ])
            ->orderBy('last_message_at', 'DESC')
            ->first();


        if ($allFollows->count() > 0) {
            $data = [
                'status' => 'success',
                'message' => 'Start conversation',
                'all_follows' => $allFollows,
                'sidebar_lastmessage_at' => $sidebar_lastmessage_at->last_message_at
            ];
            return response()->json($data);
        } else {
            $data = [
                'status' => 'warning',
                'message' => 'Follow user to start private conversation'
            ];
            return response()->json($data);
        }
    }


    /* -------------------------------------------------------------------------- */
    /*                                Search users                                */
    /* -------------------------------------------------------------------------- */
    public function search_users(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again.'
            ];

            return response()->json($data);
        }

        /* Validate request */
        $validate = Validator::make($request->all(), [
            'keyword' => 'required'
        ], [
            'keyword.required' => 'Enter search keyword.'
        ]);

        if ($validate->fails()) {
            $data = [
                'status' => 'warning',
                'message' => $validate->errors()->first()
            ];

            return response()->json($data);
        }

        /* Set variables */
        $searchValuesRaw = $request->input('keyword');
        $auth_user = Auth::guard('web')->user();

        /* Split keywords */
        $searchValues = preg_split('/\s+/', $request->input('keyword'), -1, PREG_SPLIT_NO_EMPTY);

        /* Search user for each keyword */
        $mm = MembersModel::select('uuid', 'first_name', 'last_name', 'profile_image', 'created_at')
            ->where([
                ['id', '!=', Auth::guard('web')->user()->id],
                [function ($q) use ($searchValues) {

                    foreach ($searchValues as $row) {
                        $q->orWhere([
                            ['first_name', 'like', "%{$row}%"],
                            ['is_email_verified', '=', 1],
                        ])->orWhere([
                            ['last_name', 'like', "%{$row}%"],
                            ['is_email_verified', '=', 1],
                        ])->orWhere([
                            ['middle_name', 'like', "%{$row}%"],
                            ['is_email_verified', '=', 1],
                        ]);
                    }
                }]
            ])
            ->with('myFollowers', function ($f) use ($auth_user) {
                $f->where('uuid', $auth_user->uuid);
            });

        $data = [
            'status' => 'success',
            'message' => 'Search keyword found users.',
            'users' => $mm->paginate(10),
            'search_keyword' => $searchValuesRaw
        ];

        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                        Messenger get message details                       */
    /* -------------------------------------------------------------------------- */
    public function get_message(Request $request)
    {
        /* Check if ajax request */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again.'
            ];

            return response()->json($data);
        }

        /* Validate request */
        $validate = Validator::make($request->all(), [
            'conversation_uuid' => 'required'
        ], [
            'conversation_uuid.required' => 'Something\'s wrong! Please try again.'
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];

            return response()->json($data);
        }

        $conversationDetails = mlConversation::where('conversation_uuid', $request->input('conversation_uuid'))
            ->with('userDetails')
            ->first();

        $data = [
            'status' => 'success',
            'message' => 'Message received.',
            'conversation' => $conversationDetails
        ];
        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                         Get user details using uuid                        */
    /* -------------------------------------------------------------------------- */
    public function get_user_details(Request $request)
    {
        /* Check if request is ajax */
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Something\'s wrong! Please try again.'
            ];

            return response()->json($data);
        }

        /* Validate request */
        $validate = Validator::make($request->all(), [
            'user_uuid' => 'required'
        ], [
            'user_uuid.required' => 'Something\'s wrong! Please try again.'
        ]);

        /* Throw validation errors */
        if ($validate->fails()) {
            $data = [
                'status' => 'error',
                'message' => $validate->errors()->first()
            ];

            return response()->json($data);
        }

        /* Check if users has connections */
        $userConnection = UserFollow::where([
            ['uuid', '=', Auth::guard('web')->user()->uuid],
            ['follow_uuid', '=', $request->input('user_uuid')]
        ]);

        /* Connection variables */
        do {
            $room_uuid = Str::uuid();
        } while (UserFollow::where("room_uuid", $room_uuid)->first() instanceof UserFollow);

        $created_at = Carbon::now();
        $updated_at = Carbon::now();

        /* Check if connection exist */
        if ($userConnection->count() > 0) {
            /* User connection exist */
            $room_uuid = $userConnection->first()->room_uuid;

        } else {

            /* Createt connection for this users */
            UserFollow::insert([
                [
                    'uuid' => Auth::guard('web')->user()->uuid,
                    'follow_uuid' => $request->input('user_uuid'),
                    'room_uuid' => $room_uuid,
                    'status' => 0,
                    'last_message_at' => $created_at,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
                [
                    'uuid' => $request->input('user_uuid'),
                    'follow_uuid' => Auth::guard('web')->user()->uuid,
                    'room_uuid' => $room_uuid,
                    'status' => 0,
                    'last_message_at' => $created_at,
                    'created_at' => $created_at,
                    'updated_at' => $updated_at,
                ],
            ]);

        }
        /* Get user details */
        $user_details = MembersModel::where('uuid', $request->input('user_uuid'));

        /* Return successful response */
        $data = [
            'status' => 'success',
            'message' => 'User details found.',
            'user_details' => $user_details->first(),
            'ruuid' => $room_uuid
        ];

        return response()->json($data);
    }

    /* -------------------------------------------------------------------------- */
    /*                                  Examples                                  */
    /* -------------------------------------------------------------------------- */
    public function getmetadata()
    {
        $url = 'https://www.youtube.com/watch?v=Tuc5nh77Jy4';
        $parsed = parse_url($url);
        if ($parsed['host'] == 'www.youtube.com' || $parsed['host'] == 'm.youtube.com' || $parsed['host'] == 'youtube.com') {
            $previewClient = new Client($url);

            $preview = $previewClient->getPreview('youtube');

            var_dump($preview->toArray()['embed']);
        } else {
            $previewClient = new Client($url);

            $preview = $previewClient->getPreview('general');

            var_dump($preview->toArray()['title']);
        }
    }
    public function CheckifStringhaslink()
    {
        $string = "The text you want to filter goes here. http://google.com, https://www.youtube.com/watch?v=K_m7NEDMrV0,https://instagram.com/hellow/";

        preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $string, $match);

        echo "<pre>";
        print_r($match[0]);
        echo "</pre>";
    }
}

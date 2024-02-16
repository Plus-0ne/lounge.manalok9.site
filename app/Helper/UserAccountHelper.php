<?php

namespace App\Helper;

use App\Models\Users\MembersModel;

class UserAccountHelper
{
    /**
     * Find user using id
     *
     * @param  mixed $id
     * @return void
     */
    public static function UserIdExist($id)
    {
        $user = MembersModel::find($id);
        if ($user->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'User account not found!'
            ];
            return $data;
        }
    }

    /**
     * Find user using uuid
     *
     * @param  mixed $user_uuid
     * @return void
     */
    public static function UserUuidExist($user_uuid)
    {
        $user = MembersModel::where('uuid',$user_uuid);

        if ($user->count() < 1) {
            $data = [
                'status' => 'warning',
                'message' => 'User account not found!'
            ];
            return $data;
        }
    }

    public static function getUserIdUsingUuid($user_uuid)
    {
        $user = MembersModel::where('uuid',$user_uuid);
        return $user->first();
    }
}

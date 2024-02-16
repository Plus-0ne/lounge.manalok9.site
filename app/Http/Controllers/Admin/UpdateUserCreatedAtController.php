<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
/* -------------------------------------------------------------------------- */
/*                                   Models                                   */
/* -------------------------------------------------------------------------- */
use App\Models\Users\MembersModel;
use App\Models\Users\PostFeed;
use App\Models\Users\PostComments;
use App\Models\Users\PostAttachments;


/* -------------------------------------------------------------------------- */
/*                                   Helper                                   */
/* -------------------------------------------------------------------------- */
use Auth;
use Carbon;

class UpdateUserCreatedAtController extends Controller
{
    public function updateUserCreate_At(Request $request)
    {
        /*
            TODO
            Get user timezone and created_at
            Convert created_at to utc /utc created_at

        */
        /* Update members model created at */
        $MembersModel = MembersModel::all();
        foreach ($MembersModel as $row) {
            $updatemm = MembersModel::find($row['id']);
            $updatemm->created_at = Carbon::parse($row['created_at'])->timezone('UTC');
            $updatemm->save();
        }

        $PostFeed = PostFeed::all();
        foreach ($PostFeed as $row) {
            $updatemm = PostFeed::find($row['id']);
            $updatemm->created_at = Carbon::parse($row['created_at'])->timezone('UTC');
            $updatemm->save();
        }

        $PostComments = PostComments::all();
        foreach ($PostComments as $row) {
            $updatemm = PostComments::find($row['id']);
            $updatemm->created_at = Carbon::parse($row['created_at'])->timezone('UTC');
            $updatemm->save();
        }

        $PostAttachments = PostAttachments::all();
        foreach ($PostAttachments as $row) {
            $updatemm = PostAttachments::find($row['id']);
            $updatemm->created_at = Carbon::parse($row['created_at'])->timezone('UTC');
            $updatemm->save();
        }
    }
}

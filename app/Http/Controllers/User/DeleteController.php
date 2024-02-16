<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use App\Models\User;
use App\Models\Users\MembersModel;
use App\Models\Users\MembersDocModel;
use App\Models\Users\IagdMembers;
use App\Models\Users\EmailVerification;
use App\Models\Users\MembersGallery;
use App\Models\Users\PostFeed;
use App\Models\Users\PostReaction;
use App\Models\Users\PostComments;
use App\Models\Users\MembersDevice;

use Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

use Browser;
use Illuminate\Support\Facades\File;

class DeleteController extends Controller
{
    public function delete_this_pet_record(Request $request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'key_error',
                'msg' => 'Something\'s wrong! Please try again.'
            ];
            return response()->json($data);
        }
        if (!$request->has('rid') || empty($request->input('rid'))) {
            $data = [
                'status' => 'key_error',
                'msg' => 'Something\'s wrong! Please try again.'
            ];
            return response()->json($data);
        }

        /* DELETE */

        $CheckIAGDDoc = Membersgallery::where([
            ['id', '=', $request->input('rid')],
            ['uuid', '=', Auth::guard('web')->user()->uuid],
        ]);

        if ($CheckIAGDDoc->count() > 0) {

            $mg_delete = MembersGallery::find($request->input('rid'));

            $file_to_delete = $mg_delete->file_path;

            if ($mg_delete->delete()) {

                if (File::exists($file_to_delete)) {
                    File::delete($file_to_delete);
                }

                $data = [
                    'status' => 'success',
                    'msg' => 'Pet deleted'
                ];
                return response()->json($data);
            } else {
                $data = [
                    'status' => 'error_deleting',
                    'msg' => 'Something\'s wrong while deleting this pet.'
                ];
                return response()->json($data);
            }
        } else {
            $data = [
                'status' => 'error',
                'msg' => 'Record not found'
            ];
            return response()->json($data);
        }
    }
}

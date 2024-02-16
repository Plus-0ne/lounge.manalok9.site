<?php

namespace App\Helper;

use App\Models\Users\PostFeed;

class Helper_Post_UpdatedAt
{
    public static function update($post_update_id,$new_updated_at)
    {
        try {

            $id = $post_update_id;

            $post_updated_at = $new_updated_at;

            $post_update_time = PostFeed::find($id);

            $post_update_time->updated_at = $post_updated_at;

            $post_update_time->save();

        } catch (\Throwable $th) {
            return $th;
        }
    }
}

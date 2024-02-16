<?php

namespace App\Helper;


class AjaxRequestHelper
{
    /**
     * Check if request is from ajax
     *
     * @param  mixed $request
     * @return Void
     */
    public static function checkAjaxRequest($request)
    {
        if (!$request->ajax()) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid request! Please try again later.'
            ];
            return $data;
        }
    }
}

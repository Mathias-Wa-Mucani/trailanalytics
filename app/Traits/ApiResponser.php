<?php

namespace App\Traits;

use App\Classes\GeneralHelper;
use App\Classes\SystemCodesHelper;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/** 
 * This trait handles all api responses
 */

trait ApiResponser
{
    /**
     * Handles all successful requests with related data attachment in the payload object
     */
    private function successResponse($data = null, $meta_data = [])
    {
        $meta_data['server_time'] = GeneralHelper::db_date_format_timestamp_24_hours(Carbon::now());
        return response()->json(['success' => true, 'payload' => $data, 'meta_data' => $meta_data]);
    }

    /**
     * Handles all successful responses with a message
     */
    protected function successMessage($message = 'Action successful')
    {
        return response()->json(['success' => true, 'message' => $message]);
    }

    /**
     * Handles all not found responses
     */
    protected function notFoundRespose($code = 'UNKNOWN_ERROR')
    {
        $message = $code;
        if (SystemCodesHelper::error_codes()[$code]) {
            $message = SystemCodesHelper::error_codes()[$code];
        }

        return response()->json(['success' => false, 'error_code' => $code, 'message' => $message]);
    }

    /**
     * Handles all api error responses
     */
    protected function errorResponse($code = 'UNKNOWN_ERROR')
    {
        $message = $code;
        if (@SystemCodesHelper::error_codes()[$code]) {
            $message = SystemCodesHelper::error_codes()[$code];
        }

        return response()->json(['success' => false, 'error_code' => $code, 'message' => $message]);
    }

    /**
     * returns a collection of data
     */
    protected function showData($data, $meta_data = [])
    {
        return $this->successResponse($this->cacheResponse($data), $meta_data);
    }

    /** 
     * Caches data 
     */
    protected function cacheResponse($data)
    {
        $url = request()->url();
        return Cache::remember($url, 30 / 60, function () use ($data) {
            return $data;
        });
    }
}

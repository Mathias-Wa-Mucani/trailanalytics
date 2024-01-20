<?php

namespace App\Classes;

use Cache;

class ActivityLogHelper
{
    public const CREATED = "Created";
    public const UPDATED = "Updated";
    public const DELETED = "Deleted";
    public const LOGIN = "Login";
    public const ALL_ACTIONS = "All";

    public static function LogActions()
    {
        return [
            self::ALL_ACTIONS,
            self::CREATED,
            self::UPDATED,
            self::DELETED,
            self::LOGIN,
        ];
    }

    /**
     * Here, all system logged are logged
     * It controlls all logs from observers and else where in the system
     */
    public static function LogActivity($logAction, $logDescription, $record = null, $properties = [], $causer = null)
    {
        /**
         * check if we have a causer for this activity
         * if we have a causer then add implicity add them
         */
        if ($record->isDirty()) {
            if ($causer) {
                activity($logAction)->causedBy($causer)->performedOn($record)->withProperties($properties)->log($logDescription);
            } else {
                /**
                 * If theres no activity causer, then set auth user as the causer 
                 * this is default so you dont have to set it yourself
                 */
                activity($logAction)->performedOn($record)->withProperties($properties)->log($logDescription);
            }

            //clear model cache
            if ($record && class_basename($record) !== "User") {
                $appModelClass = '\App\\Models\\' . class_basename($record);
                // $appModelClass::flushCache(class_basename($record));
            }
        }
    }
}

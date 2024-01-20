<?php

namespace App\Classes;

use Cache;

class ModuleHelper
{
    public const MODULE_REGISTRATION = "registration";
    public const MODULE_GROUPS = "groups";
    public const MODULE_GROUP_APPLICATIONS = "applications";

    public static function ModuleAuthorized($module)
    {
        if (auth()->user()->can($module)) {
            return true;
        }
        return false;
    }

    public static function ModuleUnAuthorizedPage()
    {
        return response()->view('errors.' . '403', [], 403);
    }
}

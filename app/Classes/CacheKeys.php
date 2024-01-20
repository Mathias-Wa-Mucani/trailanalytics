<?php

namespace App\Classes;

class CacheKeys
{
    // cache queries for 1 hour
    // public const REMEMBER_TIME = 60 * 60;
    public const REMEMBER_TIME = 0;
    public const AUTH_USER_PWDS = 'auth_user_pwds';
    public const CARETAKERS = 'caretakers';
}

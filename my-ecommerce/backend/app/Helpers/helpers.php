<?php

use Illuminate\Support\Facades\Auth;
use App\Models\User;

if (!function_exists('getAuthUserId')) {
    function getAuthUserId()
    {
        // ✅ Agar user already login hai
        if (Auth::check()) {
            return Auth::id();
        }

        // ✅ Agar request me email diya hua hai
       
        

        // ✅ Default guest
        return null;
    }
}
<?php

use App\Models\Language;
use App\Models\Setting;

// Format news tags
function formatTags(array $tags)
{
    return implode(',', $tags);
}

// Get selected language from session 
function getLanguage()
{
    if (session()->has('language')) {
        return session('language');
    } else {
        try {
            $language = Language::where('default', 1)->first();
            setLanguage($language->language);
            return $language->language;
        } catch (\Throwable $th) {
            setLanguage('en');
            return $language->language;
        }
    }
}

// Set language code in session
function setLanguage(string $code)
{
    session(['language' => $code]);
}

// Truncate text
function truncate(string $text, int $limit = 50)
{
    return \Str::limit($text, $limit, '...');
}

/** Convert a number in K format */
function convertToKFormat(int $number)
{
    if ($number < 1000) {
        return $number;
    } else if ($number < 1000000) {
        return round($number / 1000, 1) . 'K';
    } else {
        return round($number / 1000000, 1) . 'M';
    }
}

// Make sidebar active
function setSidebarActive(array $routes)
{
    foreach ($routes as $route) {
        if (request()->routeIs($route)) {
            return 'active';
        }
    }
}

//  Get setting
function getSetting($key)
{
    $data = Setting::where('key', $key)->first();
    return $data->value;
}

// Check permissions
function canAccess(string $permissions)
{
    $permission = auth()->guard('admin')->user()->hasPermissionTo($permissions, 'admin');
    $admin = auth()->guard('admin')->user()->hasRole('Admin');

    if ($permission || $admin) {
        return true;
    } else {
        return false;
    }
}

// Get Admin role
function getRole()
{
    $role = auth()->guard('admin')->user()->getRoleNames();
    return $role->first();
}

// Check User permissions
function checkPermission(string $permission)
{
    return auth()->guard('admin')->user()->hasPermissionTo($permission);
}
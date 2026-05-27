<?php

use App\Models\Setting;

if (!function_exists('setting')) {
    function setting(string|array $key, mixed $default = null): mixed
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                Setting::set($k, $v);
            }
            return null;
        }

        return Setting::get($key, $default);
    }
}

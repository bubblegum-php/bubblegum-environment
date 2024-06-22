<?php

if (!function_exists('env')) {
    /**
     * Get environment variable
     * @param string $name
     * @param string|null $default
     * @return string|null
     */
    function env(string $name, ?string $default=null): ?string
    {
        return getenv($name) ?: $default;
    }
}
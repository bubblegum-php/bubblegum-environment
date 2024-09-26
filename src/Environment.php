<?php

namespace Bubblegum;

use Bubblegum\Exceptions\EnvironmentException;

/**
 * Environment manager
 */
class Environment
{
    /**
     * Load environment from file
     * @param string $filePath
     * @return void
     * @throws EnvironmentException
     */
    public static function loadFromFile(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new EnvironmentException('.env file not found');
        }
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            if (str_contains($line, '#')) {
                $line = trim(substr($line, 0, strpos($line, '#')));
            }

            if (empty($line)) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            putenv(sprintf('%s=%s', $name, $value));
//            $_ENV[$name] = $value;
//            $_SERVER[$name] = $value;
        }
    }

    /**
     * Loads if not PREVENT_ENV_FILE_LOADING (if env is already loaded)
     * @param string $filePath
     * @return void
     * @throws EnvironmentException
     */
    public static function loadIfNotPrevented(string $filePath): void
    {
        if (env('PREVENT_ENV_FILE_LOADING') !== 'true') {
            self::loadFromFile($filePath);
        }
    }

    /**
     * Put data to the environment
     * @param string $name
     * @param string $value
     * @return void
     */
    public static function put(string $name, string $value): void
    {
        putenv(sprintf('%s=%s', $name, $value));
//        $_ENV[$name] = $value;
//        $_SERVER[$name] = $value;
    }

    /**
     * Get an environment variable or throw error
     * @param string $name
     * @return string
     * @throws EnvironmentException
     */
    public static function getOrThrow(string $name): string
    {
        $variable = getenv($name);
        if ($variable === false) {
            throw new EnvironmentException(".env variable \"$name\" not found", 500);
        }
        return $variable;
    }
}
# bubblegum-environment
.env configuration module for BUBBLEGUM

## Installation
Require this module with composer

`composer require bubblegum-php/bubblegum-environment`

## Usage

## Load environment

### Getting environment variables
You can simply use the `env` helper to get the environment variable.
```php
env('VARIABLE_NAME', 'DefaultValue')
```
You can define a __default value__ for a variable, which will be returned if the __environment variable__ with the same name is not set.
If neither a __default value__ nor an __environment variable__ is set, this method returns `null`.

### Get or Throw
Throws an exception if an environment variable is not found.
```php
use Bubblegum\Environment;

Environment::getOrThrow('VARIABLE_NAME'); // Throws an EnvironmentException if there is no variable named 'VARIABLE_NAME'
```

### Basic Load
```php
use Bubblegum\Environment;

Environment::loadFromFile('path/to/env/file');
```
### Load if not prevented
You can prevent the .env file loading if the environment already have the `PREVENT_ENV_FILE_LOADING` variable set to `true`.
```yaml
name: bubblegum
services:
  php:
    build:
      context: ./docker/
      dockerfile: php.dockerfile
    env_file:
      - ./.env # we already have environment loading here
    environment:
      PREVENT_ENV_FILE_LOADING: true # so we don't need to load it
```
If loading is NOT prevented, this method will load the environment.
```php
use Bubblegum\Environment;

Environment::loadIfNotPrevented('path/to/env/file');
```
### Put variables locally
You can put variables locally without saving them to a file.
```php
use Bubblegum\Environment;
$value = 'Hello There!'
Environment::put('VARIABLE_NAME', $value);
env(VARIABLE_NAME) // returns 'Hello There!'
```
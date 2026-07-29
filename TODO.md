# Provider 500 Error Fix

## Changes Made

### 1. `app/Models/Provider.php`

-   **Changed `getApiResourceClass()` from `protected static` to `public static`**
-   **Changed `getFormRequestClass()` from `protected static` to `public static`**

These methods are called from `AbstractApiController` (which is NOT in the Model inheritance hierarchy), so they must be `public`. Previously being `protected` caused PHP visibility violations → `$this->resource` stayed null → `new null(...)` threw "Class name must be a valid object or string".

### 2. `app/Http/Controllers/Api/ProviderController.php`

-   Replaced `return $this->getModelResource($this->model)` with explicit resource instantiation:
    ```php
    $this->resource = \App\Http\Resources\BaseResource::class;
    return new $this->resource($this->model);
    ```
-   This provides a direct fallback in case `resolveModel()` fails to set the resource.

## Root Cause

PHP cannot call `protected static` methods from unrelated classes. Since `AbstractApiController::resolveModel()` calls:

```php
$this->resource = $this->model::getApiResourceClass(); // protected!
```

...and `AbstractApiController` is not a subclass of `Model` (or `Provider`), this silently fails or throws an error, leaving `$this->resource = null`.

## Endpoints Fixed

Both endpoints that go through `resolveModel()`:

-   ✅ **PUT** `/system/providers/{id}` — `ProviderController::update()`
-   ✅ **DELETE** `/system/providers/{id}` — `AbstractApiController::destroy()`
-   ✅ Any other `Provider` endpoint using the abstract controller

## Deployment

Run `php artisan optimize` or `composer dump-autoload` after deploying to clear class cache.

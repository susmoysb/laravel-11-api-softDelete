# Laravel 11 Soft Deletes
In Laravel 11, when using route model binding, soft-deleted models are automatically excluded from queries by default.

## Option 1

To include soft-deleted models in queries, chain the `withTrashed()` method to the route definition.

```php
Route::post('/users/{user}/restore', [UserController::class, 'restore'])->withTrashed();
```

## Option 2

When using an API resource like:

```php
Route::apiResource('users', UserController::class);
```

Laravel automatically applies implicit route model binding to all resource routes.
By default, soft-deleted User models are excluded. Since i can’t chain withTrashed() directly on the entire apiResource definition.

### Solution: Override the Model’s Binding Resolution

I can customize how the model is retrieved by overriding the `resolveRouteBinding` method in User model so that it always includes soft-deleted models.

```php
public function resolveRouteBinding($value, $field = null)
{
    $field = $field ?? $this->getRouteKeyName();
    return $this->withTrashed()->where($field, $value)->firstOrFail();
}
```

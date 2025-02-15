# Laravel-Cache-User-To-Avoid-Extra-Query-Each-Request

## Overview

This Technique helps to prevent redundant database queries on every authenticated request, improving application performance.

## Installation

### Step 1: Add `CachedUserProvider.php`

A `CachedUserProvider` has been added to the repository. Developers need paste and register this provider properly.

### Step 2: Register the Service Provider

- **For Laravel 11+**, register the service provider in `bootstrap/providers.php`.
- **For older versions**, register it in `config/app.php` under the `providers` array.

### Step 3: Override the Auth Provider

Modify your AppServiceProvider or `AuthServiceProvider` to use the cached user provider instead of the default one:

```php
Auth::provider('cached', function ($app, array $config) {
    return new CachedUserProvider($app['hash'], $config['model']);
});
```

This ensures that `CachedUserProvider.php` is used, optimizing authentication performance by reducing database queries.

---


## Keeping User Data Updated

If you are serving user data in an API and want to ensure it remains up to date, you should recache the user data whenever the user model is updated. You can achieve this by handling it in the `updated` method of a `UserObserver`.

Example:

```php
class UserObserver {
    public function updated(User $user) {
        Cache::put('user_' . $user->id, $user);
    }
}
```

## Benefits
- Reduces database queries on each authenticated request.
- Improves application performance.
- Seamless integration with Laravel's authentication system.

---

## Contributing
Feel free to submit issues or pull requests if you have improvements or suggestions!

---

## Related Projects
You can also cache Sanctum personal access tokens to save two more database queries on each authenticated request by following this repository:

[Cache Personal Access Tokens in Laravel](https://github.com/talhawish/Cache-Personal-Access-Tokens-In-Laravel)

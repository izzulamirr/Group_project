# Group Project Report
# INFO 4345 | Ethical Shield
## Group Member
|Member                      |Matric ID| Assigned Tasks
|----------------------------|---------|---------
|Izzul Amir Bin Zulkifly     |2118091  | Authorization, File Security Principles, Database Security Principles, XSS and CSRF Prevention


# Table of Contents
# Vulnerability Report (OWASP ZAP)
# Input Validation
# Authentication
# Authorization
# XSS Prevention
# CSRF Prevention
# Database Security Principles
# File Security Principles
# Additional Security Measures

## Brief Description

This Laravel web application is focused on secure donation transaction collection, ensuring that each registered user can only manage and access their own organization.


## Objective of the Enhancements
The objective of this website enhancement is to significantly improve its security by implementing comprehensive measures: input validation, authentication and authorization, XSS and CSRF prevention, database security, file security, and additional security measures to address potential vulnerabilities and enhance overall protection.

## Owasp Zap Security report
Vulnerability Report (OWASP ZAP)
Automated Scan: OWASP ZAP was run against the application.
Findings:
Cookie flags (HttpOnly, Secure, SameSite): ✔️ Set in Laravel config.
X-Powered-By header: ✔️ Removed in middleware.
CSP header: ✔️ Set in SecurityHeaders middleware.
Mixed content or self-signed SSL: ⚠️ May show on localhost, not in production.
Risk/Confidence:
No high-risk vulnerabilities found after fixes.
All findings are low/medium risk with high confidence if not fixed.


## Web Application Security Enhancements


### Input Validation
Client-side:
**Registration Form Example** 
 
HTML5 validation (required, type, minlength, maxlength, pattern) in forms.
Server-side:

### Authentication
Password Storage:
Laravel uses bcrypt (strong, salted, one-way hashing).


Password Policies:
Enforced via validation rules (min length, complexity recommended).
**app/Http/Controllers/Auth/RegisterController.php**

Session Management:
Session IDs are strong, regenerated on login, invalidated on logout.
**session.php**
```php
'secure' => env('SESSION_SECURE_COOKIE', true),
'http_only' => true,
'same_site' => 'strict',
```
Cookies are HttpOnly, Secure, SameSite.

Multi-Factor Authentication:
TOTP 2FA enabled via Laravel Fortify.
Can be enforced for admins/high-privilege users.
Example:
**fortify.php**
```php
<?php
'features' => [
    // ...
    Features::twoFactorAuthentication([
        'confirmPassword' => true,
    ]),
],
```

### Authorization

Vertical (Role-Based):
- The application uses a custom middleware called Checkpermission to enforce role-based access control.
- This middleware checks the current user's roles (from the UserRole model) and verifies if the user has permission to access the requested route by checking the RolePermission model.
- If the user does not have the required permission for the route, a 403 Forbidden response is returned, preventing unauthorized access to protected resources.
Middleware Example:
**app\Http\Middleware\Checkpermission.php**
```php
public function handle(Request $request, Closure $next): Response
{
    // Get the current user's roles
    $userRoles = UserRole::where('UserID', $request->user()->id)->pluck('RoleID');

    // Check if the user has the required role for the requested route
    $hasPermission = RolePermission::whereIn('RoleID', $userRoles)
        ->where('Description', $request->route()->getName())
        ->exists();

    if (!$hasPermission) {
        // If the user doesn't have permission, return a 403 response
        return response()->json(['error' => 'Forbidden'], 403);
    }

    return $next($request);
}
```
- How it is applied:
The Checkpermission middleware is registered in Kernel.php and applied to routes or route groups that require role-based access control.
Example route usage:

```php
Route::middleware(['auth', 'checkpermission'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // ...other protected routes
});
```

- Horizontal (User Data):
In addition to role checks, controllers verify that users can only access or modify their own data, ensuring user-specific data protection.
**app/Http/Controllers/TransactionController.php**
```php 
public function show($id)
{
    $transaction = Transaction::findOrFail($id);

    // Ensure the authenticated user owns the transaction
    if ($transaction->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    return view('transactions.show', compact('transaction'));
}
```

### XSS Prevention
- Blade Escaping:
**resources\views\admin\CreateUser.blade.php**
```php
 <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                   name="name" value="{{ old('name') }}" required autofocus>
            @error('name')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>
```

- CSP header set in middleware.
**app/Http/Middleware/SecurityHeaders.php**
```php
public function handle($request, Closure $next)
{
    $response = $next($request);
    $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self';");
    return $response;
}
```

### CSRF Prevention
Blade Form Token:
Laravel automatically validates CSRF tokens on POST/PUT/DELETE requests.
**resources\views\profile\edit.blade.php**
```php
<form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label>New Password <small class="text-muted">(leave blank to keep current password)</small></label>
            <input type="password" name="password" class="form-control" autocomplete="new-password">
        </div>
        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>
```

### Database Security Principles
Eloquent ORM (Prevents SQL Injection):
```php
$user = User::where('email', $email)->first();
```

Database user has least privilege (should not have DROP/ALTER rights).
**env**
```php
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=GroupProject
DB_USERNAME=groupproject_user
DB_PASSWORD=Test123455
```

### File Security Principles
File Upload Validation and Storage:
**// app/Http/Controllers/TransactionController.php**
```php
$request->validate([
    'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
]);

if ($request->hasFile('receipt')) {
    // For sensitive files, use 'private' disk instead of 'public'
    $path = $request->file('receipt')->store('receipts', 'private');
    $transaction->receipt = $path;
}
```
.htaccess for Directory Listing (if using Apache):
```php
<IfModule mod_autoindex.c>
    Options -Indexes
</IfModule>
```


### Additional Security Measures
HTTPS enforced in production:
**app/Providers/AppServiceProvider.php**
```php
public function boot()
{
    if (app()->environment('production')) {
        \URL::forceScheme('https');
    }
}
```

HSTS header set:
SecurityHeaders middleware.

**app/Http/Middleware/SecurityHeaders.php**
```php
public function handle($request, Closure $next)
{
    $response = $next($request);
    $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    return $response;
}

```

Session timeout:
Users are logged out after inactivity.
Security headers:
**app/Http/Middleware/SecurityHeaders.php**
```php
public function handle($request, Closure $next)
{
    $response = $next($request);
    $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self';");
    $response->headers->set('X-Frame-Options', 'DENY');
    $response->headers->set('X-Content-Type-Options', 'nosniff');
    $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
    $response->headers->remove('X-Powered-By');
    return $response;
}
```

## References
1. OWASP Top Ten
2. Laravel Security Docs
3. PHP Security Guide

Appendices


Weekly Progress Report: [your progress report link]





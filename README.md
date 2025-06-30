# Group Project Report
# INFO 4345 | Ethical Shield

## Group Members
| Member                      | Matric ID | Assigned Tasks                                                    |
|-----------------------------|-----------|-------------------------------------------------------------------|
| Izzul Amir Bin Zulkifly     | 2118091   | Authorization, File Security Principles, Database Security Principles, XSS and CSRF Prevention |
| Haziq Uzair                 | 21xxx     | xxx                                                               |
| Johan Adam                  | 21xxxx    | xxx                                                               |

---

# Table of Contents
- Vulnerability Report (OWASP ZAP)
- Input Validation
- Authentication
- Authorization
- XSS Prevention
- CSRF Prevention
- Database Security Principles
- File Security Principles
- Additional Security Measures

---

## Brief Description

This Laravel web application is focused on secure donation transaction collection, ensuring that each registered user can only manage and access their own organization.

---

## Objective of the Enhancements

The objective of this website enhancement is to significantly improve its security by implementing comprehensive measures: input validation, authentication and authorization, XSS and CSRF prevention, database security, file security, and additional security measures to address potential vulnerabilities and enhance overall protection.

---

## OWASP ZAP Vulnerability Report

### Automated Scan Results

The following findings were reported by OWASP ZAP after scanning the application:

#### 1. Content Security Policy (CSP)
- **Description:** CSP header is present, but ensure it is set on all responses and includes the `frame-ancestors` directive to protect against ClickJacking.
- **Recommendation:** Add or update the CSP header to include `frame-ancestors 'none'` or use the `X-Frame-Options` header.

#### 2. CORS Misconfiguration
- **Description:** The `Access-Control-Allow-Origin: *` header is set, which allows cross-origin requests from any domain.
- **Risk:** This could allow third-party sites to access resources in an unintended way.
- **Recommendation:** Restrict the `Access-Control-Allow-Origin` header to only trusted domains or remove it if not needed.

#### 3. ClickJacking Protection Missing
- **Description:** The response does not include `X-Frame-Options` or a CSP `frame-ancestors` directive.
- **Risk:** The site may be vulnerable to clickjacking attacks.
- **Recommendation:** Set `X-Frame-Options: DENY` or add `frame-ancestors 'none'` to your CSP header.

#### 4. Disclosure of Internal IP Addresses
- **Description:** Private/internal IP addresses (e.g., `10.1.9.34`, `10.8.1.1`) were found in HTTP responses.
- **Risk:** Attackers may use this information for further attacks.
- **Recommendation:** Remove or mask internal IP addresses from all responses.

#### 5. X-Powered-By Header
- **Description:** The `X-Powered-By` header is present in some responses, revealing server technology.
- **Recommendation:** Remove the `X-Powered-By` header to reduce information disclosure.

#### 6. Secure Cookie Flags
- **Description:** Cookies are set with `HttpOnly` and `SameSite` flags, but ensure all cookies also use the `Secure` flag, especially in production.

---

### Summary Table

| Vulnerability                | Risk Level | Recommendation                                 |
|------------------------------|------------|------------------------------------------------|
| CSP header issues            | Medium     | Add/strengthen CSP, include frame-ancestors    |
| CORS misconfiguration        | Medium     | Restrict allowed origins                       |
| ClickJacking protection      | Medium     | Add X-Frame-Options or frame-ancestors         |
| Internal IP disclosure       | Low        | Remove/mask internal IPs in responses          |
| X-Powered-By header          | Low        | Remove header                                  |
| Cookie flags                 | Low        | Ensure Secure, HttpOnly, SameSite are set      |

---

**No high-risk vulnerabilities were found.**  
All findings are low/medium risk and can be mitigated with the above recommendations.

---

## Web Application Security Enhancements

### Input Validation

- **Client-side:**  
  HTML5 validation (required, type, minlength, maxlength, pattern) in forms.

- **Server-side:**  
  Laravel validation rules in controllers (e.g., `'name' => 'required|string|max:255'`).

### Authentication

- **Password Storage:**  
  Laravel uses bcrypt (strong, salted, one-way hashing).

- **Password Policies:**  
  Enforced via validation rules (min length, complexity recommended).

- **Session Management:**  
  Session IDs are strong, regenerated on login, invalidated on logout.
  ```php
  'secure' => env('SESSION_SECURE_COOKIE', true),
  'http_only' => true,
  'same_site' => 'strict',
  ```
  Cookies are HttpOnly, Secure, SameSite.

- **Multi-Factor Authentication:**  
  TOTP 2FA enabled via Laravel Fortify. Can be enforced for admins/high-privilege users.

### Authorization

- **Vertical (Role-Based):**  
  The application uses a custom middleware called `Checkpermission` to enforce role-based access control.  
  This middleware checks the current user's roles (from the `UserRole` model) and verifies if the user has permission to access the requested route by checking the `RolePermission` model.  
  If the user does not have the required permission for the route, a 403 Forbidden response is returned.

  **Middleware Example:**
  ```php
  public function handle(Request $request, Closure $next): Response
  {
      $userRoles = UserRole::where('UserID', $request->user()->id)->pluck('RoleID');
      $hasPermission = RolePermission::whereIn('RoleID', $userRoles)
          ->where('Description', $request->route()->getName())
          ->exists();
      if (!$hasPermission) {
          return response()->json(['error' => 'Forbidden'], 403);
      }
      return $next($request);
  }
  ```

  **Route Usage Example:**
  ```php
  Route::middleware(['auth', 'checkpermission'])->group(function () {
      Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
      // ...other protected routes
  });
  ```

- **Horizontal (User Data):**  
  Controllers verify that users can only access or modify their own data, ensuring user-specific data protection.

### XSS Prevention

- **Blade Escaping:**  
  All output in Blade templates uses `{{ }}` for automatic escaping.

- **CSP header set in middleware:**  
  ```php
  public function handle($request, Closure $next)
  {
      $response = $next($request);
      $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self';");
      return $response;
  }
  ```

### CSRF Prevention

- **Blade Form Token:**  
  Laravel automatically validates CSRF tokens on POST/PUT/DELETE requests.
  ```php
  <form action="{{ route('profile.update') }}" method="POST">
      @csrf
      <!-- form fields -->
  </form>
  ```

### Database Security Principles

- **Eloquent ORM (Prevents SQL Injection):**
  ```php
  $user = User::where('email', $email)->first();
  ```

- **Database user has least privilege:**  
  The database user does not have DROP/ALTER rights.

### File Security Principles

- **File Upload Validation and Storage:**
  ```php
  $request->validate([
      'receipt' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
  ]);
  if ($request->hasFile('receipt')) {
      $path = $request->file('receipt')->store('receipts', 'private');
      $transaction->receipt = $path;
  }
  ```

- **.htaccess for Directory Listing (if using Apache):**
  ```apache
  <IfModule mod_autoindex.c>
      Options -Indexes
  </IfModule>
  ```

### Additional Security Measures

- **HTTPS enforced in production:**
  ```php
  public function boot()
  {
      if (app()->environment('production')) {
          \URL::forceScheme('https');
      }
  }
  ```

- **HSTS header set:**  
  SecurityHeaders middleware sets `Strict-Transport-Security`.

- **Session timeout:**  
  Users are logged out after inactivity.

- **Security headers:**  
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

---

## References

1. OWASP Top Ten
2. Laravel Security Docs
3. PHP Security Guide

---

## Appendices

- Weekly Progress Report: [your progress report link]

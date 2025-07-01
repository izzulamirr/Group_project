# Group Project Report
# INFO 4345 | Ethical Shield

## Group Members
| Member                      | Matric ID | Assigned Tasks                                                    |
|-----------------------------|-----------|-------------------------------------------------------------------|
| Izzul Amir Bin Zulkifly     | 2118091   | Authorization, File Security Principles, Database Security Principles, XSS and CSRF Prevention |
| Haziq Uzair                 | 212757    | Authentication, 2 Factor Authentication                                                              |
| Johan Adam                  | 2116387   | Input Validation, Add Regex, Login and Register Request File, Profile Page |

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
Input validation ensures that user-provided data meets specific criteria before being processed or stored.
Laravel provides robust validation features, including custom rules, regex patterns, and error messages.|

- **Regex Validation:**  
- Regex validation is used to enforce specific patterns for input fields. For example, ensuring that a name contains only letters (A-Z and a-z).

**Regex Example:**
   ```php
   public function rules(): array
  {
    return [
        'name' => 'required|regex:/^[A-Za-z\s]+$/|max:255', // Only letters and spaces allowed
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|min:7|confirmed|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{7,}$/',
        ];
    
  }

   public function messages(): array
  {
    return [
        'name.regex' => 'The name may only contain letters and spaces.',
        'password.regex' => 'The password must be at least 7 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character.',
    ];
  }
  ```
**Explanation:**
- Regex Rule: 
regex:/^[A-Za-z\s]+$/ ensures the name contains only letters and spaces.
  This regex enforces a strong password policy by requiring:
  - At least 7 characters in total
  - At least one uppercase letter (A-Z)
  - At least one lowercase letter (a-z)
  - At least one digit (0-9)
  - At least one special character (such as @, $, !, %, *, ?, &)

- **Registration Request:**
- The RegistrationRequest class handles validation for user registration.

**Controller Logic For Register Request:**
   ```php
   public function register(RegistrationRequest $request)
  {
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

  UserRole::create([
            'UserID' => $user->id,
            'RoleName' => 'user',
            'Description' => 'Normal user',
        ]);

        Auth::login($user);

        return redirect()->route('Orgdashboard')->with('success', 'Registration successful!');
    }

  ```

- **LoginRequest:**
- The LoginRequest class handles validation for login functionality..

**LoginRequest.php:**
   ```php
   public function rules(): array
  {
    return [
        'email' => 'required|email', // Validate email format
        'password' => 'required|string',
    ];
  }
  ```
**Controller Logic For Login:**
   ```php
   public function login(Request $request)
    {
        // Attempt to authenticate the user
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->roles == '1' || $user->roles == 1) {
                return redirect()->route('transaction.index');
            } else {
                return redirect()->route('Orgdashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }
  ```

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
  **Example: OrganizationController.php**
  ```php
  // Only allow the owner or a user with permission to update
  public function update(Request $request, $id)
  {
      $organization = Organization::findOrFail($id);
      $user = auth()->user();
      $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
      $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
          ->where('Description', 'Update Organization')
          ->exists();

      // Only allow if user is owner or has permission
      if ($organization->user_id !== $user->id && !$hasPermission) {
          abort(403, 'Unauthorized action.');
      }

      $request->validate([
          'name' => 'required|string|max:255',
          'remarks' => 'nullable|string|max:255',
      ]);
      $organization->update([
          'name' => $request->name,
          'remarks' => $request->remarks,
      ]);
      return redirect()->route('organizations.my')->with('flash_message', 'Organization Updated!');
  }
  ```

  **Example: TransactionController.php**
  ```php
  // Ensure the transaction belongs to the organization and user has permission
  public function edit($organizationId, $transactionId)
  {
      $organization = Organization::findOrFail($organizationId);
      $transaction = Transaction::findOrFail($transactionId);

      // Ensure the transaction belongs to the organization
      if ($transaction->organization_id != $organization->id) {
          abort(404, 'Transaction not found in this organization.');
      }

      $user = auth()->user();
      $roleIds = UserRole::where('UserID', $user->id)->pluck('RoleID');
      $hasPermission = RolePermission::whereIn('RoleID', $roleIds)
          ->where('Description', 'Update Transaction')
          ->exists();

      if (!$hasPermission) {
          abort(403, 'Unauthorized action.');
      }

      $donators = Donator::all();
      return view('transactions.edit', compact('organization', 'transaction', 'donators'));
  }
  ```

  **Example: Route Protection**
  ```php
  // routes/web.php
  Route::middleware(['auth', 'checkpermission'])->group(function () {
      Route::get('/organization/create', [OrganizationController::class, 'create'])->name('organization.create');
      Route::post('/organization', [OrganizationController::class, 'store'])->name('organization.store');
      // ...other protected routes
  });
  ```

### XSS Prevention

- **Blade Escaping:**  
  All output in Blade templates uses `{{ }}` for automatic escaping.
    **Example: resources/views/organization/create.blade.php**
  ```php
  <div class="mb-3">
      <label for="name" class="form-label">Organization Name</label>
      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
             name="name" value="{{ old('name') }}" required autofocus>
      @error('name')
          <span class="invalid-feedback">{{ $message }}</span>
      @enderror
  </div>
  ```

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

- **Eloquent ORM (Prevents SQL Injection):**
  ```php
  $user = User::where('email', $email)->first();
  ```

- **Database user has least privilege:**  
  The database user does not have DROP/ALTER rights.  
  Example from `.env`:
  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=GroupProject
  DB_USERNAME=groupproject_user
  DB_PASSWORD=Test123455
  ```
  The `groupproject_user` account is configured in MySQL with only the necessary privileges (SELECT, INSERT, UPDATE, DELETE) and **does not have DROP or ALTER permissions**. This limits the potential damage if the credentials are ever compromised.

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

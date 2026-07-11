<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Ashutosh Enterprises</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @vite(['resources/scss/public.scss', 'resources/js/app.js'])
    <style>
        body { min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #0F172A, #1E293B); padding: 2rem; }
        .login-card { background: #fff; border-radius: 1.25rem; padding: 3rem; max-width: 420px; width: 100%; box-shadow: 0 25px 50px rgba(0,0,0,0.25); }
        .login-card .brand { text-align: center; margin-bottom: 2rem; }
        .login-card .brand-icon { width: 56px; height: 56px; border-radius: 14px; background: linear-gradient(135deg, #F59E0B, #D97706); display: inline-flex; align-items: center; justify-content: center; color: #0F172A; font-weight: 800; font-size: 1.5rem; margin-bottom: 1rem; }
        .login-card h2 { font-family: 'Outfit', sans-serif; font-weight: 800; font-size: 1.5rem; margin-bottom: 0.25rem; }
        .login-card .subtitle { color: #64748B; font-size: 0.9rem; }
        .login-card .form-control { border-radius: 0.75rem; padding: 0.75rem 1rem; border-color: #E2E8F0; }
        .login-card .form-control:focus { border-color: #F59E0B; box-shadow: 0 0 0 3px rgba(245,158,11,0.1); }
        .login-card .btn-login { background: #0F172A; color: #fff; border: none; border-radius: 0.75rem; padding: 0.75rem; font-weight: 600; width: 100%; transition: all 0.2s; }
        .login-card .btn-login:hover { background: #F59E0B; color: #0F172A; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="brand">
            <div class="brand-icon">A</div>
            <h2>Welcome Back</h2>
            <p class="subtitle">Sign in to Ashutosh Enterprises Admin</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger rounded-3 py-2" style="font-size:0.875rem;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:0.875rem;">Email Address</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-radius:0.75rem 0 0 0.75rem;border-color:#E2E8F0;"><i class="bi bi-envelope" style="color:#94A3B8;"></i></span>
                    <input type="email" name="email" class="form-control border-start-0" placeholder="admin@ashutosh.com" value="{{ old('email') }}" required autofocus style="border-radius:0 0.75rem 0.75rem 0;">
                </div>
            </div>
            <div class="mb-4">
                <label class="form-label fw-semibold" style="font-size:0.875rem;">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-transparent border-end-0" style="border-radius:0.75rem 0 0 0.75rem;border-color:#E2E8F0;"><i class="bi bi-lock" style="color:#94A3B8;"></i></span>
                    <input type="password" name="password" class="form-control border-start-0" placeholder="••••••••" required style="border-radius:0 0.75rem 0.75rem 0;">
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="remember">
                    <label class="form-check-label" for="remember" style="font-size:0.85rem;">Remember me</label>
                </div>
            </div>
            <button type="submit" class="btn-login">Sign In <i class="bi bi-arrow-right ms-1"></i></button>
        </form>
        <div class="text-center mt-4">
            <a href="{{ route('home') }}" style="color:#64748B;font-size:0.85rem;text-decoration:none;">
                <i class="bi bi-arrow-left"></i> Back to Website
            </a>
        </div>
    </div>
</body>
</html>

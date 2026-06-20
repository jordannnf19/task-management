@extends('layouts.app')

@section('title', 'Sign In')

@section('content')

<style>
.login-bg {
    min-height: 100vh;
    background: linear-gradient(135deg, #0F172A 0%, #1E3A5F 45%, #1E3799 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px 16px;
    position: relative;
    overflow: hidden;
}

.login-bg::before {
    content: '';
    position: absolute;
    top: -120px; right: -120px;
    width: 400px; height: 400px;
    background: rgba(99,102,241,0.12);
    border-radius: 50%;
    pointer-events: none;
}

.login-bg::after {
    content: '';
    position: absolute;
    bottom: -100px; left: -80px;
    width: 320px; height: 320px;
    background: rgba(37,99,235,0.10);
    border-radius: 50%;
    pointer-events: none;
}

.login-card {
    width: 100%;
    max-width: 420px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 25px 50px rgba(0,0,0,0.3);
    overflow: hidden;
    position: relative;
    z-index: 1;
    animation: cardUp 0.4s ease;
}

@keyframes cardUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

.login-header {
    background: linear-gradient(135deg, #0F172A 0%, #1E3799 100%);
    padding: 32px 36px 28px;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.login-header::before {
    content: '';
    position: absolute; top: -30px; right: -30px;
    width: 100px; height: 100px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}

.login-logo {
    width: 56px; height: 56px;
    background: linear-gradient(135deg, #3B82F6, #7C3AED);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 16px;
    font-size: 24px; font-weight: 800; color: white;
    box-shadow: 0 8px 20px rgba(37,99,235,0.4);
}

.login-title {
    font-size: 22px; font-weight: 800;
    color: white; margin: 0 0 4px;
}

.login-subtitle {
    font-size: 13px; color: rgba(255,255,255,0.6);
    margin: 0;
}

.login-body {
    padding: 32px 36px 36px;
}

.login-form-label {
    font-size: 12px; font-weight: 600;
    color: #1E293B; margin-bottom: 6px;
    display: block;
}

.login-input {
    width: 100%;
    padding: 10px 12px 10px 38px;
    border: 1.5px solid #E2E8F0;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    color: #1E293B;
    background: #F8FAFC;
    transition: all 0.2s;
    outline: none;
}

.login-input:focus {
    border-color: #2563EB;
    background: white;
    box-shadow: 0 0 0 3px rgba(37,99,235,0.12);
}

.login-input::placeholder { color: #CBD5E1; }

.input-wrap {
    position: relative;
    margin-bottom: 20px;
}

.input-wrap .input-ico {
    position: absolute;
    left: 11px; top: 50%;
    transform: translateY(-50%);
    color: #94A3B8; font-size: 15px;
    pointer-events: none;
}

.pw-toggle {
    position: absolute;
    right: 11px; top: 50%;
    transform: translateY(-50%);
    border: none; background: none;
    color: #94A3B8; cursor: pointer;
    font-size: 15px; padding: 0;
    transition: color 0.15s;
}
.pw-toggle:hover { color: #2563EB; }

.login-btn {
    width: 100%;
    padding: 12px;
    background: linear-gradient(135deg, #2563EB, #7C3AED);
    color: white;
    border: none;
    border-radius: 10px;
    font-family: 'Inter', sans-serif;
    font-size: 14px; font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
    margin-top: 4px;
    display: flex; align-items: center; justify-content: center; gap: 8px;
}

.login-btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(37,99,235,0.4);
}

.login-btn:active { transform: translateY(0); }

.login-btn.loading {
    opacity: 0.8;
    pointer-events: none;
}

.remember-row {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 24px;
}

.remember-row input[type="checkbox"] {
    width: 16px; height: 16px;
    accent-color: #2563EB;
    cursor: pointer;
}

.remember-row label {
    font-size: 13px; color: #64748B;
    cursor: pointer; font-weight: 500;
}

.login-error {
    background: #FEF2F2;
    border: 1px solid #FECACA;
    border-radius: 10px;
    padding: 12px 14px;
    margin-bottom: 20px;
    display: flex; align-items: flex-start; gap: 8px;
}

.login-error i { color: #EF4444; font-size: 15px; flex-shrink: 0; margin-top: 1px; }
.login-error p  { margin: 0; font-size: 13px; color: #B91C1C; }

.login-footer-text {
    text-align: center;
    font-size: 11.5px; color: #94A3B8;
    margin-top: 24px;
    padding-top: 20px;
    border-top: 1px solid #F1F5F9;
}
</style>

<div class="login-bg">
    <div class="login-card">

        {{-- Header --}}
        <div class="login-header">
            <div class="login-logo">T</div>
            <h1 class="login-title">Welcome back</h1>
            <p class="login-subtitle">Sign in to your Task Manager account</p>
        </div>

        {{-- Body --}}
        <div class="login-body">

            {{-- Validation errors --}}
            @if ($errors->any())
            <div class="login-error">
                <i class="bi bi-exclamation-circle-fill"></i>
                <div>
                    @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
            @endif

            <form method="POST" action="/login" id="loginForm">
                @csrf

                {{-- Email --}}
                <label class="login-form-label" for="email">
                    Email Address
                </label>
                <div class="input-wrap">
                    <i class="bi bi-envelope input-ico"></i>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="login-input"
                        placeholder="you@example.com"
                        value="{{ old('email') }}"
                        autocomplete="email"
                        required>
                </div>

                {{-- Password --}}
                <label class="login-form-label" for="password">
                    Password
                </label>
                <div class="input-wrap">
                    <i class="bi bi-lock input-ico"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="login-input"
                        placeholder="Enter your password"
                        autocomplete="current-password"
                        style="padding-right: 40px;"
                        required>
                    <button type="button" class="pw-toggle" id="pwToggle" title="Show/hide password">
                        <i class="bi bi-eye" id="pwToggleIcon"></i>
                    </button>
                </div>

                {{-- Remember me --}}
                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Keep me signed in</label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="login-btn" id="loginBtn">
                    <i class="bi bi-box-arrow-in-right" id="loginIcon"></i>
                    <span id="loginText">Sign In</span>
                </button>

            </form>

            <p class="login-footer-text">
                Task Management System &copy; {{ date('Y') }}
            </p>

        </div>
    </div>
</div>

@push('scripts')
<script>
// Password visibility toggle
document.getElementById('pwToggle').addEventListener('click', function () {
    var pw   = document.getElementById('password');
    var icon = document.getElementById('pwToggleIcon');
    if (pw.type === 'password') {
        pw.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        pw.type = 'password';
        icon.className = 'bi bi-eye';
    }
});

// Login button loading state
document.getElementById('loginForm').addEventListener('submit', function () {
    var btn  = document.getElementById('loginBtn');
    var icon = document.getElementById('loginIcon');
    var text = document.getElementById('loginText');
    btn.classList.add('loading');
    icon.className = 'bi bi-arrow-repeat spin-icon';
    text.textContent = 'Signing in...';
    btn.style.gap = '8px';
});
</script>
<style>
@keyframes spin { to { transform: rotate(360deg); } }
.spin-icon { display: inline-block; animation: spin 0.7s linear infinite; }
</style>
@endpush

@endsection

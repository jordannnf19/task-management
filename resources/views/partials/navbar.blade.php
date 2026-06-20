<nav class="app-navbar">

    {{-- Brand --}}
    <a href="{{ route('dashboard') }}" class="navbar-brand-area">
        <div class="nav-logo">T</div>
        <span class="nav-app-name">Task <span>Manager</span></span>
    </a>

    {{-- Mobile sidebar toggle --}}
    <button class="nav-icon-btn sidebar-toggle" id="sidebarToggle" title="Toggle menu">
        <i class="bi bi-list"></i>
    </button>

    <div class="nav-spacer"></div>

    {{-- Right side --}}
    <div class="nav-right">
        @auth

        {{-- User dropdown --}}
        <div class="dropdown">
            <button class="user-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                <i class="bi bi-chevron-down" style="font-size: 10px; color: var(--muted);"></i>
            </button>

            <ul class="dropdown-menu dropdown-menu-end">
                <li>
                    <span class="dropdown-header">
                        <i class="bi bi-envelope me-1"></i>
                        {{ auth()->user()->email }}
                    </span>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item" href="{{ route('my.account') }}">
                        <i class="bi bi-person-circle"></i>
                        My Account
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('my.daily.tasks') }}">
                        <i class="bi bi-calendar-check"></i>
                        My Daily Tasks
                    </a>
                </li>
                <li>
                    <a class="dropdown-item" href="{{ route('my.weekly.tasks') }}">
                        <i class="bi bi-bar-chart-line"></i>
                        My Weekly Reports
                    </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger w-100">
                            <i class="bi bi-box-arrow-right"></i>
                            Sign Out
                        </button>
                    </form>
                </li>
            </ul>
        </div>

        @endauth
    </div>

</nav>

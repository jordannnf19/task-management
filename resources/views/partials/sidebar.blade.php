<aside class="app-sidebar" id="appSidebar">

    {{-- Main navigation --}}
    <p class="sidebar-section-label">Main Menu</p>

    <ul class="list-unstyled m-0">

        <li>
            <a href="{{ route('dashboard') }}"
               class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
            </a>
        </li>

        <li>
            <a href="{{ route('daily.index') }}"
               class="sidebar-link {{ request()->routeIs('daily.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-day-fill"></i>
                Daily Update
            </a>
        </li>

        <li>
            <a href="{{ route('weekly.index') }}"
               class="sidebar-link {{ request()->routeIs('weekly.*') ? 'active' : '' }}">
                <i class="bi bi-bar-chart-fill"></i>
                Weekly Update
            </a>
        </li>

    </ul>

    {{-- Account navigation --}}
    <p class="sidebar-section-label" style="margin-top: 24px;">Account</p>

    <ul class="list-unstyled m-0">

        <li>
            <a href="{{ route('my.account') }}"
               class="sidebar-link {{ request()->routeIs('my.*') ? 'active' : '' }}">
                <i class="bi bi-person-fill"></i>
                My Account
            </a>
        </li>

    </ul>

    {{-- Bottom user info --}}
    <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 12px 10px; border-top: 1px solid rgba(255,255,255,0.06);">
        <div style="display: flex; align-items: center; gap: 8px; padding: 8px 10px; border-radius: 8px; background: rgba(255,255,255,0.05);">
            <div class="user-avatar-sm" style="width: 30px; height: 30px; flex-shrink: 0;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="font-size: 12.5px; font-weight: 600; color: #E2E8F0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ auth()->user()->name }}
                </div>
                <div style="font-size: 11px; color: #64748B; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ auth()->user()->email }}
                </div>
            </div>
        </div>
    </div>

</aside>

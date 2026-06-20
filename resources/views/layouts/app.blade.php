<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Task Manager') — TMS</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
    /* =============================================
       DESIGN TOKENS
    ============================================= */
    :root {
        --primary:        #2563EB;
        --primary-hover:  #1D4ED8;
        --primary-light:  #EFF6FF;
        --secondary:      #0F172A;
        --success:        #10B981;
        --success-light:  #ECFDF5;
        --warning:        #F59E0B;
        --warning-light:  #FFFBEB;
        --danger:         #EF4444;
        --danger-light:   #FEF2F2;
        --bg:             #F8FAFC;
        --card-bg:        #FFFFFF;
        --border:         #E2E8F0;
        --text:           #1E293B;
        --muted:          #64748B;
        --radius:         12px;
        --sidebar-w:      260px;
        --nav-h:          64px;
        --shadow-xs:  0 1px 2px rgba(0,0,0,0.05);
        --shadow-sm:  0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
        --shadow:     0 4px 6px -1px rgba(0,0,0,0.08), 0 2px 4px -2px rgba(0,0,0,0.04);
        --shadow-lg:  0 10px 15px -3px rgba(0,0,0,0.08), 0 4px 6px -4px rgba(0,0,0,0.04);
        --transition: all 0.2s ease;
    }

    /* =============================================
       BASE
    ============================================= */
    *, *::before, *::after { box-sizing: border-box; }

    body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
        background: var(--bg);
        color: var(--text);
        font-size: 14px;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }

    /* =============================================
       NAVBAR
    ============================================= */
    .app-navbar {
        position: fixed;
        top: 0; left: 0; right: 0;
        height: var(--nav-h);
        background: #FFFFFF;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        padding: 0 20px 0 0;
        z-index: 1040;
        box-shadow: var(--shadow-xs);
    }

    .navbar-brand-area {
        display: flex;
        align-items: center;
        width: var(--sidebar-w);
        padding: 0 20px;
        flex-shrink: 0;
        text-decoration: none;
        gap: 10px;
        border-right: 1px solid var(--border);
        height: 100%;
    }

    .nav-logo {
        width: 36px; height: 36px;
        background: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: white; font-weight: 800; font-size: 15px;
        flex-shrink: 0;
        box-shadow: 0 4px 10px rgba(37,99,235,0.3);
    }

    .nav-app-name {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--text);
        white-space: nowrap;
    }

    .nav-app-name span { color: var(--primary); }

    .nav-spacer { flex: 1; }

    .nav-right {
        display: flex;
        align-items: center;
        gap: 6px;
        padding-left: 16px;
    }

    .nav-icon-btn {
        width: 36px; height: 36px;
        border: none; background: transparent;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: var(--muted); cursor: pointer;
        font-size: 19px;
        transition: var(--transition);
    }
    .nav-icon-btn:hover { background: var(--bg); color: var(--text); }

    .user-btn {
        display: flex; align-items: center; gap: 8px;
        padding: 5px 10px 5px 6px;
        border: 1px solid var(--border);
        border-radius: 10px;
        background: white;
        cursor: pointer;
        transition: var(--transition);
        font-family: 'Inter', sans-serif;
        font-size: 13px; font-weight: 500;
        color: var(--text);
    }
    .user-btn:hover { border-color: #CBD5E1; box-shadow: var(--shadow-sm); }

    .user-avatar-sm {
        width: 28px; height: 28px;
        border-radius: 7px;
        background: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 11px; font-weight: 700;
        flex-shrink: 0;
    }

    /* Dropdown */
    .dropdown-menu {
        border: 1px solid var(--border) !important;
        border-radius: var(--radius) !important;
        box-shadow: var(--shadow-lg) !important;
        padding: 6px !important;
        min-width: 210px;
        animation: dropIn 0.15s ease;
    }
    @keyframes dropIn {
        from { opacity: 0; transform: translateY(-6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .dropdown-header {
        font-size: 11px !important;
        color: var(--muted) !important;
        padding: 6px 10px 4px !important;
        font-weight: 500 !important;
    }

    .dropdown-item {
        border-radius: 8px !important;
        padding: 8px 10px !important;
        font-size: 13px !important;
        color: var(--text) !important;
        display: flex !important;
        align-items: center;
        gap: 8px;
        transition: var(--transition);
        font-family: 'Inter', sans-serif;
        text-decoration: none;
    }
    .dropdown-item:hover { background: var(--primary-light) !important; color: var(--primary) !important; }
    .dropdown-item i { width: 16px; text-align: center; font-size: 14px; }
    .dropdown-item.text-danger { color: var(--danger) !important; }
    .dropdown-item.text-danger:hover { background: var(--danger-light) !important; }

    .dropdown-divider { border-color: var(--border) !important; margin: 4px 0 !important; }

    /* Mobile toggle */
    .sidebar-toggle { display: none; margin-left: 8px; }
    @media (max-width: 991.98px) { .sidebar-toggle { display: flex; } }

    /* =============================================
       SIDEBAR
    ============================================= */
    .app-sidebar {
        position: fixed;
        top: var(--nav-h); left: 0;
        width: var(--sidebar-w);
        height: calc(100vh - var(--nav-h));
        background: var(--secondary);
        overflow-y: auto;
        overflow-x: hidden;
        z-index: 1030;
        transition: transform 0.28s cubic-bezier(0.4,0,0.2,1);
        padding: 16px 10px 24px;
    }

    .sidebar-section-label {
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #475569;
        padding: 0 10px;
        margin: 0 0 4px;
    }

    .sidebar-link {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 10px;
        border-radius: 8px;
        color: #94A3B8;
        text-decoration: none;
        font-size: 13.5px; font-weight: 500;
        transition: var(--transition);
        margin-bottom: 2px;
    }
    .sidebar-link:hover { background: rgba(255,255,255,0.07); color: #CBD5E1; }
    .sidebar-link.active {
        background: var(--primary);
        color: #FFFFFF;
        box-shadow: 0 4px 14px rgba(37,99,235,0.4);
    }
    .sidebar-link i { font-size: 16px; width: 20px; text-align: center; flex-shrink: 0; }

    /* Mobile overlay */
    .sidebar-overlay {
        display: none;
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 1029;
        backdrop-filter: blur(2px);
    }

    /* =============================================
       LAYOUT
    ============================================= */
    .app-wrapper {
        margin-top: var(--nav-h);
        margin-left: var(--sidebar-w);
        min-height: calc(100vh - var(--nav-h));
    }

    .app-content {
        padding: 28px 32px;
        max-width: 1440px;
    }

    @media (max-width: 991.98px) {
        .app-sidebar { transform: translateX(-100%); }
        .app-sidebar.open { transform: translateX(0); }
        .sidebar-overlay.open { display: block; }
        .app-wrapper { margin-left: 0; }
        .navbar-brand-area { width: auto; border-right: none; }
        .app-content { padding: 20px 16px; }
    }

    /* =============================================
       CARDS
    ============================================= */
    .card {
        background: var(--card-bg);
        border: 1px solid var(--border) !important;
        border-radius: var(--radius) !important;
        box-shadow: var(--shadow-sm) !important;
    }

    .card-header {
        background: transparent !important;
        border-bottom: 1px solid var(--border) !important;
        padding: 14px 20px !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-body  { padding: 20px !important; }
    .card-footer {
        background: transparent !important;
        border-top: 1px solid var(--border) !important;
        padding: 14px 20px !important;
    }

    /* Stat cards */
    .stat-card {
        overflow: hidden;
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease !important;
    }
    .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg) !important; }

    .stat-icon {
        width: 48px; height: 48px;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px;
    }

    .stat-value { font-size: 30px; font-weight: 800; color: var(--text); line-height: 1.1; }
    .stat-label { font-size: 12.5px; color: var(--muted); font-weight: 500; margin-top: 2px; }

    /* =============================================
       FORMS
    ============================================= */
    .form-control, .form-select {
        border: 1px solid var(--border) !important;
        border-radius: 8px !important;
        font-family: 'Inter', sans-serif;
        font-size: 13.5px;
        color: var(--text);
        padding: 9px 12px;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
        background: white;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--primary) !important;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.12) !important;
        outline: none;
    }
    .form-control::placeholder { color: #CBD5E1; }

    .form-label {
        font-size: 12px; font-weight: 600;
        color: var(--text); margin-bottom: 5px;
        display: flex; align-items: center; gap: 5px;
    }
    .form-label i { color: var(--muted); font-size: 13px; }

    textarea.form-control { resize: vertical; min-height: 90px; }

    .readonly-field {
        background: #F8FAFC !important;
        color: var(--muted) !important;
        cursor: default;
    }

    /* Input with icon */
    .input-icon-wrap { position: relative; }
    .input-icon-wrap .bi {
        position: absolute;
        left: 11px; top: 50%;
        transform: translateY(-50%);
        color: var(--muted); font-size: 14px;
        pointer-events: none; z-index: 5;
    }
    .input-icon-wrap .form-control,
    .input-icon-wrap .form-select { padding-left: 34px !important; }

    .char-count {
        font-size: 11px; color: var(--muted);
        text-align: right; margin-top: 2px;
    }

    /* =============================================
       BUTTONS
    ============================================= */
    .btn {
        font-family: 'Inter', sans-serif;
        font-weight: 600; font-size: 13.5px;
        border-radius: 8px !important;
        padding: 9px 18px;
        transition: var(--transition);
        border: none !important;
        display: inline-flex; align-items: center; gap: 6px;
    }

    .btn-primary { background: var(--primary) !important; color: white !important; }
    .btn-primary:hover { background: var(--primary-hover) !important; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(37,99,235,0.35) !important; }

    .btn-success { background: var(--success) !important; color: white !important; }
    .btn-success:hover { background: #059669 !important; transform: translateY(-1px); }

    .btn-warning { background: var(--warning) !important; color: white !important; }
    .btn-warning:hover { background: #D97706 !important; transform: translateY(-1px); }

    .btn-danger { background: var(--danger) !important; color: white !important; }
    .btn-danger:hover { background: #DC2626 !important; }

    .btn-outline-secondary {
        border: 1.5px solid var(--border) !important;
        background: white !important; color: var(--text) !important;
    }
    .btn-outline-secondary:hover { border-color: #CBD5E1 !important; background: #F8FAFC !important; }

    .btn-light { background: #F1F5F9 !important; color: var(--text) !important; border: 1px solid var(--border) !important; }
    .btn-light:hover { background: #E2E8F0 !important; }

    .btn-sm { padding: 5px 12px !important; font-size: 12px !important; }
    .btn:active { transform: translateY(0) !important; }

    /* =============================================
       BADGES
    ============================================= */
    .badge {
        font-size: 11px !important; font-weight: 600 !important;
        padding: 3px 8px !important; border-radius: 6px !important;
        font-family: 'Inter', sans-serif;
        display: inline-flex; align-items: center; gap: 3px;
    }

    .status-badge { padding: 4px 10px !important; border-radius: 20px !important; }

    .badge-completed  { background: var(--success-light) !important; color: #059669 !important; }
    .badge-in-progress{ background: #EFF6FF !important; color: var(--primary) !important; }
    .badge-pending    { background: var(--warning-light) !important; color: #D97706 !important; }
    .badge-hold       { background: #F1F5F9 !important; color: var(--muted) !important; }

    .badge-high   { background: #FEF2F2 !important; color: #DC2626 !important; }
    .badge-medium { background: var(--warning-light) !important; color: #D97706 !important; }
    .badge-low    { background: var(--success-light) !important; color: #059669 !important; }

    /* =============================================
       TABLES
    ============================================= */
    .tbl-wrap {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        overflow: hidden;
        background: white;
    }

    .table { margin: 0 !important; font-size: 13.5px; }

    .table thead th {
        background: #F8FAFC !important;
        border-bottom: 1px solid var(--border) !important;
        color: var(--muted) !important;
        font-size: 11px !important; font-weight: 700 !important;
        text-transform: uppercase; letter-spacing: 0.06em;
        padding: 11px 16px !important;
        white-space: nowrap;
    }

    .table tbody td {
        padding: 13px 16px !important;
        border-bottom: 1px solid var(--border) !important;
        color: var(--text); vertical-align: middle;
    }
    .table tbody tr:last-child td { border-bottom: none !important; }
    .table tbody tr:hover td { background: #FAFAFA; }

    /* =============================================
       PAGE HEADER
    ============================================= */
    .page-header {
        display: flex; align-items: flex-start; justify-content: space-between;
        flex-wrap: wrap; gap: 12px;
        margin-bottom: 24px;
    }
    .page-title   { font-size: 20px; font-weight: 800; color: var(--text); margin: 0; }
    .page-subtitle{ font-size: 13px; color: var(--muted); margin: 2px 0 0; }
    .page-actions { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }

    /* =============================================
       TOASTS
    ============================================= */
    .toast-wrap {
        position: fixed; top: 76px; right: 20px;
        z-index: 9999; display: flex; flex-direction: column; gap: 8px;
    }

    .app-toast {
        min-width: 300px; max-width: 380px;
        background: white !important;
        border: none !important;
        border-radius: 10px !important;
        box-shadow: var(--shadow-lg) !important;
        font-family: 'Inter', sans-serif;
    }

    .toast-success-bar { border-left: 3px solid var(--success) !important; }
    .toast-error-bar   { border-left: 3px solid var(--danger)  !important; }
    .toast-body { padding: 14px 16px !important; font-size: 13.5px; font-weight: 500; }

    /* =============================================
       EMPTY STATE
    ============================================= */
    .empty-state { text-align: center; padding: 56px 24px; }
    .empty-state i { font-size: 44px; color: #CBD5E1; margin-bottom: 14px; display: block; }
    .empty-state h6 { font-size: 16px; font-weight: 700; color: var(--text); margin-bottom: 4px; }
    .empty-state p  { font-size: 13px; color: var(--muted); margin: 0; }

    /* =============================================
       WELCOME CARD (Dashboard)
    ============================================= */
    .welcome-card {
        background: linear-gradient(135deg, #0F172A 0%, #1E3A5F 60%, #1E3799 100%);
        color: white;
        border-radius: var(--radius) !important;
        padding: 28px 32px;
        margin-bottom: 24px;
        position: relative; overflow: hidden;
        border: none !important; box-shadow: none !important;
    }
    .welcome-card::before {
        content: '';
        position: absolute; top: -50px; right: -30px;
        width: 220px; height: 220px;
        background: rgba(255,255,255,0.04);
        border-radius: 50%; pointer-events: none;
    }
    .welcome-card::after {
        content: '';
        position: absolute; bottom: -70px; right: 100px;
        width: 160px; height: 160px;
        background: rgba(255,255,255,0.03);
        border-radius: 50%; pointer-events: none;
    }
    .welcome-title    { font-size: 22px; font-weight: 800; margin: 0 0 4px; }
    .welcome-subtitle { font-size: 13px; opacity: 0.65; margin: 0; }

    .welcome-date-badge {
        display: inline-flex; align-items: center; gap: 6px;
        background: rgba(255,255,255,0.12);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 20px; padding: 5px 14px;
        font-size: 12.5px; font-weight: 600; color: rgba(255,255,255,0.9);
    }

    /* =============================================
       QUICK ACTIONS
    ============================================= */
    .quick-action {
        display: flex; flex-direction: column; align-items: center; justify-content: center;
        gap: 8px; padding: 22px 16px;
        border: 1.5px dashed var(--border);
        border-radius: var(--radius);
        color: var(--muted); text-decoration: none;
        transition: var(--transition); cursor: pointer;
        background: white;
    }
    .quick-action:hover {
        border-color: var(--primary);
        background: var(--primary-light);
        color: var(--primary);
        transform: translateY(-2px);
        box-shadow: var(--shadow);
    }
    .quick-action i          { font-size: 26px; }
    .quick-action-label      { font-size: 13px; font-weight: 600; }
    .quick-action-sub        { font-size: 11.5px; opacity: 0.7; }

    /* =============================================
       TASK CARDS (Daily)
    ============================================= */
    .task-card-wrap {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: white;
        margin-bottom: 14px;
        overflow: hidden;
        transition: box-shadow 0.2s;
        animation: slideDown 0.25s ease;
    }
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .task-card-wrap:hover { box-shadow: var(--shadow); }

    .task-card-header {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 18px;
        background: #F8FAFC;
        border-bottom: 1px solid var(--border);
        cursor: pointer; user-select: none;
        transition: background 0.15s;
    }
    .task-card-header:hover { background: #F1F5F9; }

    .task-no-badge {
        width: 26px; height: 26px;
        border-radius: 7px;
        background: var(--primary);
        color: white; font-size: 12px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .task-card-title { font-weight: 600; font-size: 13.5px; color: var(--text); flex: 1; }

    .task-toggle-icon { color: var(--muted); font-size: 16px; transition: transform 0.2s; flex-shrink: 0; }
    .task-card-wrap.collapsed .task-toggle-icon { transform: rotate(-90deg); }
    .task-card-wrap.collapsed .task-card-body { display: none; }

    .task-remove-btn {
        border: none; background: none;
        color: var(--danger); cursor: pointer;
        font-size: 16px; width: 28px; height: 28px;
        border-radius: 6px; display: flex; align-items: center; justify-content: center;
        transition: var(--transition); flex-shrink: 0;
    }
    .task-remove-btn:hover { background: var(--danger-light); }

    .task-card-body { padding: 18px; }

    /* =============================================
       WEEKLY FORM
    ============================================= */
    .weekly-proj-card {
        border: 1px solid var(--border);
        border-radius: var(--radius);
        background: white;
        margin-bottom: 20px;
        overflow: hidden;
    }

    .weekly-proj-header {
        display: flex; align-items: center; gap: 12px;
        padding: 14px 20px;
        background: linear-gradient(to right, #EFF6FF, #F0F9FF);
        border-bottom: 1px solid var(--border);
    }

    .proj-icon {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: var(--primary);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 16px;
        flex-shrink: 0;
    }

    .week-range-badge {
        display: inline-flex; align-items: center; gap: 5px;
        background: linear-gradient(135deg, var(--primary), #7C3AED);
        color: white; border-radius: 20px;
        padding: 3px 12px; font-size: 12px; font-weight: 600;
    }

    .field-section {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
    }
    .field-section:last-child { border-bottom: none; }

    .field-section-title {
        font-size: 10.5px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.08em;
        color: var(--muted); margin-bottom: 12px;
        display: flex; align-items: center; gap: 6px;
    }

    .autofilled-badge {
        font-size: 9px; padding: 1px 5px;
        background: #F1F5F9; color: var(--muted);
        border-radius: 4px; font-weight: 700;
    }
    .editable-badge {
        font-size: 9px; padding: 1px 5px;
        background: var(--primary-light); color: var(--primary);
        border-radius: 4px; font-weight: 700;
    }

    /* =============================================
       STICKY SAVE BAR
    ============================================= */
    .sticky-save-bar {
        position: sticky; bottom: 24px;
        display: flex; justify-content: flex-end;
        z-index: 50; margin-top: 8px;
    }
    .sticky-save-inner {
        background: white;
        border-radius: 12px;
        padding: 12px 16px;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--border);
        display: flex; align-items: center; gap: 10px;
    }

    /* =============================================
       PROFILE
    ============================================= */
    .profile-avatar-lg {
        width: 72px; height: 72px;
        border-radius: 18px;
        background: linear-gradient(135deg, #2563EB 0%, #7C3AED 100%);
        display: flex; align-items: center; justify-content: center;
        color: white; font-size: 28px; font-weight: 800;
        box-shadow: 0 8px 20px rgba(37,99,235,0.3);
    }

    /* =============================================
       PAGINATION
    ============================================= */
    .pagination { font-family: 'Inter', sans-serif; font-size: 13px; gap: 3px; flex-wrap: wrap; }
    .page-link {
        border: 1px solid var(--border) !important;
        color: var(--text) !important;
        border-radius: 8px !important;
        padding: 6px 12px !important;
        background: white !important;
        transition: var(--transition);
    }
    .page-link:hover {
        background: var(--primary-light) !important;
        border-color: var(--primary) !important;
        color: var(--primary) !important;
    }
    .page-item.active .page-link {
        background: var(--primary) !important;
        border-color: var(--primary) !important;
        color: white !important;
    }
    .page-item.disabled .page-link { opacity: 0.4 !important; }

    /* =============================================
       PROGRESS
    ============================================= */
    .progress { height: 6px; border-radius: 3px; background: var(--border); }
    .progress-bar { border-radius: 3px; }

    /* =============================================
       MISC
    ============================================= */
    a { transition: color 0.15s; }
    .section-hr { border: none; border-top: 1px solid var(--border); margin: 28px 0; }

    .text-primary { color: var(--primary) !important; }
    .text-success { color: var(--success) !important; }
    .text-warning { color: var(--warning) !important; }
    .text-danger  { color: var(--danger)  !important; }
    .text-muted   { color: var(--muted)   !important; }

    .bg-primary-soft { background: var(--primary-light) !important; }
    .bg-success-soft { background: var(--success-light) !important; }
    .bg-warning-soft { background: var(--warning-light) !important; }
    .bg-danger-soft  { background: var(--danger-light)  !important; }

    .fw-500 { font-weight: 500; }
    .fw-600 { font-weight: 600; }
    .fw-700 { font-weight: 700; }
    .fw-800 { font-weight: 800; }

    /* Activity item */
    .activity-item {
        display: flex; gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid var(--border);
    }
    .activity-item:last-child { border-bottom: none; }
    .activity-dot {
        width: 8px; height: 8px;
        border-radius: 50%;
        background: var(--primary);
        margin-top: 6px; flex-shrink: 0;
    }
    .activity-title { font-size: 13px; font-weight: 500; color: var(--text); }
    .activity-meta  { font-size: 11.5px; color: var(--muted); margin-top: 1px; }

    /* Edit page readonly info */
    .info-field {
        background: #F8FAFC;
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 9px 12px;
        font-size: 13.5px;
        color: var(--text);
        font-family: 'Inter', sans-serif;
    }

    .info-field strong { color: var(--primary); }

    /* Filter row */
    .filter-row {
        display: flex; align-items: center; gap: 10px;
        flex-wrap: wrap;
    }
    .filter-row .form-select,
    .filter-row .form-control { max-width: 180px; }
    </style>
</head>
<body>

@auth

{{-- ===== TOAST NOTIFICATIONS ===== --}}
<div class="toast-wrap">
    @if(session('success'))
    <div class="toast app-toast toast-success-bar show" role="alert" aria-atomic="true">
        <div class="d-flex align-items-center toast-body gap-3">
            <i class="bi bi-check-circle-fill text-success fs-5 flex-shrink-0"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="btn-close ms-auto flex-shrink-0" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
    @if(session('error'))
    <div class="toast app-toast toast-error-bar show" role="alert" aria-atomic="true">
        <div class="d-flex align-items-center toast-body gap-3">
            <i class="bi bi-exclamation-circle-fill text-danger fs-5 flex-shrink-0"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="btn-close ms-auto flex-shrink-0" data-bs-dismiss="toast"></button>
        </div>
    </div>
    @endif
</div>

{{-- ===== MOBILE OVERLAY ===== --}}
<div class="sidebar-overlay" id="sidebarOverlay"></div>

{{-- ===== NAVBAR ===== --}}
@include('partials.navbar')

{{-- ===== MAIN WRAPPER ===== --}}
<div class="app-wrapper">
    @include('partials.sidebar')
    <div class="app-content">
        @yield('content')
    </div>
</div>

@endauth

@guest
@yield('content')
@endguest

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function () {
    // Sidebar toggle (mobile)
    var sidebar = document.querySelector('.app-sidebar');
    var overlay = document.getElementById('sidebarOverlay');
    var toggle  = document.getElementById('sidebarToggle');

    function openSidebar() {
        if (sidebar) sidebar.classList.add('open');
        if (overlay) overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        if (sidebar) sidebar.classList.remove('open');
        if (overlay) overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    if (toggle)  toggle.addEventListener('click', openSidebar);
    if (overlay) overlay.addEventListener('click', closeSidebar);

    // Auto-dismiss toasts
    document.querySelectorAll('.toast.show').forEach(function (el) {
        new bootstrap.Toast(el, { delay: 4500 }).show();
    });
})();
</script>

@stack('scripts')

</body>
</html>

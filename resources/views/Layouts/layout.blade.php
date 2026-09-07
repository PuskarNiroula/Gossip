<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Chat App')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="{{asset('/js/sweet-alert-2.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('/css/sweet-alert-2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('/css/group-chat.css')}}">
    @vite('resources/js/app.js')

    <script src="{{asset('/js/jquery.js')}}"></script>
    <style>
        :root {
            --wa-bg-app: #0b141a;
            --wa-bg-nav: #202c33;
            --wa-bg-hover: #2a3942;
            --wa-bg-active: rgba(0, 168, 132, .16);
            --wa-border: #2a3942;
            --wa-green: #00a884;
            --wa-green-dim: #06cf9c;
            --wa-text-primary: #e9edef;
            --wa-text-secondary: #aebac1;
            --wa-text-muted: #8696a0;
            --wa-danger: #f15c6d;
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
            overflow: hidden;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", "Helvetica Neue", Helvetica, Arial, sans-serif;
            background: var(--wa-bg-app);
            -webkit-font-smoothing: antialiased;
        }

        .wa-shell {
            display: flex;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
        }

        .wa-nav {
            width: 64px;
            background: var(--wa-bg-nav);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 14px 0;
            gap: 0;
            flex-shrink: 0;
            border-right: 1px solid var(--wa-border);
            box-shadow: 2px 0 8px rgba(0, 0, 0, .18);
            z-index: 10;
        }

        .wa-nav-top {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
            flex: 1;
        }

        .wa-nav-bottom {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .wa-nav a,
        .wa-nav button {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            color: var(--wa-text-secondary);
            background: transparent;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: background .18s ease, color .18s ease, transform .12s ease;
            position: relative;
        }

        .wa-nav a:hover,
        .wa-nav button:hover {
            background: var(--wa-bg-hover);
            color: var(--wa-text-primary);
        }

        .wa-nav a:active,
        .wa-nav button:active {
            transform: scale(.92);
        }

        .wa-nav a:focus-visible,
        .wa-nav button:focus-visible {
            outline: 2px solid var(--wa-green);
            outline-offset: 2px;
        }

        .wa-nav a.active {
            color: var(--wa-green-dim);
            background: var(--wa-bg-active);
        }

        .wa-nav a.active::before {
            content: "";
            position: absolute;
            left: -14px;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            border-radius: 0 3px 3px 0;
            background: var(--wa-green);
        }

        .wa-nav a i,
        .wa-nav button i {
            font-size: 21px;
            line-height: 1;
        }

        .wa-nav-divider {
            width: 32px;
            height: 1px;
            background: var(--wa-border);
            margin: 8px 0;
        }

        .wa-nav [title]:hover::after {
            content: attr(title);
            position: absolute;
            left: 58px;
            top: 50%;
            transform: translateY(-50%);
            background: #233138;
            color: var(--wa-text-primary);
            font-size: 12.5px;
            font-weight: 500;
            letter-spacing: .1px;
            padding: 6px 12px;
            border-radius: 6px;
            white-space: nowrap;
            pointer-events: none;
            z-index: 999;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .35);
            animation: waTooltipIn .12s ease;
        }

        @keyframes waTooltipIn {
            from { opacity: 0; transform: translateY(-50%) translateX(-4px); }
            to   { opacity: 1; transform: translateY(-50%) translateX(0); }
        }

        .settings-wrap {
            position: relative;
        }

        .settings-dropdown {
            display: none;
            position: absolute;
            left: 56px;
            bottom: 0;
            background: #233138;
            border: 1px solid var(--wa-border);
            border-radius: 10px;
            min-width: 228px;
            max-height: 300px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 9999;
            box-shadow: 6px 6px 24px rgba(0, 0, 0, .45);
            padding: 6px;
            animation: waMenuIn .16s ease;
        }

        @keyframes waMenuIn {
            from { opacity: 0; transform: translateY(6px) scale(.98); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .settings-dropdown a {
            display: flex !important;
            align-items: center;
            padding: 11px 14px;
            font-size: 13.5px;
            color: var(--wa-text-secondary);
            text-decoration: none;
            border-radius: 8px !important;
            width: 100% !important;
            height: auto !important;
            min-height: 44px;
            white-space: nowrap;
            transition: background .15s ease, color .15s ease;
        }

        .settings-dropdown a:hover {
            background: var(--wa-bg-hover);
            color: var(--wa-text-primary);
        }

        .settings-dropdown a i {
            font-size: 16px;
            width: 20px;
            text-align: center;
            color: var(--wa-text-muted);
        }

        .settings-dropdown a:hover i {
            color: var(--wa-green-dim);
        }

        .settings-dropdown::-webkit-scrollbar {
            width: 6px;
        }

        .settings-dropdown::-webkit-scrollbar-thumb {
            background: #52616a;
            border-radius: 10px;
        }

        .settings-dropdown::-webkit-scrollbar-track {
            background: transparent;
        }

        .wa-nav-bottom form button:hover {
            color: var(--wa-danger);
            background: rgba(241, 92, 109, .12);
        }

        .wa-content {
            flex: 1;
            min-width: 0;
            overflow: hidden;
            display: flex;
            background: var(--wa-bg-app);
        }

        .wa-content > * {
            flex: 1;
            min-width: 0;
        }
    </style>
    @yield('styles')
</head>
<body>

<div class="wa-shell">

    <nav class="wa-nav">
        <div class="wa-nav-top">
            <button type="button"
                    id="chatSidebarToggle"
                    class="sidebar-toggle-btn"
                    title="Hide Chats">
                <i class="bi bi-layout-sidebar-inset"></i>
            </button>

            <a href="/dashboard" title="Chats" class="{{ request()->is('dashboard') ? 'active' : '' }}">
                <i class="bi bi-chat-dots-fill"></i>
            </a>
            <a href="/profile" title="Profile">
                <i class="bi bi-person-circle"></i>
            </a>
        </div>

        <div class="wa-nav-bottom">
            <div class="wa-nav-divider"></div>

            <div class="settings-wrap">
                <a href="javascript:void(0);" id="settingsToggle" title="Settings">
                    <i class="bi bi-gear-fill"></i>
                </a>
                <div class="settings-dropdown" id="settingsDropdown">
                    <a href="/change-password"><i class="bi bi-key me-2"></i>Change Password</a>
                    <a href="/change-email"><i class="bi bi-envelope me-2"></i>Change Email</a>
                    <a href="/recovery"><i class="bi bi-shield-lock me-2"></i> Create Recovery Password</a>
                </div>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Logout">
                    <i class="bi bi-power"></i>
                </button>
            </form>
        </div>
    </nav>

    <div class="wa-content">
        @yield('content')
    </div>
</div>

<script src="{{asset('/js/script.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const toggle = document.getElementById('settingsToggle');
    const dropdown = document.getElementById('settingsDropdown');

    toggle.addEventListener('click', (e) => {
        e.stopPropagation();
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    window.addEventListener('click', (e) => {
        if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.style.display = 'none';
        }
    });
</script>

@yield('scripts')
</body>
</html>

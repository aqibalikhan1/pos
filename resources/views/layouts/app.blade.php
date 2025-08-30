<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'POS System') }} - @yield('title')</title>
    
    <!-- Material Design Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- All CSS and JS via npm/Vite -->
    @vite(['resources/css/app.css', 'resources/css/material-theme.css', 'resources/css/datatables.css', 'resources/js/app.js', 'resources/js/datatables.js'])
</head>
<body class="mdc-typography">
    <div class="app-container">
        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <h3 class="sidebar-title">POS System</h3>
            </div>
            <ul class="sidebar-nav">
                <li class="sidebar-nav-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">dashboard</i>
                        Dashboard
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('pos.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('pos.dashboard') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">point_of_sale</i>
                        POS
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="{{ route('products.index') }}" class="sidebar-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">inventory</i>
                        Products
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="material-icons sidebar-nav-icon">people</i>
                        Customers
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="material-icons sidebar-nav-icon">assessment</i>
                        Reports
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="material-icons sidebar-nav-icon">settings</i>
                        Settings
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Scripts -->
    <script>
        // Initialize Material Components
        mdc.autoInit();
        
        // Initialize DataTables
        $(document).ready(function() {
            if ($('.data-table').length) {
                $('.data-table').DataTable({
                    responsive: true,
                    language: {
                        search: "Search:",
                        lengthMenu: "Show _MENU_ entries per page",
                        info: "Showing _START_ to _END_ of _TOTAL_ entries"
                    }
                });
            }
        });
    </script>
    
    @stack('scripts')
    
</body>
</html>

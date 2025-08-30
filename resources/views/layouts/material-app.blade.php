<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'POS System') }} - @yield('title')</title>
    
    <!-- Material Design Fonts via npm -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    <!-- All CSS and JS via npm/Vite -->
    @vite(['resources/css/app.css', 'resources/css/material-theme.css', 'resources/css/datatables.css', 'resources/js/app.js', 'resources/js/datatables.js'])
</head>
<body class="mdc-typography">
    <div class="app-container">
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle md:hidden fixed top-4 left-4 z-50 bg-white p-2 rounded shadow">
            <i class="material-icons">menu</i>
        </button>

        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <div class="flex items-center justify-between">
                    <h3 class="sidebar-title">POS System</h3>
                    <button id="sidebar-toggle" class="sidebar-toggle" title="Toggle Menu">
                        <i class="material-icons">chevron_left</i>
                    </button>
                    <button class="mobile-menu-close md:hidden">
                        <i class="material-icons">close</i>
                    </button>
                </div>
            </div>
            
            <ul class="sidebar-nav">
                <li class="sidebar-nav-item">
                    <a href="{{ route('dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">dashboard</i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('pos.terminal') }}" class="sidebar-nav-link {{ request()->routeIs('pos.terminal') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">point_of_sale</i>
                        <span>POS Terminal</span>
                    </a>
                </li>
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('pos.dashboard') }}" class="sidebar-nav-link {{ request()->routeIs('pos.dashboard') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">dashboard</i>
                        <span>POS Dashboard</span>
                    </a>
                </li>
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('products.index') }}" class="sidebar-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">inventory</i>
                        <span>Products</span>
                    </a>
                </li>
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('categories.index') }}" class="sidebar-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">category</i>
                        <span>Categories</span>
                    </a>
                </li>
                
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('purchases.index') }}" class="sidebar-nav-link {{ request()->routeIs('purchases.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">payments</i>
                        <span>Purchase</span>
                    </a>
                </li>
                
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('expenses.index') }}" class="sidebar-nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">paid</i>
                        <span>Expenses</span>
                    </a>
                </li>
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('employees.index') }}" class="sidebar-nav-link {{ request()->routeIs('employees.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">people</i>
                        <span>Employees</span>
                    </a>
                </li>

                <li class="sidebar-nav-item">
                    <a href="{{ route('towns.index') }}" class="sidebar-nav-link {{ request()->routeIs('towns.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">corporate_fare</i>
                        <span>Towns</span>
                    </a>
                </li>
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('companies.index') }}" class="sidebar-nav-link {{ request()->routeIs('companies.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">business</i>
                        <span>Companies</span>
                    </a>
                </li>
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('customers.index') }}" class="sidebar-nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">people</i>
                        <span>Customers</span>
                    </a>
                </li>
                
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('suppliers.index') }}" class="sidebar-nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">local_shipping</i>
                        <span>Suppliers</span>
                    </a>
                </li>
                
                
                <li class="sidebar-nav-item">
                    <a href="{{ route('routes.index') }}" class="sidebar-nav-link {{ request()->routeIs('routes.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">route</i>
                        <span>Routes</span>
                    </a>
                </li>
                
                <li class="sidebar-nav-item has-submenu {{ request()->routeIs('accounts.*') ? 'open' : '' }}">
                    <a href="#" class="sidebar-nav-link {{ request()->routeIs('accounts.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">account_balance</i>
                        <span>Accounts</span>
                    </a>
                    <ul class="sidebar-submenu {{ request()->routeIs('accounts.*') ? 'open' : '' }}">
                        <li class="sidebar-submenu-item">
                            <a href="{{ route('accounts.index') }}" class="sidebar-submenu-link {{ request()->routeIs('accounts.index') || request()->routeIs('accounts.show') || request()->routeIs('accounts.create') || request()->routeIs('accounts.edit') ? 'active' : '' }}">
                                <i class="material-icons sidebar-nav-icon" style="font-size: 1rem; margin-right: 0.5rem;">account_balance_wallet</i>
                                <span>Accounts Management</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-item">
                            <a href="{{ route('accounts.transactions.index') }}" class="sidebar-submenu-link {{ request()->routeIs('accounts.transactions.*') ? 'active' : '' }}">
                                <i class="material-icons sidebar-nav-icon" style="font-size: 1rem; margin-right: 0.5rem;">receipt</i>
                                <span>Transactions</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-item">
                            <a href="{{ route('accounts.credit-sales.index') }}" class="sidebar-submenu-link {{ request()->routeIs('accounts.credit-sales.*') ? 'active' : '' }}">
                                <i class="material-icons sidebar-nav-icon" style="font-size: 1rem; margin-right: 0.5rem;">shopping_cart</i>
                                <span>Credit Sales</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-item">
                            <a href="{{ route('accounts.supplier-payments.index') }}" class="sidebar-submenu-link {{ request()->routeIs('accounts.supplier-payments.*') ? 'active' : '' }}">
                                <i class="material-icons sidebar-nav-icon" style="font-size: 1rem; margin-right: 0.5rem;">payment</i>
                                <span>Supplier Payments</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-item">
                            <a href="{{ route('credit-notes.index') }}" class="sidebar-submenu-link {{ request()->routeIs('credit-notes.*') ? 'active' : '' }}">
                                <i class="material-icons sidebar-nav-icon" style="font-size: 1rem; margin-right: 0.5rem;">receipt_long</i>
                                <span>Credit Notes</span>
                            </a>
                        </li>
                    </ul>
                </li>
                
                <li class="sidebar-nav-item">
                    <a href="#" class="sidebar-nav-link">
                        <i class="material-icons sidebar-nav-icon">assessment</i>
                        <span>Reports</span>
                    </a>
                </li>
                
                <li class="sidebar-nav-item has-submenu {{ request()->routeIs('settings.*') ? 'open' : '' }}">
                    <a href="#" class="sidebar-nav-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                        <i class="material-icons sidebar-nav-icon">settings</i>
                        <span>Settings</span>
                    </a>
                    <ul class="sidebar-submenu {{ request()->routeIs('settings.*') ? 'open' : '' }}">
                        <li class="sidebar-submenu-item">
                            <a href="{{ route('settings.tax-types.index') }}" class="sidebar-submenu-link {{ request()->routeIs('settings.tax-types.*') ? 'active' : '' }}">
                                <i class="material-icons sidebar-nav-icon" style="font-size: 1rem; margin-right: 0.5rem;">receipt_long</i>
                                <span>Tax Types</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-item">
                            <a href="{{ route('settings.tax-rates.index') }}" class="sidebar-submenu-link {{ request()->routeIs('settings.tax-rates.*') ? 'active' : '' }}">
                                <i class="material-icons sidebar-nav-icon" style="font-size: 1rem; margin-right: 0.5rem;">percent</i>
                                <span>Tax Rates</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-item">
                            <a href="{{ route('settings.tax-configuration') }}" class="sidebar-submenu-link {{ request()->routeIs('settings.tax-configuration') ? 'active' : '' }}">
                                <i class="material-icons sidebar-nav-icon" style="font-size: 1rem; margin-right: 0.5rem;">tune</i>
                                <span>Tax Configuration</span>
                            </a>
                        </li>
                        <li class="sidebar-submenu-item">
                            <a href="{{ route('settings.currency-settings.index') }}" class="sidebar-submenu-link {{ request()->routeIs('currency-settings.*') ? 'active' : '' }}">
                                <i class="material-icons sidebar-nav-icon" style="font-size: 1rem; margin-right: 0.5rem;">attach_money</i>
                                <span>Currencies</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
            
            <!-- User Profile Section -->
            <div class="sidebar-footer mt-auto p-4 border-t">
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                        <i class="material-icons text-white text-sm">person</i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">{{ auth()->user()->name ?? 'User' }}</p>
                        <p class="text-xs text-gray-500">{{ auth()->user()->email ?? 'user@example.com' }}</p>
                    </div>
                </div>
                
                <!-- Profile and Logout Buttons -->
                <div class="space-y-2">
                    <a href="{{ route('profile.show') }}" class="w-full flex items-center space-x-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-md transition-colors">
                        <i class="material-icons text-sm">account_circle</i>
                        <span>Profile</span>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="w-full flex items-center space-x-2 px-3 py-2 text-sm text-red-600 hover:bg-red-50 rounded-md transition-colors">
                            <i class="material-icons text-sm">logout</i>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Top Bar -->
            <div class="top-bar">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">@yield('page-title', 'Dashboard')</h1>
                    <nav class="text-sm text-gray-500 mt-1">
                        <ol class="list-none p-0 inline-flex">
                            <li class="flex items-center">
                                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Home</a>
                                @if(request()->route()->getName() !== 'dashboard')
                                    <i class="material-icons text-gray-400 mx-2" style="font-size: 16px;">chevron_right</i>
                                    <span class="text-gray-700">@yield('breadcrumb', ucfirst(request()->route()->getName()))</span>
                                @endif
                            </li>
                        </ol>
                    </nav>
                </div>
                
                <!-- Right-aligned action bar with dark mode, notifications, and user menu -->
                <div class="flex items-center space-x-2">
                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-full hover:bg-gray-100 transition-colors" title="Toggle dark mode">
                        <i class="material-icons text-gray-600 dark:text-gray-300">brightness_6</i>
                    </button>
                    
                    <!-- Notifications -->
                    <button class="p-2 rounded-full hover:bg-gray-100 transition-colors relative" title="Notifications">
                        <i class="material-icons text-gray-600 dark:text-gray-300">notifications</i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </button>
                    
                    <!-- User Profile & Sign Out -->
                    <div class="relative" id="user-menu">
                        <button class="flex items-center space-x-2 p-2 rounded-full hover:bg-gray-100 transition-colors" id="user-menu-button">
                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                <i class="material-icons text-white text-sm">person</i>
                            </div>
                            <i class="material-icons text-gray-500">arrow_drop_down</i>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div id="user-menu-dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                            <div class="py-1">
                                <a href="{{ route('profile.show') }}" class="flex items-center space-x-2 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="material-icons text-sm">account_circle</i>
                                    <span>Profile</span>
                                </a>
                                
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center space-x-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="material-icons text-sm">logout</i>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="content-area">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Material Components
            if (typeof mdc !== 'undefined') {
                mdc.autoInit();
            }

            // Mobile Menu Toggle
            const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
            const mobileMenuClose = document.querySelector('.mobile-menu-close');
            const sidebar = document.querySelector('.sidebar');

            if (mobileMenuToggle) {
                mobileMenuToggle.addEventListener('click', () => {
                    sidebar.classList.add('open');
                });
            }

            if (mobileMenuClose) {
                mobileMenuClose.addEventListener('click', () => {
                    sidebar.classList.remove('open');
                });
            }

            // Theme Toggle
            const themeToggle = document.getElementById('theme-toggle');
            const html = document.documentElement;

            themeToggle.addEventListener('click', () => {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'light' ? 'dark' : 'light';
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
            });

            // Load saved theme
            const savedTheme = localStorage.getItem('theme') || 'light';
            html.setAttribute('data-theme', savedTheme);

            // Initialize DataTables
            // DataTables will be initialized via the imported datatables.js

            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', (e) => {
                if (window.innerWidth <= 768 && sidebar && !sidebar.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                    sidebar.classList.remove('open');
                }
            });

            // User Menu Dropdown
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenuDropdown = document.getElementById('user-menu-dropdown');
            const userMenu = document.getElementById('user-menu');

            if (userMenuButton && userMenuDropdown) {
                userMenuButton.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userMenuDropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', (e) => {
                    if (!userMenu.contains(e.target)) {
                        userMenuDropdown.classList.add('hidden');
                    }
                });

                // Close dropdown when pressing Escape
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        userMenuDropdown.classList.add('hidden');
                    }
                });
            }

            // Submenu Toggle Functionality
            const submenuItems = document.querySelectorAll('.sidebar-nav-item.has-submenu');

            submenuItems.forEach(item => {
                const link = item.querySelector('.sidebar-nav-link');
                const submenu = item.querySelector('.sidebar-submenu');

                if (link && submenu) {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();

                        // Toggle current submenu
                        item.classList.toggle('open');
                        submenu.classList.toggle('open');

                        // Close other submenus (optional)
                        submenuItems.forEach(otherItem => {
                            if (otherItem !== item) {
                                otherItem.classList.remove('open');
                                const otherSubmenu = otherItem.querySelector('.sidebar-submenu');
                                if (otherSubmenu) {
                                    otherSubmenu.classList.remove('open');
                                }
                            }
                        });
                    });
                }
            });

            // Sidebar Toggle Functionality
            console.log('Starting sidebar toggle setup');
            const sidebarToggle = document.getElementById('sidebar-toggle');
            console.log('sidebarToggle:', sidebarToggle);
            const sidebarElement = document.querySelector('.sidebar');
            console.log('sidebarElement:', sidebarElement);
            const mainContentElement = document.querySelector('.main-content');
            console.log('mainContentElement:', mainContentElement);
            
            if (sidebarToggle && sidebarElement && mainContentElement) {
                console.log('Sidebar toggle, sidebar, and main content found');
                // Load saved sidebar state
                const isCollapsed = localStorage.getItem('sidebar-collapsed') === 'true';
                console.log('Loaded sidebar collapsed state:', isCollapsed);
                if (isCollapsed) {
                    sidebarElement.classList.add('sidebar-collapsed');
                    mainContentElement.classList.add('main-content-collapsed');
                }

                sidebarToggle.addEventListener('click', () => {
                    console.log('Sidebar toggle clicked');
                    sidebarElement.classList.toggle('sidebar-collapsed');
                    mainContentElement.classList.toggle('main-content-collapsed');
                    const collapsed = sidebarElement.classList.contains('sidebar-collapsed');
                    console.log('Sidebar collapsed state after toggle:', collapsed);
                    localStorage.setItem('sidebar-collapsed', collapsed);
                });
            } else {
                console.log('Sidebar toggle, sidebar, or main content not found');
            }
        });
    </script>
    
    
    @stack('scripts')
</body>
</html>
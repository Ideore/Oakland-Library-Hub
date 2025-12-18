<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Dashboard') - Oakland Library Hub</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Flowbite CSS -->
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Dark mode script to prevent FOUC -->
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
    
    <style>
        /* Base font size reset */
        html {
            font-size: 14px;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        /* Light theme variables */
        :root {
            --bg-primary: #f9fafb;
            --bg-secondary: #ffffff;
            --bg-tertiary: #f3f4f6;
            --bg-hover: #e5e7eb;
            --text-primary: #111827;
            --text-secondary: #6b7280;
            --border-color: #e5e7eb;
            --accent-color: #2bf8bd;
            --accent-hover: #1dd1a1;
            --accent-light: #a7f3d0;
        }

        /* Dark theme variables */
        .dark {
            --bg-primary: #111827;
            --bg-secondary: #1f2937;
            --bg-tertiary: #374151;
            --bg-hover: #374151;
            --text-primary: #f9fafb;
            --text-secondary: #9ca3af;
            --border-color: #4b5563;
            --accent-color: #2bf8bd;
            --accent-hover: #1dd1a1;
            --accent-light: #065f46;
        }

        /* Theme transition */
        * {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        /* Dynamic Badge Colors */
        :root {
            /* Light mode badge colors */
            --badge-available-bg: #d1fae5;
            --badge-available-text: #059669;
            --badge-available-border: #a7f3d0;
            
            --badge-unavailable-bg: #fef3c7;
            --badge-unavailable-text: #d97706;
            --badge-unavailable-border: #fde68a;
            
            --badge-overdue-bg: #fecaca;
            --badge-overdue-text: #dc2626;
            --badge-overdue-border: #fca5a5;
            
            --badge-returned-late-bg: #fed7aa;
            --badge-returned-late-text: #ea580c;
            --badge-returned-late-border: #fdba74;
            
            --badge-returned-bg: #d1fae5;
            --badge-returned-text: #059669;
            --badge-returned-border: #a7f3d0;
            
            --badge-borrowed-bg: #dbeafe;
            --badge-borrowed-text: #2563eb;
            --badge-borrowed-border: #bfdbfe;
        }

        .dark {
            /* Dark mode badge colors */
            --badge-available-bg: #064e3b;
            --badge-available-text: #6ee7b7;
            --badge-available-border: #047857;
            
            --badge-unavailable-bg: #78350f;
            --badge-unavailable-text: #fcd34d;
            --badge-unavailable-border: #92400e;
            
            --badge-overdue-bg: #7f1d1d;
            --badge-overdue-text: #fca5a5;
            --badge-overdue-border: #991b1b;
            
            --badge-returned-late-bg: #7c2d12;
            --badge-returned-late-text: #fdba74;
            --badge-returned-late-border: #9a3412;
            
            --badge-returned-bg: #064e3b;
            --badge-returned-text: #6ee7b7;
            --badge-returned-border: #047857;
            
            --badge-borrowed-bg: #78350f;
            --badge-borrowed-text: #fcd34d;
            --badge-borrowed-border: #92400e;
        }

        /* Badge classes using CSS variables */
        .badge-available {
            background-color: var(--badge-available-bg) !important;
            color: var(--badge-available-text) !important;
            border: 1px solid var(--badge-available-border) !important;
        }

        .badge-unavailable {
            background-color: var(--badge-unavailable-bg) !important;
            color: var(--badge-unavailable-text) !important;
            border: 1px solid var(--badge-unavailable-border) !important;
        }

        .badge-overdue {
            background-color: var(--badge-overdue-bg) !important;
            color: var(--badge-overdue-text) !important;
            border: 1px solid var(--badge-overdue-border) !important;
        }

        .badge-returned-late {
            background-color: var(--badge-returned-late-bg) !important;
            color: var(--badge-returned-late-text) !important;
            border: 1px solid var(--badge-returned-late-border) !important;
        }

        .badge-returned {
            background-color: var(--badge-returned-bg) !important;
            color: var(--badge-returned-text) !important;
            border: 1px solid var(--badge-returned-border) !important;
        }

        .badge-borrowed {
            background-color: var(--badge-borrowed-bg) !important;
            color: var(--badge-borrowed-text) !important;
            border: 1px solid var(--badge-borrowed-border) !important;
        }

        /* Pagination button overrides for light mode */
        :root {
            --pagination-bg: #f3f4f6;
            --pagination-text: #6b7280;
            --pagination-border: #d1d5db;
            --pagination-hover-bg: #e5e7eb;
            --pagination-hover-text: #374151;
            --pagination-active-bg: #9ca3af;
            --pagination-active-text: #ffffff;
        }

        .dark {
            --pagination-bg: #374151;
            --pagination-text: #9ca3af;
            --pagination-border: #4b5563;
            --pagination-hover-bg: #4b5563;
            --pagination-hover-text: #ffffff;
            --pagination-active-bg: #4b5563;
            --pagination-active-text: #ffffff;
        }

        /* Override pagination button colors */
        .bg-gray-700 {
            background-color: var(--pagination-bg) !important;
        }

        .text-gray-400 {
            color: var(--pagination-text) !important;
        }

        .border-gray-600 {
            border-color: var(--pagination-border) !important;
        }

        .hover\:bg-gray-600:hover {
            background-color: var(--pagination-hover-bg) !important;
        }

        .hover\:text-white:hover {
            color: var(--pagination-hover-text) !important;
        }

        .bg-gray-600 {
            background-color: var(--pagination-active-bg) !important;
        }



        /* Override hardcoded classes with CSS variables */
        body {
            background-color: var(--bg-primary) !important;
        }
        
        .bg-gray-900 {
            background-color: var(--bg-primary) !important;
        }
        
        .bg-gray-800 {
            background-color: var(--bg-secondary) !important;
        }
        
        .bg-gray-700 {
            background-color: var(--bg-tertiary) !important;
        }
        
        .text-white {
            color: var(--text-primary) !important;
        }
        
        .text-gray-400 {
            color: var(--text-secondary) !important;
        }
        
        .border-gray-700 {
            border-color: var(--border-color) !important;
        }
        
        /* Sidebar hover colors */
        .hover\:bg-gray-700:hover {
            background-color: var(--bg-hover) !important;
        }
        
        /* Table hover colors */
        table tbody tr:hover {
            background-color: var(--bg-hover) !important;
        }
        
        /* Table specific overrides */
        table thead {
            background-color: var(--bg-tertiary) !important;
        }
        
        table tbody tr:hover {
            background-color: var(--bg-tertiary) !important;
        }
        
        /* Input overrides */
        input[type="text"], input[type="email"], input[type="password"], select {
            background-color: var(--bg-tertiary) !important;
            color: var(--text-primary) !important;
            border-color: var(--border-color) !important;
        }
        
        /* Modal overrides */
        .modal-content {
            background-color: var(--bg-secondary) !important;
        }
        
        /* Accent color overrides - Using #2bf8bd */
        .bg-teal-600, .bg-\[#3aa08cff\], .bg-\[#26aa90ff\] {
            background-color: #2bf8bd !important;
        }
        
        .bg-teal-700 {
            background-color: #1dd1a1 !important;
        }
        
        .text-teal-100 {
            color: #a7f3d0 !important;
        }
        
        /* Button accent colors */
        .bg-blue-600, .bg-blue-700, .bg-\[#3aa08cff\] {
            background-color: #2bf8bd !important;
        }
        
        .hover\:bg-blue-700:hover {
            background-color: #1dd1a1 !important;
        }
        
        /* Focus ring colors */
        .focus\:ring-blue-300:focus {
            --tw-ring-color: #a7f3d0 !important;
        }
        
        .focus\:border-blue-500:focus {
            border-color: #2bf8bd !important;
        }
        
        .focus\:ring-blue-500:focus {
            --tw-ring-color: #2bf8bd !important;
        }
        
        /* Green status badges */
        .bg-green-600, .bg-green-700 {
            background-color: #2bf8bd !important;
        }
        
        .text-green-300, .text-green-400 {
            color: #2bf8bd !important;
        }
    </style>
    
    @stack('styles')
</head>
<body class="antialiased bg-gray-900 dark:bg-gray-900 mt-20 transition-colors duration-300">
    
    <!-- Navbar -->
    <nav class="bg-gray-800 dark:bg-gray-800 bg-white border-b border-gray-700 dark:border-gray-700 border-gray-200 px-4 py-3 fixed left-0 right-0 top-0 z-50">
        <div class="flex flex-wrap justify-between items-center">
            <div class="flex justify-start items-center">
                <!-- Mobile menu toggle -->
                <button
                    data-drawer-target="drawer-navigation"
                    data-drawer-toggle="drawer-navigation"
                    aria-controls="drawer-navigation"
                    class="p-2 mr-2 text-gray-400 dark:text-gray-400 text-gray-600 rounded-lg cursor-pointer md:hidden hover:text-white dark:hover:text-white hover:text-gray-900 hover:bg-gray-700 dark:hover:bg-gray-700 hover:bg-gray-100 focus:bg-gray-700 dark:focus:bg-gray-700 focus:bg-gray-100 focus:ring-2 focus:ring-gray-700 dark:focus:ring-gray-700 focus:ring-gray-300"
                >
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Toggle sidebar</span>
                </button>
                
                <!-- Logo -->
                <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" class="flex items-center justify-between mr-4">
                    <img src="{{ asset('assets/book.png') }}" alt="Oakland Library Hub Logo" class="h-8 w-8">
                    <span class="self-center text-2xl font-semibold whitespace-nowrap text-white dark:text-white text-gray-900 ml-2">Oakland Library Hub</span>
                </a>
            </div>
            
            <div class="flex items-center lg:order-2 gap-2">
                <!-- Theme Toggle -->
                <button
                    id="theme-toggle"
                    type="button"
                    class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-100 focus:outline-none rounded-lg text-sm p-2.5"
                >
                    <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
                
                <!-- User dropdown -->
                <button
                    type="button"
                    class="flex text-sm bg-gray-700 dark:bg-gray-700 bg-gray-200 rounded-full focus:ring-4 focus:ring-gray-600 dark:focus:ring-gray-600 focus:ring-gray-300"
                    id="user-menu-button"
                    data-dropdown-toggle="user-dropdown"
                    data-dropdown-placement="bottom"
                >
                    <span class="sr-only">Open user menu</span>
                    <div class="w-9 h-9 rounded-full bg-[#2bf8bd] flex items-center justify-center text-dark font-semibold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                </button>
                
                <!-- Dropdown menu -->
                <div class="hidden z-50 my-4 w-56 text-base list-none bg-gray-700 dark:bg-gray-700 bg-white rounded divide-y divide-gray-600 dark:divide-gray-600 divide-gray-200 shadow" id="user-dropdown">
                    <div class="py-3 px-4">
                        <span class="block text-sm font-semibold text-white dark:text-white text-gray-900">{{ Auth::user()->name }}</span>
                        <span class="block text-sm text-gray-400 dark:text-gray-400 text-gray-600 truncate">{{ Auth::user()->email }}</span>
                        <span class="block text-xs text-gray-400 dark:text-gray-400 text-gray-600 mt-1">Administrator</span> 
                    </div>
                    <ul class="py-1 text-gray-400 dark:text-gray-400 text-gray-600">
                        <li>
                            <a href="{{ route('logout') }}" class="block py-2 px-4 text-sm hover:bg-gray-600 dark:hover:bg-gray-600 hover:bg-gray-100 hover:text-white dark:hover:text-white hover:text-gray-900">Sign out</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-gray-800 dark:bg-gray-800 bg-white border-r border-gray-700 dark:border-gray-700 border-gray-200 md:translate-x-0"
        id="drawer-navigation"
        aria-label="Sidenav"
    >
        <div class="overflow-y-auto py-5 px-3 h-full bg-gray-800 dark:bg-gray-800 bg-white">
            <ul class="space-y-2">
                <li>
                    <a href="{{ Auth::user()->is_admin ? route('admin.dashboard') : route('dashboard') }}" 
                       class="flex items-center p-2 text-base font-medium text-white dark:text-white text-gray-900 rounded-lg hover:bg-gray-700 dark:hover:bg-gray-700 hover:bg-gray-100 group {{ request()->is('dashboard') || request()->is('admin') || request()->routeIs('admin.dashboard') || request()->routeIs('dashboard') ? 'bg-gray-700 dark:bg-gray-700 bg-gray-200' : '' }}">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>
                
                @if(Auth::user()->is_admin)
                <li>
                    <a href="{{ route('admin.books.index') }}" 
                       class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700 group {{ request()->is('admin/books*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                        </svg>
                        <span class="ml-3">Book Catalog</span>
                    </a>
                </li>
                  <li>
                    <a href="{{ route('admin.members.index') }}" 
                       class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700 group {{ request()->is('admin/members*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                        </svg>
                        <span class="ml-3">Member Management</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.lend.index') }}" 
                       class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700 group {{ request()->is('admin/lend*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                            <path d="M6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path>
                        </svg>
                        <span class="ml-3">Lend Book</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.borrowings.index') }}" 
                       class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700 group {{ request()->is('admin/borrowings*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3">Book Activity</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" 
                       class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700 group {{ request()->is('admin/settings*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3">Admin Settings</span>
                    </a>
                </li>
                @else
                <li>
                    <a href="#" 
                       class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700 group {{ request()->is('books*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z"></path>
                        </svg>
                        <span class="ml-3">Browse Books</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('borrowings.index') }}" 
                       class="flex items-center p-2 text-base font-medium text-white rounded-lg hover:bg-gray-700 group {{ request()->is('borrowings*') ? 'bg-gray-700' : '' }}">
                        <svg class="w-6 h-6 text-gray-400 transition duration-75 group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-3">My Borrowings</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </aside>

    <!-- Main content -->
    <main class="p-6 md:ml-64 h-auto pt-4">
        <div class="mb-4">
            <h1 class="text-2xl font-semibold text-white dark:text-white text-gray-900">
                @yield('title')
            </h1>
        </div>
        
        @yield('content')
    </main>


    
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;
    </script>
    
    <!-- Flowbite JS -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    
    <!-- Flowbite Dark Mode Toggle Script -->
    <script>
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

        // Change the icons inside the button based on previous settings
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            themeToggleLightIcon.classList.remove('hidden');
        } else {
            themeToggleDarkIcon.classList.remove('hidden');
        }

        var themeToggleBtn = document.getElementById('theme-toggle');

        themeToggleBtn.addEventListener('click', function() {
            // toggle icons inside button
            themeToggleDarkIcon.classList.toggle('hidden');
            themeToggleLightIcon.classList.toggle('hidden');

            // if set via local storage previously
            if (localStorage.getItem('color-theme')) {
                if (localStorage.getItem('color-theme') === 'light') {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                } else {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                }

            // if NOT set via local storage previously
            } else {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html>

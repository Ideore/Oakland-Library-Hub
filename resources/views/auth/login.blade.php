<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login - Oakland Library Hub</title>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Flowbite Dark Mode Script (must be in head to prevent FOUC) -->
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Tailwind Config for Dark Mode -->
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
    
    <style>
        @import url('https://rsms.me/inter/inter.css');
        body {
            font-family: 'Inter', sans-serif;
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
    </style>
</head>
<body class="antialiased bg-gray-100 dark:bg-gray-900">
    <!-- Theme Toggle Button - Fixed Position -->
    <div class="fixed top-4 right-4 z-50">
        <button
            id="theme-toggle"
            type="button"
            class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 bg-white dark:bg-gray-800 shadow-lg border border-gray-200 dark:border-gray-600"
        >
            <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
            </svg>
            <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
            </svg>
        </button>
    </div>

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <!-- Logo and Title -->
            <div class="text-center">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('assets/book.png') }}" alt="Oakland Library Hub Logo" class="h-16 w-16">
                </div>
                <h2 class="text-3xl font-bold text-gray-900 dark:text-white">
                    Oakland Library Hub
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Sign in to your account
                </p>
            </div>

            <!-- Login Form -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl p-8">
                @if($errors->any())
                    <div class="mb-4 bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-900 border border-red-700 text-red-300 px-4 py-3 rounded-lg text-sm">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-4 bg-green-900 border border-green-700 text-green-300 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST" class="flex flex-col gap-6">
                    @csrf
                    
                    <!-- Email Field -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email Address
                        </label>
                        <input 
                            type="email" 
                            name="email" 
                            id="email"
                            value="{{ old('email') }}"
                            class="bg-gray-50 dark:bg-gray-700 border-0 text-gray-900 dark:text-white text-sm rounded-lg focus:ring-2 block w-full p-3 placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="Enter your email"
                            required 
                            autofocus>
                    </div>

                    <!-- Password Field -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Password
                        </label>
                        <input 
                            type="password" 
                            name="password" 
                            id="password"
                            class="bg-gray-50 dark:bg-gray-700 border-0 text-gray-900 dark:text-white text-sm rounded-lg block w-full p-3 placeholder-gray-500 dark:placeholder-gray-400"
                            placeholder="Enter your password"
                            required>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-2">
                        <button 
                            type="submit"
                            class="w-full flex justify-center py-3 px-6 border border-transparent rounded-lg shadow-sm text-sm font-medium text-dark bg-[#2bf8bd] hover:bg-[#1dd1a1] transition-colors duration-200">
                            Sign in
                        </button>
                    </div>
                </form>
            </div>

            <!-- Footer Text -->
            <div class="text-center">
                <p class="text-sm text-gray-600 dark:text-gray-600">
                    © {{ date('Y') }} Oakland Library Hub. All rights reserved.
                </p>
            </div>
        </div>
    </div>


    <!-- Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add fade-in animation
            const container = document.querySelector('.max-w-md');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.5s ease-out';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);

            // Add fail-safe protection to login form
            const loginForm = document.querySelector('form[action*="login"]');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    const originalText = submitBtn.textContent;
                    
                    // Disable button and show loading state
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'Signing in...';
                    submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                    
                    // Note: This is a regular form submission, so the button will be reset on page reload
                    // But this prevents double-clicking during the submission process
                });
            }
        });
    </script>

    <!-- Dark Mode Toggle Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
            var themeToggleBtn = document.getElementById('theme-toggle');

            // Check if elements exist
            if (!themeToggleDarkIcon || !themeToggleLightIcon || !themeToggleBtn) {
                console.error('Theme toggle elements not found');
                return;
            }

            // Change the icons inside the button based on previous settings
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
                themeToggleDarkIcon.classList.add('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleLightIcon.classList.add('hidden');
            }

            themeToggleBtn.addEventListener('click', function() {
                console.log('Theme toggle clicked');
                console.log('Current theme in localStorage:', localStorage.getItem('color-theme'));
                console.log('HTML element has dark class:', document.documentElement.classList.contains('dark'));
                
                // toggle icons inside button
                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                // if set via local storage previously
                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                        console.log('Switched to dark mode');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                        console.log('Switched to light mode');
                    }
                // if NOT set via local storage previously
                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                        console.log('Switched to light mode (no previous setting)');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                        console.log('Switched to dark mode (no previous setting)');
                    }
                }
                
                console.log('After toggle - HTML element has dark class:', document.documentElement.classList.contains('dark'));
                console.log('New theme in localStorage:', localStorage.getItem('color-theme'));
            });
        });
    </script>
</body>
</html>

@extends('layouts.app')

@section('title', 'Admin Settings')

@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('settings-success-message').textContent = '{{ session('success') }}';
        const modal = document.getElementById('settingsSuccessModal');
        const content = document.getElementById('settings-success-modal-content');
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modal.classList.add('opacity-100');
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    });
</script>
@endif

<!-- Settings Form -->
<div class="bg-gray-800 rounded-lg shadow p-6 mr-100">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-white mb-2">Account Settings</h2>
        <p class="text-sm text-gray-400">Update your account information and password</p>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')

        <!-- Account Information Section -->
        <div class="space-y-6">
            <!-- Name Field -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                <div class="md:pt-2">
                    <label for="name" class="text-sm font-medium text-white">Full Name</label>
                </div>
                <div class="md:col-span-2">
                    <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}" required
                        class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Email Field -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                <div class="md:pt-2">
                    <label for="email" class="text-sm font-medium text-white">Email Address</label>
                </div>
                <div class="md:col-span-2">
                    <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}" required
                        class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <hr class="border-gray-600">

        <!-- Password Section -->
        <div class="space-y-6">
            <div>
                <h3 class="text-lg font-medium text-white mb-2">Change Password</h3>
                <p class="text-sm text-gray-400">Leave password fields empty if you don't want to change your password</p>
            </div>

            <!-- Current Password -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                <div class="md:pt-2">
                    <label for="current_password" class="text-sm font-medium text-white">Current Password</label>
                </div>
                <div class="md:col-span-2">
                    <input type="password" name="current_password" id="current_password"
                        class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 @error('current_password') border-red-500 @enderror">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- New Password -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                <div class="md:pt-2">
                    <label for="password" class="text-sm font-medium text-white">New Password</label>
                </div>
                <div class="md:col-span-2">
                    <input type="password" name="password" id="password"
                        class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5 @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                <div class="md:pt-2">
                    <label for="password_confirmation" class="text-sm font-medium text-white">Confirm New Password</label>
                </div>
                <div class="md:col-span-2">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5">
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <button type="submit"
                class="text-dark bg-[#2bf8bd] hover:bg-[#1dd1a1] font-medium rounded-lg text-sm px-6 py-2.5 text-center">
                Update Settings
            </button>
        </div>
    </form>
</div>

<!-- Success Modal -->
<div id="settingsSuccessModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="settings-success-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <button type="button"
                class="close-modal absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                data-modal-id="settingsSuccessModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-green-500 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-white" id="settings-success-message">Settings updated successfully!</h3>
                <button type="button" class="close-modal text-dark bg-[#2bf8bd] hover:bg-green-700 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
                    data-modal-id="settingsSuccessModal">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Modal helper functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            
            const content = modal.querySelector('[id$="-modal-content"]');
            
            modal.classList.remove('hidden', 'opacity-0', 'opacity-100');
            modal.style.backgroundColor = 'rgba(17, 24, 39, 0)';
            
            if (content) {
                content.classList.remove('scale-95', 'scale-100', 'opacity-0', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
            }
            
            modal.classList.remove('hidden');
            void modal.offsetHeight;
            
            requestAnimationFrame(() => {
                modal.style.backgroundColor = 'rgba(17, 24, 39, 0.75)';
                modal.classList.add('opacity-100');
                
                if (content) {
                    content.classList.remove('scale-95', 'opacity-0');
                    content.classList.add('scale-100', 'opacity-100');
                }
            });
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            
            const content = modal.querySelector('[id$="-modal-content"]');
            
            modal.style.backgroundColor = 'rgba(17, 24, 39, 0)';
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            
            if (content) {
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
            }
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('opacity-0', 'opacity-100');
                modal.removeAttribute('style');
                
                if (content) {
                    content.classList.remove('scale-95', 'scale-100', 'opacity-0', 'opacity-100');
                    content.classList.add('scale-95', 'opacity-0');
                }
            }, 300);
        }

        // Handle close modal buttons
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                const modalId = this.dataset.modalId;
                if (modalId) {
                    closeModal(modalId);
                }
            });
        });

        // Close modal when clicking outside
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });

        // Handle settings form submission with fail-safe protection
        const settingsForm = document.querySelector('form[action*="settings"]');
        if (settingsForm) {
            settingsForm.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                // Disable button and show loading state
                submitBtn.disabled = true;
                submitBtn.textContent = 'Updating...';
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                
                // Note: This is a regular form submission, so the button will be reset on page reload
                // But this prevents double-clicking during the submission process
            });
        }
    });
</script>
@endpush
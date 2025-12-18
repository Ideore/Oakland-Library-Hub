@extends('layouts.app')

@section('title', 'Member Management')

@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('member-success-message').textContent = '{{ session('success') }}';
        const modal = document.getElementById('memberSuccessModal');
        const content = document.getElementById('member-success-modal-content');
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

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('member-error-message').textContent = '{{ session('error') }}';
        const modal = document.getElementById('memberErrorModal');
        const content = document.getElementById('member-error-modal-content');
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

<!-- Members Table -->
<div class="bg-gray-800 rounded-lg shadow">
    <!-- Table Header -->
    <div class="flex flex-col md:flex-row items-center justify-between p-4 space-y-3 md:space-y-0 md:space-x-8">
        <div class="w-full md:w-1/2">
            <form class="flex items-center" onsubmit="return false;">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative w-full">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                    <input type="text" id="table-search"
                        class="bg-gray-700 border-b border-[#ffffff3c] text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5"
                        placeholder="Search members" />
                </div>
            </form>
        </div>
        <div
            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-8 flex-shrink-0">
            <div class="flex items-center space-x-2">
                <label for="entries-select" class="text-sm text-gray-400 whitespace-nowrap">Show</label>
                <select id="entries-select"
                    class="bg-gray-700 border-b border-[#ffffff3c] text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-2 pl-3 pr-8">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="text-sm text-gray-400">entries</span>
            </div>

            <button type="button" data-modal-target="addMemberModal" data-modal-toggle="addMemberModal"
                class="flex items-center justify-center text-dark bg-[#2bf8bd] hover:bg-green-700 font-medium rounded-lg text-sm px-4 py-2">
                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path clip-rule="evenodd" fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                Add Member
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table id="members-table" class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">ID Number</th>
                    <th scope="col" class="px-6 py-3">Name</th>
                    <th scope="col" class="px-6 py-3">Email</th>
                    <th scope="col" class="px-6 py-3">Active Borrowings</th>
                    <th scope="col" class="px-6 py-3">Total Borrowings</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @forelse($members as $member)
                <tr class="border-b border-gray-700 hover:bg-gray-700"
                    data-member-id="{{ strtolower($member->member_id) }}"
                    data-name="{{ strtolower($member->full_name) }}"
                    data-email="{{ strtolower($member->email) }}">
                    <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">{{ $member->member_id }}</th>
                    <td class="px-6 py-4">{{ $member->full_name }}</td>
                    <td class="px-6 py-4">{{ $member->email }}</td>
                    <td class="px-6 py-4">{{ $member->active_borrowings_count }}</td>
                    <td class="px-6 py-4">{{ $member->borrowings_count }}</td>
                    <td class="px-6 py-4">
                        <button class="edit-member font-medium text-blue-500 hover:text-blue-400 mr-3"
                            data-modal-target="editMemberModal" data-modal-toggle="editMemberModal"
                            data-id="{{ $member->id }}"
                            data-member-id="{{ $member->member_id }}"
                            data-first-name="{{ $member->first_name }}"
                            data-last-name="{{ $member->last_name }}"
                            data-address="{{ $member->address }}"
                            data-email="{{ $member->email }}"
                            data-contact="{{ $member->contact_number }}">
                            Edit
                        </button>
                        <button class="delete-member font-medium text-red-500 hover:text-red-400"
                            data-modal-target="deleteMemberModal" data-modal-toggle="deleteMemberModal"
                            data-id="{{ $member->id }}"
                            data-name="{{ $member->full_name }}">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No members found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Table Footer / Pagination -->
    <div
        class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 space-y-3 md:space-y-0 border-t border-gray-700">
        <span class="text-sm font-normal text-gray-400">
            Showing <span class="font-semibold text-white" id="showing-start">1</span>-<span
                class="font-semibold text-white" id="showing-end">10</span> of <span class="font-semibold text-white"
                id="total-entries">{{ count($members) }}</span>
        </span>
        <ul class="inline-flex items-stretch -space-x-px" id="pagination">
            <li>
                <button
                    class="flex items-center justify-center h-full py-1.5 px-3 ml-0 text-gray-400 bg-gray-700 rounded-l-lg border border-gray-600 hover:bg-gray-600 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed"
                    id="prev-page">
                    <span class="sr-only">Previous</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </li>
            <li id="page-numbers" class="flex">
                <!-- Page numbers will be inserted here by JavaScript -->
            </li>
            <li>
                <button
                    class="flex items-center justify-center h-full py-1.5 px-3 leading-tight text-gray-400 bg-gray-700 rounded-r-lg border border-gray-600 hover:bg-gray-600 hover:text-white disabled:opacity-50 disabled:cursor-not-allowed"
                    id="next-page">
                    <span class="sr-only">Next</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </button>
            </li>
        </ul>
    </div>
</div>

<!-- Modal: Add New Member -->
<div id="addMemberModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-2xl max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="add-member-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">Add New Member</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-toggle="addMemberModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="addMemberForm" action="{{ route('admin.members.store') }}" method="POST">
                @csrf
                <div class="p-4 md:p-5 space-y-4">
                    <div>
                        <label for="add_member_id" class="block mb-2 text-sm font-medium text-white">ID Number</label>
                        <input type="text" name="member_id" id="add_member_id"
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                            placeholder="Enter unique member ID (e.g., 54345)" required>
                        <div id="add_member_id_error" class="hidden text-red-400 text-sm mt-1"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="add_first_name" class="block mb-2 text-sm font-medium text-white">First Name</label>
                            <input type="text" name="first_name" id="add_first_name"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Enter first name" required>
                        </div>
                        <div>
                            <label for="add_last_name" class="block mb-2 text-sm font-medium text-white">Last Name</label>
                            <input type="text" name="last_name" id="add_last_name"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Enter last name" required>
                        </div>
                    </div>
                    <div>
                        <label for="add_address" class="block mb-2 text-sm font-medium text-white">Address</label>
                        <textarea name="address" id="add_address" rows="3"
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                            placeholder="Enter address" required></textarea>
                    </div>
                    <div>
                        <label for="add_email" class="block mb-2 text-sm font-medium text-white">Email</label>
                        <input type="email" name="email" id="add_email"
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                            placeholder="Enter unique email address" required>
                        <div id="add_email_error" class="hidden text-red-400 text-sm mt-1"></div>
                    </div>
                    <div>
                        <label for="add_contact_number" class="block mb-2 text-sm font-medium text-white">Contact Number</label>
                        <input type="text" name="contact_number" id="add_contact_number"
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                            placeholder="Enter contact number" required>
                    </div>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-700 space-x-3 justify-end">
                    <button type="button" data-modal-toggle="addMemberModal"
                        class="text-gray-400 bg-gray-700 hover:bg-gray-600 hover:text-white rounded-lg text-sm font-medium px-5 py-2.5">
                        Cancel
                    </button>
                    <button type="submit"
                        class="text-dark bg-[#2bf8bd] hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Add Member
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Edit Member -->
<div id="editMemberModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-2xl max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="edit-member-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">Edit Member</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-toggle="editMemberModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <form id="editMemberForm" method="POST">
                @csrf
                @method('PUT')
                <div class="p-4 md:p-5 space-y-4">
                    <div>
                        <label for="edit_member_id" class="block mb-2 text-sm font-medium text-white">ID Number</label>
                        <input type="text" name="member_id" id="edit_member_id"
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                            placeholder="Enter unique member ID" required>
                        <div id="edit_member_id_error" class="hidden text-red-400 text-sm mt-1"></div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="edit_first_name" class="block mb-2 text-sm font-medium text-white">First Name</label>
                            <input type="text" name="first_name" id="edit_first_name"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Enter first name" required>
                        </div>
                        <div>
                            <label for="edit_last_name" class="block mb-2 text-sm font-medium text-white">Last Name</label>
                            <input type="text" name="last_name" id="edit_last_name"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Enter last name" required>
                        </div>
                    </div>
                    <div>
                        <label for="edit_address" class="block mb-2 text-sm font-medium text-white">Address</label>
                        <textarea name="address" id="edit_address" rows="3"
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                            placeholder="Enter address" required></textarea>
                    </div>
                    <div>
                        <label for="edit_email" class="block mb-2 text-sm font-medium text-white">Email</label>
                        <input type="email" name="email" id="edit_email"
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                            placeholder="Enter unique email address" required>
                        <div id="edit_email_error" class="hidden text-red-400 text-sm mt-1"></div>
                    </div>
                    <div>
                        <label for="edit_contact_number" class="block mb-2 text-sm font-medium text-white">Contact Number</label>
                        <input type="text" name="contact_number" id="edit_contact_number"
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                            placeholder="Enter contact number" required>
                    </div>
                </div>
                <div class="flex items-center p-4 md:p-5 border-t border-gray-700 space-x-3 justify-end">
                    <button type="button" data-modal-toggle="editMemberModal"
                        class="text-gray-400 bg-gray-700 hover:bg-gray-600 hover:text-white  rounded-lg text-sm font-medium px-5 py-2.5">
                        Cancel
                    </button>
                    <button type="submit"
                        class="text-dark bg-[#2bf8bd] hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal: Delete Confirmation -->
<div id="deleteMemberModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="delete-member-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-b border-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">Are you sure?</h3>
            </div>
            <div class="p-4 md:p-5">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-400 text-center">Are you sure you want to delete member "<span
                        id="delete-member-name" class="font-semibold text-white"></span>"?</h3>
                <div class="flex justify-center gap-4">
                    <form id="deleteMemberForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="text-dark bg-red-500 hover:bg-red-700 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, delete it
                        </button>
                    </form>
                    <button type="button" data-modal-toggle="deleteMemberModal"
                        class="text-gray-400 bg-gray-700 hover:bg-gray-600 hover:text-white rounded-lg text-sm font-medium px-5 py-2.5">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Success -->
<div id="memberSuccessModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="member-success-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-green-500 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-white" id="member-success-message">Success!</h3>
                <button type="button" data-modal-toggle="memberSuccessModal"
                    class="text-white bg-green-600 hover:bg-green-700 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Error -->
<div id="memberErrorModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="member-error-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <button type="button"
                class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                data-modal-toggle="memberErrorModal">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                </svg>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-red-500 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m13 7-6 6m0-6 6 6m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-5 text-lg font-normal text-white" id="member-error-message">Error!</h3>
                <button type="button" data-modal-toggle="memberErrorModal"
                    class="text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
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
        /* =====================================================
         ===============  TABLE FILTERING & PAGINATION  =========
         ===================================================== */

        let currentPage = 1;
        let entriesPerPage = 10;

        let allRows = Array.from(document.querySelectorAll('#table-body tr'));
        allRows.sort((a, b) => {
            const idA = a.dataset.memberId || '';
            const idB = b.dataset.memberId || '';
            return idA.localeCompare(idB, undefined, { numeric: true, sensitivity: 'base' });
        });
        let filteredRows = [...allRows];

        function applyFilters() {
            const searchTerm = document.getElementById('table-search').value.toLowerCase();

            filteredRows = allRows.filter(row => {
                const memberId = row.dataset.memberId || '';
                const name = row.dataset.name || '';
                const email = row.dataset.email || '';

                return memberId.includes(searchTerm) ||
                    name.includes(searchTerm) ||
                    email.includes(searchTerm);
            });

            currentPage = 1;
            renderTable();
        }

        document.getElementById('table-search').addEventListener('input', applyFilters);

        document.getElementById('entries-select').addEventListener('change', function (e) {
            entriesPerPage = parseInt(e.target.value);
            currentPage = 1;
            renderTable();
        });

        document.getElementById('prev-page').addEventListener('click', function () {
            if (currentPage > 1) {
                currentPage--;
                renderTable();
            }
        });

        document.getElementById('next-page').addEventListener('click', function () {
            const totalPages = Math.ceil(filteredRows.length / entriesPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderTable();
            }
        });

        function renderTable() {
            const start = (currentPage - 1) * entriesPerPage;
            const end = start + entriesPerPage;
            const totalPages = Math.ceil(filteredRows.length / entriesPerPage);

            allRows.forEach(row => row.style.display = "none");
            filteredRows.slice(start, end).forEach(row => row.style.display = "");

            document.getElementById('showing-start').textContent = filteredRows.length ? start + 1 : 0;
            document.getElementById('showing-end').textContent = Math.min(end, filteredRows.length);
            document.getElementById('total-entries').textContent = filteredRows.length;

            document.getElementById('prev-page').disabled = currentPage === 1;
            document.getElementById('next-page').disabled = currentPage === totalPages || totalPages === 0;

            renderPageNumbers(totalPages);
        }

        function renderPageNumbers(totalPages) {
            const container = document.getElementById('page-numbers');
            container.innerHTML = "";

            for (let i = 1; i <= totalPages; i++) {
                if (i === 1 || i === totalPages || (i >= currentPage - 1 && i <= currentPage + 1)) {
                    const button = document.createElement('button');
                    button.className = `flex items-center justify-center text-sm py-2 px-3 leading-tight ${
                        i === currentPage
                            ? 'text-white bg-gray-600 border border-gray-600'
                            : 'text-gray-400 bg-gray-700 border border-gray-600 hover:text-white'
                    }`;
                    button.textContent = i;
                    button.addEventListener('click', function () {
                        currentPage = i;
                        renderTable();
                    });
                    container.appendChild(button);
                } else if (i === currentPage - 2 || i === currentPage + 2) {
                    const ellipsis = document.createElement('span');
                    ellipsis.className = 'flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-400 bg-gray-700 border border-gray-600';
                    ellipsis.textContent = '...';
                    container.appendChild(ellipsis);
                }
            }
        }

        renderTable();

        /* =====================================================
         ===============  MEMBER CRUD FUNCTIONALITY  ===========
         ===================================================== */

        // Handle Edit button click
        document.querySelectorAll('.edit-member').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const memberId = this.dataset.memberId;
                const firstName = this.dataset.firstName;
                const lastName = this.dataset.lastName;
                const address = this.dataset.address;
                const email = this.dataset.email;
                const contact = this.dataset.contact;

                document.getElementById('editMemberForm').action = `/admin/members/${id}`;
                document.getElementById('edit_member_id').value = memberId;
                document.getElementById('edit_first_name').value = firstName;
                document.getElementById('edit_last_name').value = lastName;
                document.getElementById('edit_address').value = address;
                document.getElementById('edit_email').value = email;
                document.getElementById('edit_contact_number').value = contact;
            });
        });

        // Handle Delete button click
        document.querySelectorAll('.delete-member').forEach(button => {
            button.addEventListener('click', function () {
                const id = this.dataset.id;
                const name = this.dataset.name;

                document.getElementById('deleteMemberForm').action = `/admin/members/${id}`;
                document.getElementById('delete-member-name').textContent = name;
            });
        });

        /* =====================================================
         ===============  MODAL HELPER FUNCTIONS  ==============
         ===================================================== */

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('[id$="-modal-content"]');
            
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            const content = modal.querySelector('[id$="-modal-content"]');
            
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');
            
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Handle modal toggle buttons
        document.querySelectorAll('[data-modal-toggle]').forEach(button => {
            button.addEventListener('click', function () {
                const modalId = this.dataset.modalToggle;
                const modal = document.getElementById(modalId);
                
                if (modal.classList.contains('hidden')) {
                    openModal(modalId);
                } else {
                    closeModal(modalId);
                }
            });
        });

        /* =====================================================
         ===============  FORM VALIDATION & SUBMISSION  ========
         ===================================================== */

        // Clear error messages when modal opens
        function clearFormErrors() {
            document.querySelectorAll('[id$="_error"]').forEach(errorDiv => {
                errorDiv.classList.add('hidden');
                errorDiv.textContent = '';
            });
            
            // Reset input border colors
            document.querySelectorAll('input').forEach(input => {
                input.classList.remove('border-red-500', 'focus:border-red-500');
            });
        }

        // Show validation error
        function showFieldError(fieldId, message) {
            const errorDiv = document.getElementById(fieldId + '_error');
            const input = document.getElementById(fieldId);
            
            if (errorDiv && input) {
                errorDiv.textContent = message;
                errorDiv.classList.remove('hidden');
                input.classList.add('border-red-500', 'focus:border-red-500');
            }
        }

        // Handle Add Member Form
        document.getElementById('addMemberForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            clearFormErrors();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Adding...';
            submitBtn.disabled = true;
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const responseData = await response.json();
                
                if (response.ok) {
                    closeModal('addMemberModal');
                    showSuccessModal('Member added successfully!');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    if (responseData.errors) {
                        // Handle validation errors
                        Object.keys(responseData.errors).forEach(field => {
                            const fieldId = 'add_' + field;
                            showFieldError(fieldId, responseData.errors[field][0]);
                        });
                    } else {
                        showErrorModal(responseData.message || 'Failed to add member. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('An error occurred. Please try again.');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });

        // Handle Edit Member Form
        document.getElementById('editMemberForm').addEventListener('submit', async function(e) {
            e.preventDefault();
            clearFormErrors();
            
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Updating...';
            submitBtn.disabled = true;
            
            const formData = new FormData(this);
            
            try {
                const response = await fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                
                const responseData = await response.json();
                
                if (response.ok) {
                    closeModal('editMemberModal');
                    showSuccessModal('Member updated successfully!');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    if (responseData.errors) {
                        // Handle validation errors
                        Object.keys(responseData.errors).forEach(field => {
                            const fieldId = 'edit_' + field;
                            showFieldError(fieldId, responseData.errors[field][0]);
                        });
                    } else {
                        showErrorModal(responseData.message || 'Failed to update member. Please try again.');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showErrorModal('An error occurred. Please try again.');
            } finally {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            }
        });

        // Clear errors when opening modals
        document.querySelector('[data-modal-target="addMemberModal"]').addEventListener('click', clearFormErrors);
        document.querySelectorAll('[data-modal-target="editMemberModal"]').forEach(btn => {
            btn.addEventListener('click', clearFormErrors);
        });

        // Helper functions for success/error modals
        function showSuccessModal(message) {
            document.getElementById('member-success-message').textContent = message;
            openModal('memberSuccessModal');
        }

        function showErrorModal(message) {
            document.getElementById('member-error-message').textContent = message;
            openModal('memberErrorModal');
        }
    });
</script>
@endpush

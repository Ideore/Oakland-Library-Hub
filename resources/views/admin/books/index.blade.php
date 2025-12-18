@extends('layouts.app')

@section('title', 'Book Catalog')

@section('content')
    <!-- Books Table -->
    <div class="bg-gray-800 dark:bg-gray-800 bg-white rounded-lg shadow">
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
                            class="bg-gray-700 dark:bg-gray-700 bg-gray-50 border-b border-[#ffffff3c] dark:border-[#ffffff3c] border-gray-300 text-white dark:text-white text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-80 pl-10 p-2.5"
                            placeholder="Search books" />
                    </div>
                </form>
            </div>
            <div
                class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-8 flex-shrink-0">
                <div class="flex items-center space-x-2">
                    <label for="entries-select" class="text-sm text-gray-400 dark:text-gray-400 text-gray-600 whitespace-nowrap">Show</label>
                    <select id="entries-select"
                        class="bg-gray-700 dark:bg-gray-700 bg-gray-50 border-b border-[#ffffff3c] dark:border-[#ffffff3c] border-gray-300 text-white dark:text-white text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-2 pl-3 pr-8">
                        <option value="5">5</option>
                        <option value="10" selected>10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="text-sm text-gray-400 dark:text-gray-400 text-gray-600">entries</span>
                </div>
                <div class="flex items-center space-x-2">
                    <label for="status-filter" class="text-sm text-gray-400 dark:text-gray-400 text-gray-600 whitespace-nowrap">Filter:</label>
                    <select id="status-filter"
                        class="bg-gray-700 dark:bg-gray-700 bg-gray-50 border-b border-[#ffffff3c] dark:border-[#ffffff3c] border-gray-300 text-white dark:text-white text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-2 pl-3 pr-8">
                        <option value="all">All Status</option>
                        <option value="available">Available</option>
                        <option value="borrowed">Borrowed</option>
                    </select>
                </div>
                <button type="button" data-modal-target="addBookModal" data-modal-toggle="addBookModal"
                    class="flex items-center justify-center text-dark bg-[#2bf8bd] hover:bg-green-700 focus:ring-2 focus:ring-gray-300 font-medium rounded-lg text-sm px-4 py-2">
                    <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path clip-rule="evenodd" fill-rule="evenodd"
                            d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                    </svg>
                    Add Book
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table id="books-table" class="w-full text-sm text-left text-gray-400 dark:text-gray-400 text-gray-600">
                <thead class="text-xs text-gray-400 dark:text-gray-400 text-gray-600 uppercase bg-gray-700 dark:bg-gray-700 bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3">Title</th>
                        <th scope="col" class="px-6 py-3">Author</th>
                        <th scope="col" class="px-6 py-3">ISBN</th>
                        <th scope="col" class="px-6 py-3">Copies</th>
                        <th scope="col" class="px-6 py-3">Description</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody id="table-body">
                    @foreach($books->sortBy('title') as $book)
                        <tr class="border-b border-gray-700 dark:border-gray-700 border-gray-200 hover:bg-gray-700 dark:hover:bg-gray-700 hover:bg-gray-50" data-title="{{ strtolower($book->title) }}"
                            data-author="{{ strtolower($book->author) }}"
                            data-isbn="{{ strtolower($book->isbn ?? '') }}"
                            data-description="{{ strtolower($book->description) }}"
                            data-status="{{ $book->available_copies > 0 ? 'available' : 'borrowed' }}">
                            <th scope="row" class="px-6 py-4 font-medium text-white dark:text-white text-gray-900 whitespace-nowrap">
                                {{ $book->title }}
                            </th>
                            <td class="px-6 py-4">{{ $book->author }}</td>
                            <td class="px-6 py-4">{{ $book->isbn ?? 'N/A' }}</td>
                            <td class="px-6 py-4">{{ $book->available_copies }}</td>
                            <td class="px-6 py-4">{{ Str::limit($book->description, 50) }}</td>
                            <td class="px-6 py-4">
                                @if($book->available_copies > 0)
                                    <span class="badge-available text-xs font-medium px-2.5 py-0.5 rounded">Available</span>
                                @else
                                    <span class="badge-unavailable text-xs font-medium px-2.5 py-0.5 rounded">Not Available</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <button class="edit-book font-medium text-blue-500 hover:text-blue-400 mr-3"
                                    data-modal-target="editBookModal" data-modal-toggle="editBookModal"
                                    data-id="{{ $book->id }}" 
                                    data-title="{{ $book->title }}" 
                                    data-author="{{ $book->author }}"
                                    data-isbn="{{ $book->isbn ?? '' }}"
                                    data-copies="{{ $book->available_copies }}"
                                    data-description="{{ $book->description }}">
                                    Edit
                                </button>
                                <button class="delete-book font-medium text-red-500 hover:text-red-400"
                                    data-modal-target="deleteBookModal" data-modal-toggle="deleteBookModal"
                                    data-id="{{ $book->id }}" data-title="{{ $book->title }}">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Table Footer / Pagination -->
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center p-4 space-y-3 md:space-y-0 border-t border-gray-700">
            <span class="text-sm font-normal text-gray-400">
                Showing <span class="font-semibold text-white" id="showing-start">1</span>-<span
                    class="font-semibold text-white" id="showing-end">10</span> of <span class="font-semibold text-white"
                    id="total-entries">{{ count($books) }}</span>
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

    <!-- Modal Add Book -->
    <div id="addBookModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
        <div class="relative p-4 w-full max-w-2xl max-h-full transform transition-all duration-300 scale-95 opacity-0"
            id="modal-content">
            <!-- Modal content -->
            <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700">
                    <h3 class="text-lg font-semibold text-white">
                        Add New Book
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="addBookModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="addBookForm">
                    <div class="p-4 md:p-5 space-y-4">
                        <div>
                            <label for="book-title" class="block mb-2 text-sm font-medium text-white">Title</label>
                            <input type="text" name="title" id="book-title"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Enter book title" required>
                        </div>
                        <div>
                            <label for="book-author" class="block mb-2 text-sm font-medium text-white">Author</label>
                            <input type="text" name="author" id="book-author"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Enter author name" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="book-isbn" class="block mb-2 text-sm font-medium text-white">ISBN</label>
                                <input type="text" name="isbn" id="book-isbn"
                                    class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                    placeholder="Enter ISBN (optional)">
                            </div>
                            <div>
                                <label for="book-copies" class="block mb-2 text-sm font-medium text-white">Available Copies</label>
                                <input type="number" name="available_copies" id="book-copies" min="1" value="1"
                                    class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                    placeholder="Enter number of copies" required>
                            </div>
                        </div>
                        <div>
                            <label for="book-description"
                                class="block mb-2 text-sm font-medium text-white">Description</label>
                            <textarea name="description" id="book-description" rows="4"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Write book description here" required></textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-700 space-x-3 justify-end">
                        <button type="button" data-modal-toggle="addBookModal"
                            class="text-gray-400 bg-gray-700 hover:bg-gray-600 hover:text-white rounded-lg text-sm font-medium px-5 py-2.5">
                            Cancel
                        </button>
                        <button type="submit"
                            class="text-dark bg-[#2bf8bd] hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Add Book
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Book -->
    <div id="editBookModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
        <div class="relative p-4 w-full max-w-2xl max-h-full transform transition-all duration-300 scale-95 opacity-0"
            id="edit-modal-content">
            <!-- Modal content -->
            <div class="relative bg-gray-800 rounded-lg shadow-xl border-b border-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700">
                    <h3 class="text-lg font-semibold text-white">
                        Edit Book
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                        data-modal-toggle="editBookModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form id="editBookForm">
                    <input type="hidden" id="edit_book_id">
                    <div class="p-4 md:p-5 space-y-4">
                        <div>
                            <label for="edit_title" class="block mb-2 text-sm font-medium text-white">Title</label>
                            <input type="text" name="title" id="edit_title"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Enter book title" required>
                        </div>
                        <div>
                            <label for="edit_author" class="block mb-2 text-sm font-medium text-white">Author</label>
                            <input type="text" name="author" id="edit_author"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Enter author name" required>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="edit_isbn" class="block mb-2 text-sm font-medium text-white">ISBN</label>
                                <input type="text" name="isbn" id="edit_isbn"
                                    class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                    placeholder="Enter ISBN (optional)">
                            </div>
                            <div>
                                <label for="edit_copies" class="block mb-2 text-sm font-medium text-white">Available Copies</label>
                                <input type="number" name="available_copies" id="edit_copies" min="0"
                                    class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                    placeholder="Enter number of copies" required>
                            </div>
                        </div>
                        <div>
                            <label for="edit_description"
                                class="block mb-2 text-sm font-medium text-white">Description</label>
                            <textarea name="description" id="edit_description" rows="4"
                                class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                                placeholder="Write book description here" required></textarea>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-700 space-x-3 justify-end">
                        <button data-modal-toggle="editBookModal" type="button"
                            class="text-gray-400 bg-gray-700 hover:bg-gray-600 hover:text-white rounded-lg border-0 text-sm font-medium px-5 py-2.5">
                            Cancel
                        </button>
                        <button type="submit"
                            class="text-dark bg-[#2bf8bd] hover:bg-gray-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Alert Modals -->
    <!-- Delete Confirmation Modal -->
    <div id="deleteBookModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
        <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
            id="delete-modal-content">
            <!-- Modal content -->
            <div class="relative bg-gray-800 rounded-lg shadow-xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700">
                    <h3 class="text-lg font-semibold text-white">
                        Are you sure?
                    </h3>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5">
                    <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-400 text-center">Are you sure you want to delete "<span
                            id="delete-book-title" class="font-semibold text-white"></span>"?</h3>
                    <div class="flex justify-center gap-4">
                        <button id="confirmDeleteBtn" type="button"
                            class="text-[#ffffff] bg-red-500 hover:bg-red-300 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, delete it
                        </button>
                        <button type="button" data-modal-toggle="deleteBookModal"
                            class="text-gray-400 bg-gray-700 hover:bg-gray-600 hover:text-white rounded-lg text-sm font-medium px-5 py-2.5">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
        <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
            id="success-modal-content">
            <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
                <div class="p-4 md:p-5 text-center">
                    <svg class="mx-auto mb-4 text-green-500 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m7 10 2 2 4-4m6 2a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-white" id="success-message">Success!</h3>
                    <button type="button" data-modal-toggle="successModal"
                        class="text-dark bg-[#2bf8bd] hover:bg-green-700 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        OK
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Error Modal -->
    <div id="errorModal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
        <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
            id="error-modal-content">
            <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
                <button type="button"
                    class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                    data-modal-toggle="errorModal">
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
                    <h3 class="mb-5 text-lg font-normal text-white" id="error-message">Error!</h3>
                    <button type="button" data-modal-toggle="errorModal"
                        class="text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
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
            // Sort rows by title alphabetically A-Z
            allRows.sort((a, b) => {
                const titleA = a.dataset.title || '';
                const titleB = b.dataset.title || '';
                return titleA.localeCompare(titleB, undefined, { numeric: true, sensitivity: 'base' });
            });
            let filteredRows = [...allRows];

            function applyFilters() {
                const searchTerm = document.getElementById('table-search').value.toLowerCase();
                const statusFilter = document.getElementById('status-filter').value;

                filteredRows = allRows.filter(row => {
                    const title = row.dataset.title || '';
                    const author = row.dataset.author || '';
                    const description = row.dataset.description || '';
                    const status = row.dataset.status || '';

                    const matchesSearch = title.includes(searchTerm) ||
                        author.includes(searchTerm) ||
                        description.includes(searchTerm);

                    const matchesStatus = statusFilter === "all" || status === statusFilter;

                    return matchesSearch && matchesStatus;
                });

                currentPage = 1;
                renderTable();
            }

            document.getElementById('table-search').addEventListener('input', applyFilters);
            document.getElementById('status-filter').addEventListener('change', applyFilters);

            // Entries per page change
            document.getElementById('entries-select').addEventListener('change', function (e) {
                entriesPerPage = parseInt(e.target.value);
                currentPage = 1;
                renderTable();
            });

            // Pagination
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

                // Hide all rows
                allRows.forEach(row => row.style.display = "none");

                // Show current rows
                filteredRows.slice(start, end).forEach(row => row.style.display = "");

                // Show text
                document.getElementById('showing-start').textContent = filteredRows.length ? start + 1 : 0;
                document.getElementById('showing-end').textContent = Math.min(end, filteredRows.length);
                document.getElementById('total-entries').textContent = filteredRows.length;

                // Buttons
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
                        button.className =
                            `flex items-center px-3 py-2 border border-gray-600 text-sm leading-tight ${i === currentPage
                                ? 'bg-gray-600 text-white'
                                : 'bg-gray-700 text-gray-400 hover:bg-gray-600 hover:text-white'
                            }`;

                        button.textContent = i;
                        button.addEventListener('click', () => {
                            currentPage = i;
                            renderTable();
                        });

                        container.appendChild(button);

                    } else if (i === currentPage - 2 || i === currentPage + 2) {
                        const dots = document.createElement('span');
                        dots.className = "px-3 py-2 text-gray-400";
                        dots.textContent = "...";
                        container.appendChild(dots);
                    }
                }
            }

            renderTable();



            /* =====================================================
             ===============  MODAL HANDLING (ALL)  =================
             ===================================================== */

            function animateOpen(modal, content) {
                modal.classList.remove("hidden");
                modal.style.backgroundColor = "rgba(17,24,39,0.5)";

                setTimeout(() => {
                    modal.classList.replace("opacity-0", "opacity-100");
                    content.classList.replace("scale-95", "scale-100");
                    content.classList.replace("opacity-0", "opacity-100");
                }, 10);
            }

            function animateClose(modal, content) {
                modal.classList.replace("opacity-100", "opacity-0");
                content.classList.replace("scale-100", "scale-95");
                content.classList.replace("opacity-100", "opacity-0");

                setTimeout(() => {
                    modal.classList.add("hidden");
                    modal.style.backgroundColor = "";
                }, 300);
            }

            /* ----------------- Add Book Modal ------------------ */

            const addModal = document.getElementById('addBookModal');
            const addContent = document.getElementById('modal-content');

            document.querySelectorAll('[data-modal-toggle="addBookModal"]').forEach(btn => {
                btn.addEventListener("click", () => animateOpen(addModal, addContent));
            });

            addModal.addEventListener("click", e => {
                if (e.target === addModal) animateClose(addModal, addContent);
            });

            /* ----------------- Edit Book Modal ------------------ */

            const editModal = document.getElementById('editBookModal');
            const editContent = document.getElementById('edit-modal-content');

            // Add event handler to prefill edit modal inputs on clicking edit buttons
            document.querySelectorAll('.edit-book').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    // Populate form fields with data attributes from clicked button
                    document.getElementById('edit_book_id').value = this.dataset.id || '';
                    document.getElementById('edit_title').value = this.dataset.title || '';
                    document.getElementById('edit_author').value = this.dataset.author || '';
                    document.getElementById('edit_isbn').value = this.dataset.isbn || '';
                    document.getElementById('edit_copies').value = this.dataset.copies || '1';
                    document.getElementById('edit_description').value = this.dataset.description || '';

                    // Open the modal with animation
                    animateOpen(editModal, editContent);
                });
            });

            // Remove the previous event listeners that only opened the modal without setting data
            // (remove the previously registered listeners on elements with data-modal-toggle="editBookModal")
            document.querySelectorAll('[data-modal-toggle="editBookModal"]').forEach(btn => {
                btn.removeEventListener("click", () => animateOpen(editModal, editContent));
            });

            editModal.addEventListener("click", e => {
                if (e.target === editModal) animateClose(editModal, editContent);
            });



            /* ----------------- Success & Error Modals ------------------ */

            const successModal = document.getElementById('successModal');
            const successContent = document.getElementById('success-modal-content');

            const errorModal = document.getElementById('errorModal');
            const errorContent = document.getElementById('error-modal-content');

            function showSuccess(message) {
                document.getElementById('success-message').textContent = message;
                animateOpen(successModal, successContent);
            }

            function showError(message) {
                document.getElementById('error-message').textContent = message;
                animateOpen(errorModal, errorContent);
            }

            document.querySelectorAll('[data-modal-toggle="successModal"]').forEach(b => {
                b.addEventListener('click', () => {
                    animateClose(successModal, successContent);
                    window.location.reload();
                });
            });

            document.querySelectorAll('[data-modal-toggle="errorModal"]').forEach(b => {
                b.addEventListener('click', () => animateClose(errorModal, errorContent));
            });


            /* ----------------- Delete Modal ------------------ */

            const deleteModal = document.getElementById('deleteBookModal');
            const deleteContent = document.getElementById('delete-modal-content');
            let deleteBookId = null;

            document.querySelectorAll('.delete-book').forEach(btn => {
                btn.addEventListener('click', function () {
                    deleteBookId = this.dataset.id;
                    document.getElementById('delete-book-title').textContent = this.dataset.title;
                    animateOpen(deleteModal, deleteContent);
                });
            });

            document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
                axios.delete(`/admin/books/${deleteBookId}`)
                    .then(res => {
                        animateClose(deleteModal, deleteContent);
                        showSuccess('Book deleted successfully!');
                    })
                    .catch(err => {
                        animateClose(deleteModal, deleteContent);
                        showError(err.response?.data?.message || 'Failed to delete book');
                    });
            });


            /* =====================================================
             ===============  FORM ACTIONS (ADD/EDIT)  =============
             ===================================================== */

            document.getElementById('addBookForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                
                // Disable button and show loading state
                submitBtn.disabled = true;
                submitBtn.textContent = 'Adding...';
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

                axios.post('{{ route("admin.books.store") }}', new FormData(this))
                    .then(res => {
                        animateClose(addModal, addContent);
                        showSuccess("Book added successfully!");
                    })
                    .catch(err => {
                        showError(err.response?.data?.message || "Failed to add book");
                    })
                    .finally(() => {
                        // Re-enable button
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    });
            });

            document.getElementById('editBookForm').addEventListener('submit', function (e) {
                e.preventDefault();

                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.textContent;
                const id = document.getElementById('edit_book_id').value;
                
                // Disable button and show loading state
                submitBtn.disabled = true;
                submitBtn.textContent = 'Saving...';
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

                axios.put(`/admin/books/${id}`, {
                    title: document.getElementById('edit_title').value,
                    author: document.getElementById('edit_author').value,
                    isbn: document.getElementById('edit_isbn').value,
                    available_copies: document.getElementById('edit_copies').value,
                    description: document.getElementById('edit_description').value,
                })
                    .then(res => {
                        animateClose(editModal, editContent);
                        showSuccess('Book updated successfully!');
                    })
                    .catch(err => {
                        showError(err.response?.data?.message || "Failed to update book");
                    })
                    .finally(() => {
                        // Re-enable button
                        submitBtn.disabled = false;
                        submitBtn.textContent = originalText;
                        submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    });
            });

        });
    </script>
@endpush
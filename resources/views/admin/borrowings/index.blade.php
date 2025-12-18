@extends('layouts.app')

@section('title', 'Book Activity')

@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('borrowing-success-message').textContent = '{{ session('success') }}';
        const modal = document.getElementById('borrowingSuccessModal');
        const content = document.getElementById('borrowing-success-modal-content');
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

<!-- Borrowings Table -->
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
                        placeholder="Search borrowings" />
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
            <div class="flex items-center space-x-2">
                <label for="status-filter" class="text-sm text-gray-400 whitespace-nowrap">Filter:</label>
                <select id="status-filter"
                    class="bg-gray-700 border-b border-[#ffffff3c] text-white text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 py-2 pl-3 pr-8">
                    <option value="all">All Status</option>
                    <option value="borrowed">Borrowed</option>
                    <option value="overdue">Overdue</option>
                    <option value="returned">Returned</option>
                    <option value="returned-late">Returned Late</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table id="borrowings-table" class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">Member</th>
                    <th scope="col" class="px-6 py-3">Book</th>
                    <th scope="col" class="px-6 py-3">Borrow Date</th>
                    <th scope="col" class="px-6 py-3">Return Date</th>
                    <th scope="col" class="px-6 py-3">Returned At</th>
                    <th scope="col" class="px-6 py-3">Status</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @forelse($borrowings as $borrowing)
                    @php
                        $isReturned = !is_null($borrowing->returned_at);
                        $isOverdue = !$isReturned && $borrowing->return_date->isPast();
                        $isReturnedLate = $isReturned && $borrowing->returned_at->gt($borrowing->return_date);
                        
                        if ($isOverdue) {
                            $status = 'overdue';
                        } elseif ($isReturnedLate) {
                            $status = 'returned-late';
                        } elseif ($isReturned) {
                            $status = 'returned';
                        } else {
                            $status = 'borrowed';
                        }
                    @endphp
                    <tr class="border-b border-gray-700 hover:bg-gray-700"
                        data-member="{{ strtolower($borrowing->member->full_name) }}"
                        data-book="{{ strtolower($borrowing->book->title) }}"
                        data-status="{{ $status }}">
                        <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                            {{ $borrowing->member->full_name }}
                            <div class="text-xs text-gray-400 font-normal">ID: {{ $borrowing->member->member_id }}</div>
                        </th>
                        <td class="px-6 py-4">
                            <div class="text-white">{{ $borrowing->book->title }}</div>
                            <div class="text-xs text-gray-400">{{ $borrowing->book->author }}</div>
                        </td>
                        <td class="px-6 py-4">{{ $borrowing->borrow_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">{{ $borrowing->return_date->format('d M Y') }}</td>
                        <td class="px-6 py-4">
                            @if($borrowing->returned_at)
                                {{ $borrowing->returned_at->format('d M Y') }}
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($isOverdue)
                                <span class="badge-overdue text-xs font-medium px-2.5 py-0.5 rounded">Overdue</span>
                            @elseif($isReturnedLate)
                                <span class="badge-returned-late text-xs font-medium px-2.5 py-0.5 rounded">Returned Late</span>
                            @elseif($isReturned)
                                <span class="badge-returned text-xs font-medium px-2.5 py-0.5 rounded">Returned</span>
                            @else
                                <span class="badge-borrowed text-xs font-medium px-2.5 py-0.5 rounded">Borrowed</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if(!$borrowing->returned_at)
                                <button class="return-book font-medium text-green-500 hover:text-green-400"
                                    data-modal-target="returnBookModal" data-modal-toggle="returnBookModal"
                                    data-id="{{ $borrowing->id }}"
                                    data-book="{{ $borrowing->book->title }}"
                                    data-member="{{ $borrowing->member->full_name }}">
                                    Return
                                </button>
                            @else
                                <span class="text-gray-500">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">No borrowings found</td>
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
                id="total-entries">{{ count($borrowings) }}</span>
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

<!-- Modal: Return Book Confirmation -->
<div id="returnBookModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="return-book-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl">
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">Return Book</h3>
                <button type="button"
                    class="text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-toggle="returnBookModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <h3 class="mb-2 text-lg font-normal text-gray-400 text-center">Confirm return of:</h3>
                <div class="mb-5 text-center">
                    <p class="text-white font-semibold" id="return-book-title"></p>
                    <p class="text-gray-400 text-sm">borrowed by <span id="return-member-name" class="text-white font-medium"></span></p>
                </div>
                <div class="flex justify-center gap-4">
                    <button type="button" id="confirmReturnBtn"
                        class="text-dark bg-green-600 hover:bg-green-700 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, return it
                    </button>
                    <button type="button" data-modal-toggle="returnBookModal"
                        class="text-gray-400 bg-gray-700 hover:bg-gray-600 hover:text-white rounded-lg text-sm font-medium px-5 py-2.5">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Success -->
<div id="borrowingSuccessModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="borrowing-success-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <button type="button"
                class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                data-modal-toggle="borrowingSuccessModal">
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
                <h3 class="mb-5 text-lg font-normal text-white" id="borrowing-success-message">Success!</h3>
                <button type="button" data-modal-toggle="borrowingSuccessModal"
                    class="text-dark bg-[#2bf8bd] hover:bg-green-700 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Error -->
<div id="borrowingErrorModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="borrowing-error-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <button type="button"
                class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                data-modal-toggle="borrowingErrorModal">
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
                <h3 class="mb-5 text-lg font-normal text-white" id="borrowing-error-message">Error!</h3>
                <button type="button" data-modal-toggle="borrowingErrorModal"
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
        // Sort by borrow date (most recent first) - assuming rows are already sorted from backend
        let filteredRows = [...allRows];

        function applyFilters() {
            const searchTerm = document.getElementById('table-search').value.toLowerCase();
            const statusFilter = document.getElementById('status-filter').value;

            filteredRows = allRows.filter(row => {
                const member = row.dataset.member || '';
                const book = row.dataset.book || '';
                const status = row.dataset.status || '';

                const matchesSearch = member.includes(searchTerm) || book.includes(searchTerm);
                const matchesStatus = statusFilter === "all" || status === statusFilter;

                return matchesSearch && matchesStatus;
            });

            currentPage = 1;
            renderTable();
        }

        document.getElementById('table-search').addEventListener('input', applyFilters);
        document.getElementById('status-filter').addEventListener('change', applyFilters);

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
                            ? 'bg-gray-600 text-white'
                            : 'bg-gray-700 text-gray-400 hover:bg-gray-600 hover:text-white'
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
         ===============  RETURN BOOK FUNCTIONALITY  ===========
         ===================================================== */

        let currentBorrowingId = null;

        // Handle Return button click
        document.querySelectorAll('.return-book').forEach(button => {
            button.addEventListener('click', function () {
                currentBorrowingId = this.dataset.id;
                const bookTitle = this.dataset.book;
                const memberName = this.dataset.member;

                document.getElementById('return-book-title').textContent = bookTitle;
                document.getElementById('return-member-name').textContent = memberName;
            });
        });

        // Handle Confirm Return button
        document.getElementById('confirmReturnBtn').addEventListener('click', async function () {
            if (!currentBorrowingId) return;

            try {
                const response = await axios.post(`/admin/borrowings/${currentBorrowingId}/return`);
                
                closeModal('returnBookModal');
                showSuccessModal('Book has been returned successfully!');
                
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } catch (error) {
                closeModal('returnBookModal');
                const errorMessage = error.response?.data?.message || 'Failed to return book. Please try again.';
                showErrorModal(errorMessage);
            }
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

        function showSuccessModal(message) {
            document.getElementById('borrowing-success-message').textContent = message;
            openModal('borrowingSuccessModal');
        }

        function showErrorModal(message) {
            document.getElementById('borrowing-error-message').textContent = message;
            openModal('borrowingErrorModal');
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
    });
</script>
@endpush

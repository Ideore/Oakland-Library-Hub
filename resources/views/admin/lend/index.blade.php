@extends('layouts.app')

@section('title', 'Lend Book')

@section('content')

@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('success-message').textContent = '{{ session('success') }}';
        const modal = document.getElementById('successModal');
        const content = document.getElementById('success-modal-content');
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
        document.getElementById('error-message').textContent = '{{ session('error') }}';
        const modal = document.getElementById('errorModal');
        const content = document.getElementById('error-modal-content');
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

<!-- Books Table -->
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
                        placeholder="Search books" />
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
        </div>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table id="books-table" class="w-full text-sm text-left text-gray-400">
            <thead class="text-xs text-gray-400 uppercase bg-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-3">Title</th>
                    <th scope="col" class="px-6 py-3">Author</th>
                    <th scope="col" class="px-6 py-3">ISBN</th>
                    <th scope="col" class="px-6 py-3">Available Copies</th>
                    <th scope="col" class="px-6 py-3">Actions</th>
                </tr>
            </thead>
            <tbody id="table-body">
                @forelse($books as $book)
                    <tr class="border-b border-gray-700 hover:bg-gray-700" 
                        data-title="{{ strtolower($book->title) }}"
                        data-author="{{ strtolower($book->author) }}"
                        data-isbn="{{ strtolower($book->isbn ?? '') }}">
                        <th scope="row" class="px-6 py-4 font-medium text-white whitespace-nowrap">
                            {{ $book->title }}
                        </th>
                        <td class="px-6 py-4">{{ $book->author }}</td>
                        <td class="px-6 py-4">{{ $book->isbn ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $book->available_copies }}</td>
                        <td class="px-6 py-4">
                            @if($book->available_copies > 0)
                                <button class="lend-book font-medium text-blue-500 hover:text-blue-400"
                                    data-book-id="{{ $book->id }}"
                                    data-book-title="{{ $book->title }}">
                                    Lend
                                </button>
                            @else
                                <span class="text-gray-500">Not Available</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No books found</td>
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

<!-- Modal: Enter Member ID -->
<div id="memberIdModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="member-id-modal-content">
        <!-- Modal content -->
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">
                    Enter Member ID
                </h3>
                <button type="button"
                    class="close-modal text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-id="memberIdModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <div>
                    <label for="member_id_input" class="block mb-2 text-sm font-medium text-white">Member ID Number</label>
                    <input type="text" id="member_id_input"
                        class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                        placeholder="Enter member ID" required>
                </div>
                <div id="member-error-message" class="hidden text-red-500 text-sm"></div>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-700 space-x-3 justify-end">
                <button type="button" class="close-modal text-gray-400 bg-gray-700 hover:bg-gray-600 hover:text-white rounded-lg text-sm font-medium px-5 py-2.5"
                    data-modal-id="memberIdModal">
                    Cancel
                </button>
                <button type="button" id="findMemberBtn"
                    class="text-dark bg-[#2bf8bd] hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Find Member
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Lend Book Details -->
<div id="lendModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-2xl max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="lend-modal-content">
        <!-- Modal content -->
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b border-gray-700">
                <h3 class="text-lg font-semibold text-white">
                    Lend Book
                </h3>
                <button type="button"
                    class="close-modal text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center"
                    data-modal-id="lendModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <form id="lendBookForm" action="{{ route('admin.lend.store') }}" method="POST">
                @csrf
                <input type="hidden" name="member_id" id="selected_member_id">
                <input type="hidden" name="book_id" id="selected_book_id">
                
                <div class="p-4 md:p-5 space-y-4">
                    <!-- Member Details -->
                    <div class="bg-gray-700 p-4 rounded-lg space-y-2">
                        <h4 class="font-semibold text-white mb-3">Member Details</h4>

                        <div class="flex flex-col gap-3">
                            <div class="flex justify-between">
                                 <div class="label text-gray-400">ID Number:</div>
                                 <div class="data-member text-white font-medium ml-2" id="display_member_id"></div>
                            </div>

                             <div class="flex justify-between">
                                 <div class="label text-gray-400">Name:</div>
                                 <div class="data-member text-white font-medium ml-2" id="display_name"></div>
                            </div>

                            
                             <div class="flex justify-between">
                                 <div class="label text-gray-400">Address:</div>
                                 <div class="data-member text-white font-medium ml-2" id="display_address"></div>
                            </div>

                            
                             <div class="flex justify-between">
                                 <div class="label text-gray-400">Email:</div>
                                 <div class="data-member text-white font-medium ml-2" id="display_email"></div>
                            </div>

                            
                             <div class="flex justify-between">
                                 <div class="label text-gray-400">Contact:</div>
                                 <div class="data-member text-white font-medium ml-2" id="display_contact"></div>
                            </div>
                        </div>

                    </div>

                    <!-- Borrow Date -->    
                     
                    <div>
                        <label for="borrow_date" class="block mb-2 text-sm font-medium text-white">Borrow Date</label>
                        <input type="date" name="borrow_date" id="borrow_date" required
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5"
                            value="{{ date('Y-m-d') }}">
                    </div>

                    <!-- Return Date -->
                    <div>
                        <label for="return_date" class="block mb-2 text-sm font-medium text-white">Return Date</label>
                        <input type="date" name="return_date" id="return_date" required
                            class="bg-gray-700 border-0 text-white text-sm rounded-lg focus:ring-gray-500 focus:border-gray-500 block w-full p-2.5">
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-700 space-x-3 justify-end">
                    <button type="button" class="close-modal text-gray-400 bg-gray-700 hover:bg-gray-600 hover:text-white rounded-lg text-sm font-medium px-5 py-2.5"
                        data-modal-id="lendModal">
                        Cancel
                    </button>
                    <button type="submit"
                        class="text-dark bg-[#2bf8bd] hover:bg-[#1dd1a1] font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        Lend Book
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-full transition-opacity duration-300">
    <div class="relative p-4 w-full max-w-md max-h-full transform transition-all duration-300 scale-95 opacity-0"
        id="success-modal-content">
        <div class="relative bg-gray-800 rounded-lg shadow-xl border-0">
            <button type="button"
                class="close-modal absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                data-modal-id="successModal">
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
                <h3 class="mb-5 text-lg font-normal text-white" id="success-message">Success!</h3>
                <button type="button" class="close-modal text-dark bg-[#2bf8bd] hover:bg-green-700 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
                    data-modal-id="successModal">
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
                class="close-modal absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-700 hover:text-white rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center"
                data-modal-id="errorModal">
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
                <button type="button" class="close-modal text-white bg-red-600 hover:bg-red-700 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center"
                    data-modal-id="errorModal">
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
            const titleA = a.dataset.title || '';
            const titleB = b.dataset.title || '';
            return titleA.localeCompare(titleB, undefined, { numeric: true, sensitivity: 'base' });
        });
        let filteredRows = [...allRows];

        function applyFilters() {
            const searchTerm = document.getElementById('table-search').value.toLowerCase();

            filteredRows = allRows.filter(row => {
                const title = row.dataset.title || '';
                const author = row.dataset.author || '';
                const isbn = row.dataset.isbn || '';

                return title.includes(searchTerm) ||
                    author.includes(searchTerm) ||
                    isbn.includes(searchTerm);
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
                    button.className = `flex items-center px-3 py-2 border border-gray-600 text-sm leading-tight ${
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
         ===============  LEND BOOK FUNCTIONALITY  ==============
         ===================================================== */

        let currentBookId = null;
        let currentBookTitle = null;

        // Handle Lend button click
        document.querySelectorAll('.lend-book').forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault();
                currentBookId = this.dataset.bookId;
                currentBookTitle = this.dataset.bookTitle;
                document.getElementById('member_id_input').value = '';
                document.getElementById('member-error-message').classList.add('hidden');
                openModal('memberIdModal');
            });
        });

        // Handle Find Member button
        document.getElementById('findMemberBtn').addEventListener('click', async function () {
            const memberId = document.getElementById('member_id_input').value.trim();
            const errorDiv = document.getElementById('member-error-message');

            if (!memberId) {
                errorDiv.textContent = 'Please enter a member ID';
                errorDiv.classList.remove('hidden');
                return;
            }

            try {
                const response = await axios.post('{{ route("admin.lend.findMember") }}', {
                    member_id: memberId
                });

                if (response.data.success) {
                    const member = response.data.member;
                    
                    // Populate lend modal
                    document.getElementById('selected_member_id').value = member.id;
                    document.getElementById('selected_book_id').value = currentBookId;
                    document.getElementById('display_member_id').textContent = member.member_id;
                    document.getElementById('display_name').textContent = member.first_name + ' ' + member.last_name;
                    document.getElementById('display_email').textContent = member.email;
                    document.getElementById('display_address').textContent = member.address;
                    document.getElementById('display_contact').textContent = member.contact_number;

                    // Set default return date (14 days from now)
                    const returnDate = new Date();
                    returnDate.setDate(returnDate.getDate() + 14);
                    document.getElementById('return_date').value = returnDate.toISOString().split('T')[0];

                    // Close member ID modal and open lend modal
                    closeModal('memberIdModal');
                    setTimeout(() => openModal('lendModal'), 300);
                }
            } catch (error) {
                if (error.response && error.response.status === 404) {
                    errorDiv.textContent = error.response.data.message;
                } else {
                    errorDiv.textContent = 'An error occurred. Please try again.';
                }
                errorDiv.classList.remove('hidden');
            }
        });

        // Handle form submission
        document.getElementById('lendBookForm').addEventListener('submit', async function (e) {
            e.preventDefault();

            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            const formData = new FormData(this);

            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.textContent = 'Lending...';
            submitBtn.classList.add('opacity-75', 'cursor-not-allowed');

            try {
                const response = await axios.post(this.action, formData);
                
                closeModal('lendModal');
                showSuccessModal('Book lent successfully!');
                
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } catch (error) {
                closeModal('lendModal');
                const errorMessage = error.response?.data?.message || 'Failed to lend book. Please try again.';
                showErrorModal(errorMessage);
            } finally {
                // Re-enable button
                submitBtn.disabled = false;
                submitBtn.textContent = originalText;
                submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
            }
        });

        /* =====================================================
         ===============  MODAL HELPER FUNCTIONS  ==============
         ===================================================== */

        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            if (!modal) return;
            
            const content = modal.querySelector('[id$="-modal-content"]');
            
            // Reset modal state completely
            modal.classList.remove('hidden', 'opacity-0', 'opacity-100');
            modal.style.backgroundColor = 'rgba(17, 24, 39, 0)';
            
            if (content) {
                content.classList.remove('scale-95', 'scale-100', 'opacity-0', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
            }
            
            // Show modal
            modal.classList.remove('hidden');
            
            // Force reflow
            void modal.offsetHeight;
            
            // Animate in
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
            
            // Animate out
            modal.style.backgroundColor = 'rgba(17, 24, 39, 0)';
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            
            if (content) {
                content.classList.remove('scale-100', 'opacity-100');
                content.classList.add('scale-95', 'opacity-0');
            }
            
            // Hide after animation and clean up completely
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('opacity-0', 'opacity-100');
                modal.removeAttribute('style');
                
                // Reset content state
                if (content) {
                    content.classList.remove('scale-95', 'scale-100', 'opacity-0', 'opacity-100');
                    content.classList.add('scale-95', 'opacity-0');
                }
            }, 300);
        }

        function showSuccessModal(message) {
            document.getElementById('success-message').textContent = message;
            openModal('successModal');
        }

        function showErrorModal(message) {
            document.getElementById('error-message').textContent = message;
            openModal('errorModal');
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

        // Close modal when clicking outside (on backdrop)
        document.querySelectorAll('[id$="Modal"]').forEach(modal => {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal(this.id);
                }
            });
        });
    });
</script>
@endpush

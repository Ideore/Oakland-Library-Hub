<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function __construct()
    {
        if (!Auth::check() || Auth::user()->is_admin != 1) {
            abort(redirect('/dashboard')->with('swal', [
                'type' => 'error',
                'title' => 'Akses Ditolak',
                'text' => 'Kamu bukan admin.'
            ]));
        }
    }

    public function index()
    {
        // Total unique book titles
        $totalBooks = Book::count();
        
        // Total available copies across all books
        $availableBooks = Book::sum('available_copies');
        
        // Total members registered
        $totalMembers = \App\Models\Member::count();
        
        // Active members (members who have unreturned books)
        $activeMembers = \App\Models\Member::whereHas('activeBorrowings')->count();

        // Get all borrowings to calculate statuses exactly like in Book Activity page
        $allBorrowings = Borrowing::all();
        
        $borrowedBooks = 0;      // Not returned AND not past return date
        $overdueBooks = 0;       // Not returned AND past return date  
        $returnedBooks = 0;      // Returned AND returned on or before return date
        $returnedLateBooks = 0;  // Returned AND returned after return date
        
        foreach ($allBorrowings as $borrowing) {
            $isReturned = !is_null($borrowing->returned_at);
            $isOverdue = !$isReturned && $borrowing->return_date->isPast();
            $isReturnedLate = $isReturned && $borrowing->returned_at->gt($borrowing->return_date);
            
            if ($isOverdue) {
                $overdueBooks++;
            } elseif ($isReturnedLate) {
                $returnedLateBooks++;
            } elseif ($isReturned) {
                $returnedBooks++;
            } else {
                $borrowedBooks++;
            }
        }

        $books = Book::all();

        // Get borrowings per day for the last 7 days
        $borrowingsPerDay = Borrowing::selectRaw('DATE(borrow_date) as date, COUNT(*) as count')
            ->where('borrow_date', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Fill in missing days with 0
        $last7Days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $count = $borrowingsPerDay->firstWhere('date', $date)->count ?? 0;
            $last7Days->push([
                'date' => now()->subDays($i)->format('M d'),
                'count' => $count
            ]);
        }

        // Total unreturned books for the stats card (includes both borrowed and overdue)
        $totalUnreturnedBooks = Borrowing::whereNull('returned_at')->count();

        return view('admin.home.dashboard', compact(
            'totalBooks',
            'availableBooks',
            'borrowedBooks',
            'totalUnreturnedBooks',
            'totalMembers',
            'activeMembers',
            'overdueBooks',
            'returnedLateBooks',
            'returnedBooks',
            'books',
            'last7Days'
        ));
    }

    public function borrowings()
    {
        $borrowings = Borrowing::with(['member', 'book'])
            ->orderBy('borrow_date', 'desc')
            ->get();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    public function returnBook(Borrowing $borrowing)
    {
        if ($borrowing->returned_at) {
            return response()->json([
                'message' => 'This book has already been returned'
            ], 400);
        }

        $borrowing->update([
            'returned_at' => now()
        ]);

        // Increase available copies
        $borrowing->book->increment('available_copies');

        return response()->json([
            'message' => 'Book has been returned successfully'
        ]);
    }
}

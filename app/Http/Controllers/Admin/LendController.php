<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Member;
use App\Models\Borrowing;
use Illuminate\Http\Request;

class LendController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return view('admin.lend.index', compact('books'));
    }

    public function findMember(Request $request)
    {
        $request->validate([
            'member_id' => 'required|string'
        ]);

        $member = Member::where('member_id', $request->member_id)->first();

        if (!$member) {
            return response()->json([
                'success' => false,
                'message' => 'Member not found. Please check the ID number.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'member' => $member
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'borrow_date' => 'required|date',
            'return_date' => 'required|date|after_or_equal:borrow_date',
        ]);

        $book = Book::findOrFail($validated['book_id']);
        
        if ($book->available_copies <= 0) {
            return redirect()->route('admin.lend.index')
                ->with('error', 'No copies available for this book!');
        }

        Borrowing::create($validated);
        
        // Decrease available copies
        $book->decrement('available_copies');

        return redirect()->route('admin.lend.index')
            ->with('success', 'Book lent successfully!');
    }
}

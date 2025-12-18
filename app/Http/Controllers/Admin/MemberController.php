<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::withCount([
            'borrowings',
            'activeBorrowings'
        ])->get();
        
        return view('admin.members.index', compact('members'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'member_id' => 'required|unique:members,member_id',
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'address' => 'required|string',
                'email' => 'required|email|unique:members,email',
                'contact_number' => 'required|string|max:255',
            ], [
                'member_id.required' => 'Member ID is required.',
                'member_id.unique' => 'This Member ID is already taken. Please choose a different ID.',
                'email.unique' => 'This email address is already registered. Please use a different email.',
                'email.email' => 'Please enter a valid email address.',
            ]);

            Member::create($validated);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Member added successfully!']);
            }

            return redirect()->route('admin.members.index')
                ->with('success', 'Member added successfully!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
    }

    public function update(Request $request, Member $member)
    {
        try {
            $validated = $request->validate([
                'member_id' => 'required|unique:members,member_id,' . $member->id,
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'address' => 'required|string',
                'email' => 'required|email|unique:members,email,' . $member->id,
                'contact_number' => 'required|string|max:255',
            ], [
                'member_id.required' => 'Member ID is required.',
                'member_id.unique' => 'This Member ID is already taken. Please choose a different ID.',
                'email.unique' => 'This email address is already registered. Please use a different email.',
                'email.email' => 'Please enter a valid email address.',
            ]);

            $member->update($validated);

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Member updated successfully!']);
            }

            return redirect()->route('admin.members.index')
                ->with('success', 'Member updated successfully!');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Member deleted successfully!');
    }
}

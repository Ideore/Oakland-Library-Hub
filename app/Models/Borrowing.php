<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;
    protected $fillable = ['member_id', 'book_id', 'borrow_date', 'return_date', 'returned_at'];

    protected $casts = [
        'borrow_date' => 'date',
        'return_date' => 'date',
        'returned_at' => 'date',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}

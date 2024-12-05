<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookBorrowing extends Model
{

    protected $table = 'book_borrowings';

    protected $with = ['user', 'book'];

    protected $fillable = [
        'user_id',
        'book_id',
        'from',
        'to'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function book()
    {
        return $this->belongsTo(Book::class, 'book_id', 'id');
    }

}

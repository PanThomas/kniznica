<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'isbn',
        'title',
        'author',
        'borrowed',
    ];

    protected $with = ['readers'];

    public function readers(): BelongsToMany
    {
        return $this->belongsToMany(Reader::class)->withPivot('borrow_date', 'return_date');
    }
}

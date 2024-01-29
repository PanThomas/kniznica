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

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('author', 'like', '%' . $search . '%')
                    ->orWhere('isbn', 'like', '%' . $search . '%')
            )
        );

        $query->when(
            $filters['borrowed'] ?? false,
            function ($query, $borrowed) {
                switch ($borrowed) {
                    case "no":
                        $query->where('borrowed', false);
                        break;
                    case "yes":
                        $query->where('borrowed', true);
                        break;
                    default:
                        break;
                }
            }
        );
    }

    public function readers(): BelongsToMany
    {
        return $this->belongsToMany(Reader::class)->withPivot('borrow_date', 'return_date');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Reader extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'surname',
        'birthday',
        'id_card',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters['search'] ?? false,
            fn ($query, $search) =>
            $query->where(
                fn ($query) =>
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('surname', 'like', '%' . $search . '%')
                    ->orWhere('id_card', 'like', '%' . $search . '%')
            )
        );
    }

    public function getFullnameAttribute(){
        return $this->name . ' ' . $this->surname;
    }

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class)->withPivot('borrow_date', 'return_date');
    }
}

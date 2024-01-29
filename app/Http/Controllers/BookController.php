<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::query()
        ->filter(request(['search', 'borrowed']))
        ->orderBy('title')
        ->paginate(10)
        ->withQueryString();

        return view('books.index', compact('books'));
    }

    public function create()
    {
        return view('books.create');
    }

    public function store()
    {
        Book::create(array_merge($this->validateBook(), [
            'borrowed' => 0,
        ]));

        return redirect(route('books.index'));
    }

    public function edit(Book $book)
    {
        return view('books.edit', ['book' => $book]);
    }

    public function update(Book $book)
    {
        $attributes = $this->validateBook($book);

        $book->update($attributes);

        return back()->with('success', 'Kniha upravená!');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return back()->with('success', 'Kniha odstránená!');
    }

    protected function validateBook(?Book $book = null): array
    {
        $book ??= new Book();

        return request()->validate([
            'title' => 'required',
            'author' => 'required',
            'isbn' => ['required', Rule::unique('books', 'isbn')->ignore($book)],
        ]);
    }
}

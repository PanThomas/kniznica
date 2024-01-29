<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Reader;
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

    public function showAssignPage(Book $book)
    {
        $readers = Reader::orderBy('surname')->get();

        return view('books.assign', compact('book', 'readers'));
    }

    public function assignBookToReader(Request $request, Book $book)
    {
        if ($book->borrowed) {
            return redirect()->back()->with('error', 'Kniha je už požičaná.');
        }

        $readerId = $request->input('reader_id');

        $reader = Reader::findOrFail($readerId);
        $reader->books()->attach($book, ['borrow_date' => now()]);

        $book->update(['borrowed' => true]);

        return redirect()->back()->with('success', 'Kniha bola požičaná.');
    }

    public function returnBook(Request $request, Book $book)
    {
        if (!$book->borrowed) {
            return redirect()->back()->with('error', 'Kniha nie je požičaná.');
        }

        $readerId = $request->input('reader_id');
        $reader = Reader::findOrFail($readerId);

        $pivotRecord = $reader->books()->where('book_id', $book->id)->first()->pivot;

        $pivotRecord->update(['return_date' => now()]);

        $book->update(['borrowed' => false]);

        return redirect()->back()->with('success', 'Kniha bola vrátená.');
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

        return redirect(route('books.index'))->with('success', 'Kniha pridaná!');
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

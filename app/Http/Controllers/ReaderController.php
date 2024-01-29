<?php

namespace App\Http\Controllers;

use App\Models\Reader;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReaderController extends Controller
{
    public function index()
    {
        $readers = Reader::query()
            ->filter(request(['search']))
            ->orderBy('surname')
            ->paginate(10)
            ->withQueryString();

        return view('readers.index', compact('readers'));
    }

    public function create()
    {
        return view('readers.create');
    }

    public function store()
    {
        $validatedData = $this->validateReader();
        Reader::create($validatedData);

        return redirect(route('readers.index'))->with('success', 'Čitateľ pridaný!');
    }

    public function edit(Reader $reader)
    {
        return view('readers.edit', ['reader' => $reader]);
    }

    public function update(Reader $reader)
    {
        $attributes = $this->validateReader($reader);

        $reader->update($attributes);

        return back()->with('success', 'Čitateľ upravený!');
    }

    public function destroy(Reader $reader)
    {
        $reader->delete();
        return back()->with('success', 'Čitateľ odstránený!');
    }

    protected function validateReader(?Reader $reader = null): array
    {
        $reader ??= new Reader();

        return request()->validate([
            'name' => 'required',
            'surname' => 'required',
            'birthday' => ['required', 'date'],
            'id_card' => ['required', Rule::unique('readers', 'id_card')->ignore($reader)],
        ]);
    }
}

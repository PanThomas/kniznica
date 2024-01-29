<x-layout>
    <form method="POST" action="{{ route('books.update', $book) }}" class="mx-auto max-w-md">
        @csrf
        @method('PATCH')

        <div class="border-b border-gray-900/10 pb-12 space-y-4">
            <x-form.input name="title" :value="old('title', $book->title)" required />
            <x-form.input name="author" :value="old('author', $book->author)" required />
            <x-form.input name="isbn" :value="old('isbn', $book->isbn)" required />
        </div>

        <div class="mt-6 flex items-center justify-center gap-x-6">
            <a href="{{route('books.index')}}" class="text-sm font-semibold leading-6 text-gray-900">Zrušiť</a>
            <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Upraviť</button>
        </div>

    </form>

</x-layout>

<x-layout>

    <script>
        $(document).ready(function() {
            $("#reader").select2({
                placeholder: "Vybrať čitateľa",
            });
        });
    </script>

    <section class="container px-4 mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6 max-w-md mx-auto">
            <div class="text-center">
                <h2 class="text-2xl font-semibold mb-4">{{ $book->title }}</h2>
            </div>

            <div class="mt-6">
                <p class="text-sm text-gray-500">Autor: {{ $book->author }}</p>
                <p class="text-sm text-gray-500">ISBN: {{ $book->isbn }}</p>
                <p class="text-sm text-gray-500">Požičaná: {{ $book->borrowed ? 'áno' : 'nie' }}</p>

                @if ($book->borrowed)
                    <p class="text-sm text-gray-500">Komu: {{ $book->readers->last()->fullname }}</p>
                    <p class="text-sm text-gray-500">Dátum požičania:
                        {{ date('d.m.Y', strtotime($book->readers->last()->pivot->borrow_date)) }}</p>
                @endif
            </div>
            @if (!$book->borrowed)
                <div class="mt-6">
                    <form method="POST" action="{{ route('books.assign', ['book' => $book->id]) }}">
                        @csrf
                        <div class="flex justify-around">
                            <select name="reader_id" id="reader" class="js-select2" required>
                                <option></option>
                                @foreach ($readers as $reader)
                                    <option value="{{ $reader->id }}">{{ $reader->fullname }}
                                        ({{ $reader->id_card }})
                                    </option>
                                @endforeach
                            </select>
                            <button
                                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                                type="submit">Požičiať</button>
                        </div>
                    </form>
                </div>
            @endif

        </div>
    </section>

</x-layout>

<x-layout>
    <form method="POST" action="{{ route('readers.store') }}" class="mx-auto max-w-md">
        @csrf

        <div class="border-b border-gray-900/10 pb-12 space-y-4">
            <x-form.input name="name" required />
            <x-form.input name="surname" required />
            <x-form.input name="birthday" type="date" required />
            <x-form.input name="id_card" required />
        </div>

        <div class="mt-6 flex items-center justify-center gap-x-6">
            <a href="{{route('readers.index')}}" class="text-sm font-semibold leading-6 text-gray-900">Zrušiť</a>
            <button type="submit"
                class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Pridať</button>
        </div>

    </form>

</x-layout>

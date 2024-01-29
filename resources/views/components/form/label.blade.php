@props(['name'])

<label for="{{ $name }}" class="block mb-2 text-sm font-medium leading-6 text-gray-900">
    {{ ucwords($name) }}
</label>

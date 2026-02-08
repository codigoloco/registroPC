@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-900 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:bg-gray-200 dark:focus:bg-gray-700 transition duration-150 ease-in-out rounded-md'
            : 'flex items-center px-4 py-2 text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:bg-gray-50 dark:focus:bg-gray-700 transition duration-150 ease-in-out rounded-md';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>

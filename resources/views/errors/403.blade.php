<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="text-center p-8 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg border-t-4 border-red-500 max-w-md w-full">
            <div class="mb-4 text-red-600 dark:text-red-400">
                <svg class="mx-auto h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 15c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
            
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                Acceso Restringido
            </h1>
            
            <p class="text-gray-600 dark:text-gray-400 mb-6">
                Su usuario no cuenta con privilegios para esta acción.
            </p>

            <div class="flex justify-center">
                <a href="{{ url()->previous() == url()->current() ? route('dashboard') : url()->previous() }}" 
                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>

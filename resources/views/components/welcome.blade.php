<div class="p-6 lg:p-8 bg-white border-b border-gray-200">
    <h1 class="mt-8 text-2xl font-medium text-gray-900">
        Welcome {{ auth()->user()->name }} to your dashboard!
    </h1>

    <button
        type="button"
        class="mt-6 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
        wire:click="$emit('openPasswordConfirmModal')"
    >
        Go to Services Panel
    </button>

</div>

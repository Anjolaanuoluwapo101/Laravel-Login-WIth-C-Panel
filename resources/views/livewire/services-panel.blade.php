
<div class="p-6 bg-white shadow-md rounded-xl max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold mb-4 text-center md:text-left">Service Management</h2>

    <!-- SUCCESS FLASH -->
    @if (session()->has('success'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- SEARCH + FILTER -->
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-4">
        <input wire:model.debounce.500ms="search"
            type="text"
            placeholder="Search by name"
            class="border rounded px-4 py-2 w-full md:w-1/3" />

        <select wire:model="filterType"
            class="border rounded px-4 py-2 w-full md:w-1/4">
            <option value="">All Types</option>
            <option value="mutual_fund">Mutual Fund</option>
            <option value="sip">SIP</option>
            <option value="insurance">Insurance</option>
        </select>

        <button wire:click="create"
            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 w-full md:w-auto">
            Add New
        </button>
    </div>

    <!-- FORM -->
    <div class="mb-6 border p-4 rounded bg-gray-50">
        <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
            <div class="grid md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block mb-1 font-medium">Name</label>
                    <input type="text" wire:model="name" class="w-full border px-3 py-2 rounded" />
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block mb-1 font-medium">Type</label>
                    <select wire:model="type" class="w-full border px-3 py-2 rounded">
                        <option value="">Select Type</option>
                        <option value="mutual_fund">Mutual Fund</option>
                        <option value="sip">SIP</option>
                        <option value="insurance">Insurance</option>
                    </select>
                    @error('type') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Description</label>
                <textarea wire:model="description" rows="3" class="w-full border px-3 py-2 rounded"></textarea>
                @error('description') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex items-center gap-2 mb-4">
                <input type="checkbox" wire:model="status" id="status"
                    class="h-5 w-5 text-blue-600 border-gray-300 rounded" />
                <label for="status" class="text-sm">Active</label>
            </div>

            <button type="submit"
                class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                {{ $isEdit ? 'Update' : 'Save' }}
            </button>
        </form>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr class="bg-gray-200 text-left text-sm font-semibold">
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Type</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($services as $service)
                    <tr class="border-b text-sm">
                        <td class="px-4 py-2">{{ $service->name }}</td>
                        <td class="px-4 py-2 capitalize">{{ str_replace('_', ' ', $service->type) }}</td>
                        <td class="px-4 py-2">
                            <button wire:click="toggleStatus({{ $service->id }})"
                                class="px-3 py-1 rounded {{ $service->status ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                {{ $service->status ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <button wire:click="edit({{ $service->id }})"
                                class="text-blue-600 hover:underline">Edit</button>
                            <button wire:click="delete({{ $service->id }})"
                                onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
                                class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center px-4 py-6 text-gray-500">No services found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="mt-4">
        {{ $services->links() }}
    </div>
</div>


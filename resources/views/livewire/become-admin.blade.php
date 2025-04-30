<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded shadow">
        @if ($success)
            <div class="p-4 mb-4 text-green-700 bg-green-100 rounded">
                You are now an admin.
                <button onclick="window.location='{{ route('admin-panel') }}'" class="ml-4 px-4 py-2 bg-blue-600 text-white rounded">
                    Go to Admin Panel
                </button>
            </div>
        @else
            <h2 class="text-xl font-semibold mb-4 text-center text-gray-800">Become an Admin</h2>
            <p class="mb-6 text-center text-gray-600">Fill out the form below to request admin access.</p>
            <form wire:submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="email" class="block text-gray-700">Email</label>
                    <input wire:model.defer="email" id="email" type="email" class="w-full border rounded px-3 py-2" required>
                    @error('email') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label for="password" class="block text-gray-700">Password</label>
                    <input wire:model.defer="password" id="password" type="password" class="w-full border rounded px-3 py-2" required>
                    @error('password') <span class="text-red-600">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center">
                    <input wire:model.defer="confirm" id="confirm" type="checkbox" class="mr-2">
                    <label for="confirm" class="text-gray-700">I confirm I want to become an admin</label>
                    @error('confirm') <span class="text-red-600 ml-2">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded">Submit</button>
            </form>
        @endif
    </div>
</div>

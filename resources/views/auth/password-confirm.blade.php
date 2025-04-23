@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        <h2 class="text-xl font-semibold mb-6">Confirm Password</h2>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input id="password" name="password" type="password" required autofocus
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" />
                @error('password')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('home') }}" class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Confirm</button>
            </div>
        </form>
    </div>
</div>
@endsection

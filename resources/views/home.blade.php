@extends('layouts.app')

@section('content')
    <form class="w-full max-w-sm bg-gray-800 p-6 rounded-lg shadow-md" action="{{ route('user-parser.store') }}"
        method="POST">
        @csrf
        
        @if(isset($message) && $message)
        <div class="mb-4">
            <span class="block text-sm font-medium text-gray-200 mb-2"> {{ $message }}</span>
        </div>
        @endIf


        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-200 mb-2">Email
                Address</label>
            <input type="email" id="email" placeholder="Enter your email" name="email" value="{{ old('email') }}"
                class="w-full p-3 text-sm bg-gray-700 text-black placeholder-gray-400 rounded-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
            @error('email')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-200 mb-2">Url</label>
            <input type="text" id="name" placeholder="Enter url" name="url" value="{{ old('url') }}"
                class="w-full p-3 text-sm bg-gray-700 text-black placeholder-gray-400 rounded-lg border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400" />
            @error('url')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-blue-500 text-white font-medium py-2.5 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-offset-2">
            Submit
        </button>
    </form>
@endsection

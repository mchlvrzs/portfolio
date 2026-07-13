@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-secondary-emphasis flex items-center justify-center px-6 py-16">
    <div class="w-full max-w-md">
        <p class="text-label text-sm mb-2">Private</p>
        <h1 class="section-heading !mb-2">Inbox</h1>
        <p class="text-purple-400 text-sm mb-8">Enter the inbox password to view contact messages.</p>

        <form method="POST" action="{{ route('inbox.login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="password" class="block text-sm font-medium text-purple-600 mb-1.5">Password</label>
                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autofocus
                    class="w-full rounded-xl border border-purple-25 bg-off-white px-4 py-3 text-purple-600 focus:outline-none focus:ring-2 focus:ring-purple-200"
                >
                @error('password')
                    <p class="text-sm text-red-600 mt-2">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit" class="btn-primary w-full !rounded-xl">Open inbox</button>
        </form>

        <p class="mt-8 text-center">
            <a href="{{ route('portfolio.index') }}" class="text-sm text-purple-400 hover:text-purple-600">← Back to site</a>
        </p>
    </div>
</main>
@endsection

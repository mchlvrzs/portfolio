@extends('layouts.app')

@section('content')
<main class="min-h-screen bg-secondary-emphasis px-6 py-12 md:py-16">
    <div class="max-w-3xl mx-auto">
        <div class="flex flex-wrap items-end justify-between gap-4 mb-10">
            <div>
                <p class="text-label text-sm mb-2">Private</p>
                <h1 class="section-heading !mb-1">Contact inbox</h1>
                <p class="text-purple-400 text-sm">Messages saved from the portfolio contact form.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('portfolio.index') }}" class="text-sm text-purple-400 hover:text-purple-600">Site</a>
                <form method="POST" action="{{ route('inbox.logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-purple-400 hover:text-purple-600">Log out</button>
                </form>
            </div>
        </div>

        @if ($messages->isEmpty())
            <p class="text-purple-400">No messages yet.</p>
        @else
            <ul class="space-y-6">
                @foreach ($messages as $message)
                    <li @class([
                        'rounded-3xl border border-purple-25 bg-off-white p-6 md:p-8',
                        'opacity-70' => $message->read_at,
                    ])>
                        <div class="flex flex-wrap items-start justify-between gap-3 mb-4">
                            <div>
                                <p class="font-semibold text-purple-600 text-lg">{{ $message->name }}</p>
                                <a href="mailto:{{ $message->email }}" class="text-sm text-purple-400 hover:text-purple-600">
                                    {{ $message->email }}
                                </a>
                            </div>
                            <div class="text-right text-sm text-purple-400">
                                <p>{{ $message->created_at?->timezone(config('app.timezone'))->format('M j, Y g:i A') }}</p>
                                @if ($message->read_at)
                                    <p class="mt-1">Read</p>
                                @else
                                    <form method="POST" action="{{ route('inbox.read', $message) }}" class="mt-1">
                                        @csrf
                                        <button type="submit" class="text-purple-600 hover:underline">Mark as read</button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        @if (filled($message->subject))
                            <p class="text-sm font-medium text-purple-500 mb-2">{{ $message->subject }}</p>
                        @endif

                        <p class="text-purple-500 whitespace-pre-wrap leading-relaxed">{{ $message->message }}</p>
                    </li>
                @endforeach
            </ul>

            <div class="mt-10">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
</main>
@endsection

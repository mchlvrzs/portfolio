<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactInboxController extends Controller
{
    /**
     * Private inbox for contact form submissions (password-gated).
     */
    public function index(Request $request): View|RedirectResponse
    {
        if (! $this->inboxEnabled()) {
            abort(404);
        }

        if (! $request->session()->get('inbox_authenticated')) {
            return view('inbox.login');
        }

        $messages = ContactMessage::query()
            ->latest()
            ->paginate(20);

        return view('inbox.index', compact('messages'));
    }

    public function login(Request $request): RedirectResponse
    {
        if (! $this->inboxEnabled()) {
            abort(404);
        }

        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $expected = (string) config('mail.inbox_password');

        if (! hash_equals($expected, (string) $request->input('password'))) {
            return back()->withErrors(['password' => 'Incorrect password.']);
        }

        $request->session()->put('inbox_authenticated', true);

        return redirect()->route('inbox.index');
    }

    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget('inbox_authenticated');

        return redirect()->route('inbox.index');
    }

    public function markRead(Request $request, ContactMessage $message): RedirectResponse
    {
        if (! $request->session()->get('inbox_authenticated')) {
            abort(403);
        }

        if ($message->read_at === null) {
            $message->forceFill(['read_at' => now()])->save();
        }

        return back();
    }

    private function inboxEnabled(): bool
    {
        return filled(config('mail.inbox_password'));
    }
}

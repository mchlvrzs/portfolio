<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormSubmitted;
use App\Models\ContactMessage;
use App\Models\Profile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ContactController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['nullable', 'string', 'max:200'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        try {
            ContactMessage::query()->create($validated);
        } catch (Throwable $e) {
            Log::error('Contact form failed to save.', ['error' => $e->getMessage()]);

            return back()
                ->withInput()
                ->with('contact_modal', [
                    'type' => 'error',
                    'title' => 'Something went wrong',
                    'message' => 'Your message could not be saved. Please try again or reach me on WhatsApp / email.',
                ]);
        }

        $to = config('mail.contact_to')
            ?: Profile::query()->value('email');

        if (filled($to)) {
            try {
                Mail::to($to)->send(new ContactFormSubmitted($validated));
            } catch (Throwable $e) {
                Log::error('Contact form email failed to send.', [
                    'error' => $e->getMessage(),
                    'to' => $to,
                ]);

                return back()->with('contact_modal', [
                    'type' => 'error',
                    'title' => 'Message saved, email failed',
                    'message' => 'Your message was saved, but email delivery failed. Please try WhatsApp or email me directly.',
                ]);
            }
        }

        return back()->with('contact_modal', [
            'type' => 'success',
            'title' => 'Message sent',
            'message' => 'Thanks for reaching out! I\'ll get back to you soon.',
        ]);
    }
}

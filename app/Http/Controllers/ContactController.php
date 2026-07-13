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

        // Persist first — this is the source of truth on free hosts
        try {
            ContactMessage::query()->create($validated);
        } catch (Throwable $e) {
            Log::error('Contact form failed to save.', ['error' => $e->getMessage()]);

            return redirect()
                ->to(url('/').'#contact')
                ->withInput()
                ->with('contact_modal', [
                    'type' => 'error',
                    'title' => 'Something went wrong',
                    'message' => 'Your message could not be saved. Please try again or reach me on WhatsApp / email.',
                ]);
        }

        // Gmail SMTP often hangs/blocks on Render and causes HTTP 502.
        // Only send mail when explicitly enabled (local / paid SMTP / API mailer).
        if (filter_var(env('MAIL_SEND_ENABLED', false), FILTER_VALIDATE_BOOL)) {
            $to = config('mail.contact_to') ?: Profile::query()->value('email');

            if (filled($to)) {
                try {
                    Mail::to($to)->send(new ContactFormSubmitted($validated));
                } catch (Throwable $e) {
                    Log::error('Contact form email failed to send.', [
                        'error' => $e->getMessage(),
                        'to' => $to,
                    ]);
                }
            }
        } else {
            Log::info('Contact form saved (email disabled via MAIL_SEND_ENABLED).', [
                'email' => $validated['email'],
            ]);
        }

        return redirect()
            ->to(url('/').'#contact')
            ->with('contact_modal', [
                'type' => 'success',
                'title' => 'Message sent',
                'message' => 'Thanks for reaching out! I\'ll get back to you soon.',
            ]);
    }
}

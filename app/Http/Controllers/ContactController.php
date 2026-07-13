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

        // Always persist first — email is best-effort on free hosts (SMTP often blocked/slow)
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

        $to = config('mail.contact_to') ?: Profile::query()->value('email');
        $mailConfigured = filled(config('mail.mailers.smtp.username'))
            && filled(config('mail.mailers.smtp.password'));

        // Send after the redirect is prepared so a slow/blocked SMTP cannot 502 the browser
        if (filled($to) && $mailConfigured) {
            $payload = $validated;
            $recipient = $to;

            dispatch(function () use ($recipient, $payload): void {
                try {
                    Mail::to($recipient)->send(new ContactFormSubmitted($payload));
                } catch (Throwable $e) {
                    Log::error('Contact form email failed to send.', [
                        'error' => $e->getMessage(),
                        'to' => $recipient,
                    ]);
                }
            })->afterResponse();
        } else {
            Log::warning('Contact form saved but email skipped (MAIL_USERNAME / MAIL_PASSWORD not set).');
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

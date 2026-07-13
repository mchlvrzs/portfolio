<x-mail::message>
# New contact form message

Someone reached out through your portfolio contact form.

**Name:** {{ $name }}

**Email:** {{ $email }}

@if ($subject)
**Subject:** {{ $subject }}
@endif

**Message:**

{{ $body }}

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>

<x-mail::message>

Dear  {{ $email }}

your valdate code is
<x-mail::button :url="''">
{{ $code }}
</x-mail::button>

Thanks,<br>
{{-- {{ config('app.name') }} --}}
dafter
</x-mail::message>

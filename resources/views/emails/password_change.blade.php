<x-mail::message>
    # Your Account Password Is Changed

    Your account on platform {{ config('app.name') }} has just changed its password. If you did, please ignore
    this email, but if not, secure your account immediately.

    <x-mail::button :url="$url">
        Secure Your Account
    </x-mail::button>

    Thanks,
    {{ config('app.name') }}
</x-mail::message>

<x-layouts.auth>
    <div class="text-gray-700 text-sm mb-4">
        {{ __('Before proceeding, please check your email for a verification link.') }}  
        {{ __('If you did not receive the email, you can request another.') }}
    </div>

    @if (session('resent'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm font-medium">
            {{ __('A fresh verification link has been sent to your email address.') }}
        </div>
    @endif

    <form method="POST" action="{{ route('verification.resend') }}" class="mt-6">
        @csrf
        <x-primary-button class="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">
            {{ __('Resend Verification Email') }}
        </x-primary-button>
    </form>
</x-layouts.auth>

<x-layouts.auth>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you. If you didn’t receive it, we’ll gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm font-medium">
            {{ __('A new verification link has been sent to your email address.') }}
        </div>
    @endif

    <div class="mt-6 flex justify-between items-center">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">
                {{ __('Resend Email') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="text-sm text-gray-600 hover:text-indigo-700 transition ease-in-out duration-150">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-layouts.auth>

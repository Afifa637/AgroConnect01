<x-layouts.auth>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? Enter your email to get a reset link.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 text-sm font-medium">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Action -->
        <div class="flex justify-end">
            <x-primary-button class="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">
                {{ __('Send Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-layouts.auth>

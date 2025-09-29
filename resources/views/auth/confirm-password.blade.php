<x-layouts.auth>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="mt-1 w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Action -->
        <div class="flex justify-end">
            <x-primary-button class="px-6 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white">
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-layouts.auth>

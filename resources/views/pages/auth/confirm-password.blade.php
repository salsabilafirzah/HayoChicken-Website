<x-layouts.auth :title="__('Confirm Password')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h2 class="text-xl font-bold text-gray-800">{{ __('Confirm Password') }}</h2>
            <p class="text-sm text-gray-500 mt-2">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
        </div>

        <form method="POST" action="{{ route('password.confirm') }}" class="flex flex-col gap-6">
            @csrf

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Password') }}</label>
                <input type="password" name="password" required autocomplete="current-password" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-red-600 transition shadow-sm">
                @error('password') <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-black py-4 rounded-2xl shadow-xl hover:bg-red-700 transition transform hover:-translate-y-1 active:scale-95">
                {{ __('Confirm') }}
            </button>
        </form>
    </div>
</x-layouts.auth>

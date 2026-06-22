<x-layouts.auth :title="__('Two-factor Confirmation')">
    <div x-data="{ recovery: false }" class="flex flex-col gap-6">
        <div class="text-center">
            <h2 class="text-xl font-bold text-gray-800">{{ __('Two-factor Confirmation') }}</h2>
            <p class="text-sm text-gray-500 mt-2" x-show="! recovery">{{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}</p>
            <p class="text-sm text-gray-500 mt-2" x-show="recovery">{{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}</p>
        </div>

        <form method="POST" action="{{ route('two-factor.login') }}" class="flex flex-col gap-6">
            @csrf

            <div class="space-y-2" x-show="! recovery">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Code') }}</label>
                <input type="text" name="code" inputmode="numeric" autofocus autocomplete="one-time-code" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-red-600 transition shadow-sm">
            </div>

            <div class="space-y-2" x-show="recovery">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest">{{ __('Recovery Code') }}</label>
                <input type="text" name="recovery_code" autocomplete="one-time-code" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-red-600 transition shadow-sm">
            </div>

            <div class="flex flex-col gap-4">
                <button type="submit" class="w-full bg-red-600 text-white font-black py-4 rounded-2xl shadow-xl hover:bg-red-700 transition transform hover:-translate-y-1 active:scale-95">
                    {{ __('Log in') }}
                </button>

                <button type="button" class="text-xs font-bold text-red-600 uppercase tracking-widest hover:underline" x-show="! recovery" x-on:click="recovery = true; $nextTick(() => { $refs.recovery_code.focus() })">
                    {{ __('Use a recovery code') }}
                </button>

                <button type="button" class="text-xs font-bold text-red-600 uppercase tracking-widest hover:underline" x-show="recovery" x-on:click="recovery = false; $nextTick(() => { $refs.code.focus() })">
                    {{ __('Use an authentication code') }}
                </button>
            </div>
        </form>
    </div>
</x-layouts.auth>

<x-layouts.auth :title="__('Reset Password')">
    <div class="flex flex-col gap-8">
        <div class="text-center">
            <h2 class="text-2xl font-black text-gray-800">{{ __('Reset Password') }}</h2>
            <p class="text-gray-400 text-sm mt-1">{{ __('Please enter your new password below') }}</p>
        </div>

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">{{ __('Email address') }}</label>
                <input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-red-600 transition shadow-sm">
                @error('email') <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">{{ __('Password') }}</label>
                <input type="password" name="password" required autocomplete="new-password" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-red-600 transition shadow-sm">
                @error('password') <p class="text-red-500 text-xs mt-1 italic">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-2">
                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">{{ __('Confirm Password') }}</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password" class="w-full bg-gray-50 border-none rounded-2xl p-4 text-gray-800 placeholder-gray-300 focus:ring-2 focus:ring-red-600 transition shadow-sm">
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-black py-4 rounded-2xl shadow-xl hover:bg-red-700 transition transform hover:-translate-y-1 active:scale-95 mt-2">
                {{ __('Reset password') }}
            </button>
        </form>
    </div>
</x-layouts.auth>

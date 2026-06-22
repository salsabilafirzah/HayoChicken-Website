<x-layouts.auth :title="__('Verify Email')">
    <div class="flex flex-col gap-6">
        <div class="text-center text-sm text-gray-500">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="bg-green-50 text-green-600 p-4 rounded-2xl text-sm font-medium border border-green-100 italic text-center">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="flex flex-col gap-4">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="w-full bg-red-600 text-white font-black py-4 rounded-2xl shadow-xl hover:bg-red-700 transition transform hover:-translate-y-1 active:scale-95">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}" class="text-center">
                @csrf
                <button type="submit" class="text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-red-600 transition">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-layouts.auth>

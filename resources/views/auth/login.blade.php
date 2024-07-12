<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3" id="signInBtn">
                {{ __('Log in') }}
            </x-primary-button>

            <!-- recaptcha -->
            @if($recaptchaConfig['is_active'])
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">
            @endif
        </div>
    </form>

    @if($recaptchaConfig['is_active'])
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://www.google.com/recaptcha/api.js?render={{$recaptchaConfig['site_key']}}"></script>
        <script>
            "use strict";
            $('#signInBtn').click(function (e) {
                e.preventDefault();
                grecaptcha.ready(function () {
                    grecaptcha.execute('{{$recaptchaConfig['site_key']}}', {action: 'submit'}).then(function (token) {
                        document.getElementById('g-recaptcha-response').value = token;
                        document.querySelector('form').submit();
                    });
                });
            });
        </script>
    @endif
</x-guest-layout>

<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div>
                <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="mt-4">
                <x-label for="lastname" value="{{ __('Last Name') }}" />
                <x-input id="lastname" class="block mt-1 w-full" type="text" name="lastname" :value="old('lastname')" required autocomplete="family-name" />
            </div>

            <div class="mt-4">
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            </div>

            <div class="mt-4" x-data="{ lengthOk: true }">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" x-imask="/./" />
                <span id="passwordLengthMsg" class="text-red-500 text-xs" style="display:none;">La contraseña debe tener al menos 8 caracteres.</span>
            </div>

            <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" x-imask="/./" />
            </div>

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>

        {{-- cliente-side password confirmation check --}}
        <script type="module">
            import IMask from 'imask';

            document.addEventListener('DOMContentLoaded', function () {
                const form = document.querySelector('form');
                const pwdInput = document.getElementById('password');
                const msg = document.getElementById('passwordLengthMsg');

                function checkLength() {
                    if (pwdInput.value.length < 8) {
                        msg.style.display = 'block';
                    } else {
                        msg.style.display = 'none';
                    }
                }

                if (pwdInput) {
                    IMask(pwdInput, {
                        mask: /./,
                        lazy: true,
                        placeholderChar: '\u2000',
                        onAccept: checkLength
                    });
                    // clear error when typing
                    pwdInput.addEventListener('input', () => {
                        msg.style.display = 'none';
                        msg.textContent = '';
                    });
                }

                form.addEventListener('submit', function (e) {
                    const pwd = pwdInput.value;
                    const confirm = document.getElementById('password_confirmation').value;
                    // reset message
                    msg.style.display = 'none';
                    msg.textContent = '';

                    if (pwd.length < 8) {
                        e.preventDefault();
                        msg.textContent = 'La contraseña debe tener al menos 8 caracteres.';
                        msg.style.display = 'block';
                        return;
                    }

                    if (pwd !== confirm) {
                        e.preventDefault();
                        msg.textContent = 'Las contraseñas no coinciden.';
                        msg.style.display = 'block';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Las contraseñas no coinciden.'
                        });
                    }
                });
            });
        </script>
    </x-authentication-card>
</x-guest-layout>

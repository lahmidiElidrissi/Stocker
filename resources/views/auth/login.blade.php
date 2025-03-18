<x-guest-layout>
        <x-jet-authentication-card>
            <x-slot name="logo">
                <img class="image-logo" src="images\logo.png" width="140px" style="margin-bottom: 40px">
            </x-slot>

            <x-jet-validation-errors class="mb-4" />

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
             <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-jet-label for="email" value="{{ __('Email') }}" />
                    <x-jet-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                </div>

                <div class="mt-4">
                    <x-jet-label for="password" value="{{ __('Mot de passe') }}" />
                    <x-jet-input id="password" class="block mt-1 w-full " type="password" name="password" required autocomplete="current-password" />
                </div>


                <div style="display:flex">
                    <button class="btn btn-login " type="submit" style="flex: 1; margin: 5% 25% 5% 25%;">
                        Log in
                    </button><br>
                </div >
                        <div >
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif



                </div>
            </form>
             </div>
        </x-jet-authentication-card>
    </x-guest-layout>

<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ route('login') }}">
               <img src="{{url('/images/svd-logo.png')}}" alt="Spoločnosť Božieho Slova"/>
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <div class="errors-wrap">
            <!-- Validation Errors -->
            <x-auth-validation-errors class="mb-4" :errors="$errors" />
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Address -->
            <div class="input-wrap">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="input-wrap">
                <x-label for="password" :value="__('Heslo')" />

                <x-input id="password" class=""
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <div class="submit-wrap">
                <x-button>
                    {{ __('Prihlásiť sa') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

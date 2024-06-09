<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <h3>Sign IN to Smarteye</h3>
        <!-- Email Address -->
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="identifier" id="identifier" placeholder="Masukan Email atau Nama" autofocus>
            <label for="identifier">Email | Nama</label>
        </div>

        <!-- Password -->
        <div class="form-floating">
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" autocomplete="current-password">
            <label for="password">Password</label>
        </div>

        <div class="form-floating">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>

        <!-- Remember Me -->
        {{-- <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
        </label>
        </div> --}}

        {{-- <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
        {{ __('Forgot your password?') }}
        </a>
        @endif

        <x-primary-button class="ml-3">
            {{ __('Log in') }}
        </x-primary-button>
        </div> --}}
    </form>
</x-guest-layout>

@extends('auth.layout')

@section('scripts')
    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/6ba04a10bf.js" crossorigin="anonymous"></script>
@endsection

@section('content')
    <form method="post" action="{{ route('login') }}" class="box">
        @csrf

        <div class="field has-text-centered">
            <img src="{{ asset('logo.svg') }}" width="200" alt="{{ config('app.name') }}">
        </div>

        <div class="field">
            <label for="email" class="label">{{ __('Email') }}</label>

            <div class="control has-icons-left">
                <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>

            @error('email')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="password" class="label">{{ __('Password') }}</label>

            <div class="control has-icons-left">
                <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="current-password">

                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </div>

            @error('password')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="remember" class="checkbox">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                {{ __('Remember me') }}
            </label>
        </div>

        <div class="field">
            <button class="button is-primary is-fullwidth">
                {{ __('Log in') }}
            </button>
        </div>

        @if (Route::has('password.request'))
            <div class="field is-size-7">
                <a href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            </div>
        @endif
    </form>
@endsection

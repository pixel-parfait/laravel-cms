@extends('auth.layout')

@section('scripts')
    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/6ba04a10bf.js" crossorigin="anonymous"></script>
@endsection

@section('content')
    <form method="post" action="{{ route('password.update') }}" class="box">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">

        <div class="field has-text-centered">
            <img src="{{ asset('logo.svg') }}" width="200" alt="{{ config('app.name') }}">
        </div>

        <h1 class="title is-4">
            {{ __('Reset Password') }}
        </h1>

        <div class="field">
            <label for="email" class="label">{{ __('Email') }}</label>

            <div class="control has-icons-left">
                <input id="email" type="email" class="input @error('email') is-danger @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

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
                <input id="password" type="password" class="input @error('password') is-danger @enderror" name="password" required autocomplete="new-password">

                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </div>

            @error('password')
                <p class="help is-danger">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label for="password-confirm" class="label">{{ __('Confirm password') }}</label>

            <div class="control has-icons-left">
                <input id="password-confirm" type="password" class="input" name="password_confirmation" required autocomplete="new-password">

                <span class="icon is-small is-left">
                    <i class="fas fa-lock"></i>
                </span>
            </div>
        </div>

        <div class="field">
            <button class="button is-primary">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
@endsection

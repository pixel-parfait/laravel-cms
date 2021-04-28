@extends('auth.layout')

@section('scripts')
    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/6ba04a10bf.js" crossorigin="anonymous"></script>
@endsection

@section('content')
    <form method="post" action="{{ route('password.confirm') }}" class="box">
        @csrf

        <div class="field has-text-centered">
            <img src="{{ asset('logo.svg') }}" width="200" alt="{{ config('app.name') }}">
        </div>

        <h1 class="title is-4">
            {{ __('Please confirm your password before continuing.') }}
        </h1>

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
            <button class="button is-primary">
                {{ __('Confirm password') }}
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

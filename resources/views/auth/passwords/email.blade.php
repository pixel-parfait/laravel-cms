@extends('auth.layout')

@section('scripts')
    {{-- Fontawesome --}}
    <script src="https://kit.fontawesome.com/6ba04a10bf.js" crossorigin="anonymous"></script>
@endsection

@section('content')
    <form method="post" action="{{ route('password.email') }}" class="box">
        @csrf

        <div class="field has-text-centered">
            <img src="{{ asset('logo.svg') }}" width="200" alt="{{ config('app.name') }}">
        </div>

        <h1 class="title is-4">
            {{ __('Reset password') }}
        </h1>

        @if (session('status'))
            <div class="notification is-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

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
            <button class="button is-primary">
                {{ __('Send Password Reset Link') }}
            </button>
        </div>
    </form>
@endsection

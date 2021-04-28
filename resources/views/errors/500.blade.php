@extends('layout.master')

@section('body_class', 'error error-500')

@section('content')
    <section class="section is-medium">
        <div class="container is-narrow has-text-centered">
            <h1 class="title is-1">
                @lang('errors.error_500.title')
            </h1>

            <div class="subtitle is-4">
                @lang('errors.error_500.subtitle')
            </div>

            <a class="button" href="{{ route('home') }}">
                @lang('buttons.back_to_home')
            </a>
        </div>
    </section>
@endsection

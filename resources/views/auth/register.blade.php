@extends('partials.master')

@section('content')
<div class="padded-a">
    <h1>{{ __('Register') }}</h1>
    <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        @include('auth.register-fields')

        <div class="form-group">
            <button type="submit">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
<link href="{{ asset('css/nice-forms.css') }}" rel="stylesheet">
@endsection

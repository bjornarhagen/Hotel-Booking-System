@extends('partials.master')

@section('content')

<h1>{{ __('Reset Password') }}</h1>
@if (session('status'))
    <p>{{ session('status') }}</p>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="form-group">
        <label for="email">{{ __('E-Mail Address') }}</label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
    </div>

    <div class="form-group">
        <button type="submit">
            {{ __('Send Password Reset Link') }}
        </button>
    </div>
</form>

@endsection

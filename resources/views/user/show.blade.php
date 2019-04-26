@extends('partials.master')

@section('content')
<h1>{{ __('User') }} — {{ $user->name }}</h1>

<form action="{{ route('user.update') }}" method="post">
    @csrf

    <fieldset>
        <legend>{{ __('User info') }}</legend>
        <div class="form-group">
            <label for="user-update-form-name">{{ __('Name') }}</label>
            <input id="user-update-form-name" type="text" name="name" value="{{ $user->name }}">
        </div>
        <div class="form-group">
            <label for="user-update-form-email">{{ __('Email') }}</label>
            <input id="user-update-form-email" type="email" name="email" value="{{ $user->email }}">
        </div>
    </fieldset>
    <fieldset>
        <legend>{{ __('Change password') }}</legend>
        <div class="form-group">
            <label for="user-update-form-password">{{ __('New password') }}</label>
            <input id="user-update-form-password" type="password" name="new_password">
        </div>
        <div class="form-group">
            <label for="user-update-form-password-confirm">{{ __('Confirm new password') }}</label>
            <input id="user-update-form-password-confirm" type="password" name="new_password_confirmation">
        </div>
    </fieldset>
    <fieldset>
        <legend>{{ __('Confirm your identity') }}</legend>
        <p>{{ __('In order to save your changes, we need you to confirm your identity by writing your current password.') }}</p>

        <div class="form-group">
            <label for="user-update-form-password-current">{{ __('Current password') }}</label>
            <input id="user-update-form-password-current" type="password" name="current_password" required>
        </div>

        <div class="form-group">
            <button type="submit">{{ __('Save') }}</button>
        </div>
    </fieldset>
</form>
@endsection

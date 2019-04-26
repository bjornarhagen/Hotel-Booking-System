@extends('partials.master')

@section('content')
<div>
    <h1>{{ __('User') }} — {{ $user->name }}</h1>
    <img src="{{ $user->image->url }}" alt="{{ __(':name profile picture', ['name' => $user->name_first]) }}">
</div>

<form action="{{ route('user.update') }}" method="post" enctype=multipart/form-data>
    @csrf

    <fieldset>
        <legend>{{ __('User info') }}</legend>
        <div class="form-group">
            <label for="user-update-form-name_prefix">{{ __('Prefix') }}</label>
            <input id="user-update-form-name_prefix" list="user-update-form-name_prefix-list" type="text" name="name_prefix" value="{{ $user->name_prefix }}">
            <datalist id="user-update-form-name_prefix-list">
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Ms">Ms</option>
                <option value="Prof">Prof</option>
                <option value="Dr">Dr</option>
                <option value="Lord">Lord</option>
                <option value="Sir">Sir</option>
                <option value="1st Lt">1st Lt</option>
                <option value="Adm">Adm</option>
                <option value="Atty">Atty</option>
                <option value="Brother">Brother</option>
                <option value="Capt">Capt</option>
                <option value="Chief">Chief</option>
                <option value="Cmdr">Cmdr</option>
                <option value="Col">Col</option>
                <option value="Dean">Dean</option>
                <option value="Elder">Elder</option>
                <option value="Father">Father</option>
                <option value="Gov">Gov</option>
                <option value="Hon">Hon</option>
                <option value="Lt Col">Lt Col</option>
                <option value="MSgt">MSgt</option>
                <option value="Prince">Prince</option>
                <option value="Sister">Sister</option>
            </datalist>
        </div>
        <div class="form-group">
            <label for="user-update-form-name_first">{{ __('First name') }}</label>
            <input id="user-update-form-name_first" type="text" name="name_first" value="{{ $user->name_first }}" required>
        </div>
        <div class="form-group">
            <label for="user-update-form-name_last">{{ __('Last name') }}</label>
            <input id="user-update-form-name_last" type="text" name="name_last" value="{{ $user->name_last }}" required>
        </div>
        <div class="form-group">
            <label for="user-update-form-email">{{ __('Email') }}</label>
            <input id="user-update-form-email" type="email" name="email" value="{{ $user->email }}" required>
        </div>
        <div class="form-group">
            @if ($user->image_id !== null)
                <label for="user-update-form-image-remove" class="button">{{ __('Remove current image') }}</label>
                <input id="user-update-form-image-remove" type="checkbox" name="image_remove">
            @endif
        </div>
        <div class="form-group">
            <label for="user-update-form-image">{{ __('Image') }}</label>
            <input id="user-update-form-image" type="file" name="image" value="{{ old('image') }}">
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
    <fieldset class="hidden">
        <legend>{{ __('Confirm your identity') }}</legend>
        <p>{{ __('In order to save your changes, we need you to confirm your identity by writing your current password.') }}</p>

        <div class="form-group">
            <label for="user-update-form-password-current">{{ __('Current password') }}</label>
            <input id="user-update-form-password-current" type="password" name="current_password">
        </div>
    </fieldset>
    <div class="form-group">
        <button type="submit">{{ __('Save') }}</button>
    </div>
</form>
<script src="{{ asset('js/user.js') }}"></script>
@endsection

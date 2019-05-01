<div class="form-group">
    <label for="firstname">{{ __('First name') }}</label>
    <input id="firstname" type="text" name="firstname" value="{{ old('firstname') }}" required autofocus>
</div>

<div class="form-group">
    <label for="lastname">{{ __('Last name') }}</label>
    <input id="lastname" type="text" name="lastname" value="{{ old('lastname') }}" required>
</div>

<div class="form-group">
    <label for="email">{{ __('E-Mail Address') }}</label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
</div>

<div class="form-group">
    <label for="password">{{ __('Password') }}</label>
    <input id="password" type="password" name="password" required>
</div>

<div class="form-group">
    <label for="password-confirm">{{ __('Confirm Password') }}</label>
    <input id="password-confirm" type="password" name="password_confirmation" required>
</div>

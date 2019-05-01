@extends('partials.master')

@section('content')
<div class="padded-a">
    <h1>{{ __('Your email is now verified') }}</h1>

    <div>
        <p>{{ __('Your email was correctly verified') }}.</p>
        <p>{{ __('Continue to') }} <a href="{{ route('dashboard.index') }}">{{ __('dashboard') }}</a>.</p>
    </div>
</div>
@endsection

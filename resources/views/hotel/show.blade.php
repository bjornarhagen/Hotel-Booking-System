@extends('partials.master')

@section('content')
    <article>
        @include('booking.show-step-1-header')

        <section class="padded-lr">
            <img src="{{ $hotel->brand_logo->url }}" alt="{{ $hotel->name }} {{ __('logo') }}">
            <p>{!! nl2br(htmlspecialchars($hotel->description)) !!}</p>
            <dl>
                @if ($hotel->website !== null)
                    <dt>{{ __('Website') }}</dt>
                    <dd>{{ $hotel->website }}</dd>
                @endif
                @if ($hotel->contact_phone !== null)
                    <dt>{{ __('Phone') }}</dt>
                    <dd>{{ $hotel->contact_phone }}</dd>
                @endif
                @if ($hotel->contact_email !== null)
                    <dt>{{ __('Email') }}</dt>
                    <dd>{{ $hotel->contact_email }}</dd>
                @endif
                @if ($hotel->address !== null)
                    <dt>{{ __('Address') }}</dt>
                    <dd>{{ $hotel->address }}</dd>
                    @if ($hotel->address_lat_lon !== null)
                        <dd>{{ __('Coordinates') }}: {{ $hotel->address_lat_lon }}</dd>
                    @endif
                @endif
            </dl>
        </section>
    </article>
@endsection
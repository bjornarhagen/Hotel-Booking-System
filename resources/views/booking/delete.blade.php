@extends('partials.master')

@section('content')
    <div class="padded-a">
        <header>
            <h1>{{ __('Delete :resource', ['resource' => __('booking')]) }} {{ $booking->id }}?</h1>
        </header>
        <section>
            <form action="{{ route('admin.hotel.booking.destroy', [$hotel, $booking]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('delete') }}
                <div class="form-group">
                    <a href="{{ route('admin.hotel.booking.index', $hotel) }}">{{ __('No, cancel') }}</a>
                </div>
                <div class="form-group">
                    <button type="submit">{{ __('Yes, delete') }}</button>
                </div>
            </form>
        </section>
    </div>
    <link href="{{ asset('css/nice-forms.css') }}" rel="stylesheet">
@endsection
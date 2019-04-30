@extends('partials.master')

@section('content')
    <header>
        <h1>{{ __('Delete :resource', ['resource' => __('booking')]) }} {{ $booking->id }}?</h1>
    </header>
    <section>
        <form action="{{ route('admin.hotel.booking.destroy', [$hotel, $booking]) }}" method="post">
            @csrf
            @method('delete')
            <div class="form-group">
                <a href="{{ route('admin.hotel.booking.index', $hotel) }}">{{ __('No, cancel') }}</a>
            </div>
            <div class="form-group">
                <button type="submit">{{ __('Yes, delete') }}</button>
            </div>
        </form>
    </section>
@endsection
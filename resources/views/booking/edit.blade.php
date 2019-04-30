@extends('partials.master')

@section('content')
    <header>
        <h1>{{ __('Edit :resource', ['resource' => __('booking')]) }}</h1>
    </header>
    <section>
        <form action="{{ route('admin.hotel.booking.update', [$hotel, $booking]) }}" method="post">
            @csrf
            @method('patch')
            @include('booking.form-fields')
            <div class="form-group">
                <button type="submit">{{ __('Save') }}</button>
            </div>
        </form>
    </section>
@endsection
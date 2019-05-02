@extends('partials.master')

@section('content')
    <div class="padded-a">
    <header>
        <h1>{{ __('Edit :resource', ['resource' => __('booking')]) }}</h1>
    </header>
        <section>
            <form action="{{ route('admin.hotel.booking.update', [$hotel, $booking]) }}" method="post">
                {{ csrf_field() }}
                {{ method_field('patch') }}
            @include('booking.form-fields')
            <div class="form-group">
                <button type="submit">
                    @icon('save')
                    <span>{{ __('Save') }}</span>
                </button>
            </div>
        </form>
    </section>
    </div>
    <link href="{{ asset('css/nice-forms.css') }}" rel="stylesheet">
@endsection
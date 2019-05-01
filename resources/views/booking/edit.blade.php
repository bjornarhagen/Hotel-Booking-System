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
                <button type="submit">
                    @icon('save')
                    <span>{{ __('Save') }}</span>
                </button>
            </div>
        </form>
    </section>
    <link href="{{ asset('css/nice-forms.css') }}" rel="stylesheet">
@endsection
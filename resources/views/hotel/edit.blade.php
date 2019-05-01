@extends('partials.master')

@section('content')
    <div class="padded-a">
        <header>
            <h1>{{ __('Edit :resource', ['resource' => __('hotel')]) }}</h1>
        </header>
        <section>
            <form action="{{ route('admin.hotel.update', $hotel) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                @include('hotel.form-fields')
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
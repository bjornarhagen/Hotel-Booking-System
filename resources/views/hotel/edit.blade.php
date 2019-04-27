@extends('partials.master')

@section('content')
    <header>
        <h1>{{ __('Edit :resource', ['resource' => __('hotel')]) }}</h1>
    </header>
    <section>
        <form action="{{ route('admin.hotel.update', $hotel) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            @include('hotel.form-fields')
            <div class="form-group">
                <button type="submit">{{ __('Save') }}</button>
            </div>
        </form>
    </section>
@endsection
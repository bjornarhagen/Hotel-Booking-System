@extends('partials.master')

@section('content')
    <header>
        <h1>{{ __('Add new :resource', ['resource' => __('hotel')]) }}</h1>
    </header>
    <section>
        <form action="{{ route('admin.hotel.store') }}" method="post" enctype="multipart/form-data">
            @csrf
            @include('hotel.form-fields')
            <div class="form-group">
                <button type="submit">{{ __('Save') }}</button>
            </div>
        </form>
    </section>
@endsection
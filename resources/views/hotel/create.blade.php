@extends('partials.master')

@section('content')
    <div class="padded-a">
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
    </div>
@endsection
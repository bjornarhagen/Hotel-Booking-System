@extends('partials.master')

@section('content')
    <div class="padded-a">
        <header>
            <h1>{{ __('Delete :resource', ['resource' => $hotel->name]) }}</h1>
        </header>
        <section>
            <form action="{{ route('admin.hotel.destroy', $hotel) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('delete')
                <div class="form-group">
                    <a href="{{ route('admin.hotel.index') }}">{{ __('No, cancel') }}</a>
                </div>
                <div class="form-group">
                    <button type="submit">{{ __('Yes, delete') }}</button>
                </div>
            </form>
        </section>
    </div>
    <link href="{{ asset('css/nice-forms.css') }}" rel="stylesheet">
@endsection
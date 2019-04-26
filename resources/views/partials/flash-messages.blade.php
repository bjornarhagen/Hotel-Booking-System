@if ($errors->any() || session('error') || session('warning') || session('success') || session('info'))
    <ul id="flash-messages">
        @foreach (['error', 'warning', 'success', 'info'] as $msg)
            @if (session($msg))
                <li class="flash-message-{{ $msg }}">
                    @php
                        $random_id = 'flash-message-' . md5(uniqid(rand(), true));
                    @endphp
                    <input type="checkbox" id="{{$random_id}}">
                    <label for="{{$random_id}}">{!! session($msg) !!}</label>
                </li>
            @endif
        @endforeach
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <li class="flash-message-error">
                    @php
                        $random_id = 'flash-message-' . md5(uniqid(rand(), true));
                    @endphp
                    <input type="checkbox" id="{{$random_id}}">
                    <label for="{{$random_id}}">{{ $error }}</label>
                </li>
            @endforeach
        @endif
    </ul>
@endif
